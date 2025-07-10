<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyDocument;
use App\Models\CompanyDocumentFile;
use App\Models\Competence;
use App\Models\competencies;
use App\Models\ComplaintDocument;
use App\Models\ComplaintsRecord;
use App\Models\CorrectivePreventive;
use App\Models\CorrectivePreventiveDocument;
use App\Models\InstallationAuditRecord;
use App\Models\InstallationAuditRecordDocument;
use App\Models\PersonalSkillsAndTraining;
use App\Models\ProjectDocument;
use App\Models\ProjectMeasures;
use App\Models\ProjectsFolder;
use App\Models\SkillsCourse;
use App\Models\Subcontractor;
use App\Models\SubcontractorDocument;
use App\Models\Supplier;
use App\Models\ToolCalibration;
use App\Models\ToolCalibrationDocument;
use Carbon\Carbon;
use Faker\Provider\ar_EG\Person;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; 

class InstallerRecordsController extends Controller
{
    public function projectsFolder()
    {
        $projectsFolder = ProjectsFolder::where('user_id',Auth::user()->id)->orderBy('created_at', 'desc')->get();
        $projectMeasures = DB::table('project_measures')->get(['id', 'name']);
        return view('user.projects-folder.list',compact('projectsFolder','projectMeasures'));
    }

  public function showprojectsFolderForm($id = null)
{
    $project = null;
    $projectOperatives = collect(); // default empty collection

    // Get dropdown data
    $projectMeasures = DB::table('project_measures')->get(['id', 'name']);
    $operatives = PersonalSkillsAndTraining::get(['id', 'employee_name']);
    $projectUploads = ProjectDocument::with('measure')->get();

    if ($id) {
        $project = ProjectsFolder::with([
            'complaints_records.measure',
            'complaints_records.files',
            'operatives.competencies',  // 👈 only assigned operatives with relationships
            'operatives.courses',
        ])->findOrFail($id);

        $projectOperatives = $project->operatives;
    }

    $title = 'Project Information';

    return view('user.projects-folder.create', compact(
        'project',
        'title',
        'projectMeasures',
        'operatives',
        'projectOperatives',
        'projectUploads'
    ));
}


 public function storeOrUpdate(Request $request, $id = null)
{
    
    $validated = $request->validate([
        'project_reference' => 'nullable|string|max:255',
        'customer_name' => 'nullable|string|max:255',
        'address_line_1' => 'nullable|string|max:255',
        'address_line_2' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:100',
        'county' => 'nullable|string|max:100',
        'postcode' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'land_line_number' => 'nullable|string|max:20',
        'mobile_number' => 'nullable|string|max:20',
        'retrofit_coordinator_name' => 'nullable|string|max:255',
        'retrofit_coordinator_contact_number' => 'nullable|string|max:20',
        'retrofit_coordinator_email' => 'nullable|email|max:255',
        'eem_specifier' => 'nullable|string|max:255',
        'eem_specifier_contact_name' => 'nullable|string|max:255',
        'eem_specifier_office_phone' => 'nullable|string|max:20',
        'eem_specifier_email' => 'nullable|email|max:255',
        'start_date' => 'nullable|date',
        'contract_completed_date' => 'nullable|date',
        'measures_to_be_installed' => 'nullable|array',
        'measures_to_be_installed.*' => 'string',
    ]);

    $data = $request->except('_token');
    $data['measures_to_be_installed'] = json_encode($request->measures_to_be_installed ?? []);
    $data['user_id'] = Auth::id();
    $projectMeasures = DB::table('project_measures')->get(['id', 'name']);
    if ($id) {
        $project = ProjectsFolder::findOrFail($id);
        $project->update($data);
        $project->refresh();
        return view('user.projects-folder.create', [
        'title' => 'Edit Project',
        'project' => $project,
        'projectMeasures' => $projectMeasures,
    ]);
    } else {
        $project = ProjectsFolder::create($data);
        return view('user.projects-folder.create', [
            'title' => 'Add Project',
            'project' => $project,
            'projectMeasures' => $projectMeasures,
        ]);
    }
}
public function destroyProject($id)
    {

         // 1) Find the document or 404
        $project = ProjectsFolder::findOrFail($id);

        // 2) Delete each physical file from storage
        // foreach ($document->files as $file) {
        //     if (Storage::disk('public')->exists($file->path)) {
        //         Storage::disk('public')->delete($file->path);
        //     }
        // }

        // 3) Delete the document record (cascades to file records)
        $project->delete();

        // 4) Redirect back with a flash
        return redirect()
            ->back()
            ->with('success', 'Project deleted successfully!');
    }


 public function saveProjectsOperative(Request $request, $id)
{
    // 1. Validate the request
    $request->validate([
        'operative' => 'required|exists:personal_skills_and_training,id',
        'project_measure' => 'required|exists:project_measures,id',
    ]);

    // 2. Find the project
    $project = ProjectsFolder::findOrFail($id);

    // 3. Check if already assigned
    $alreadyAssigned = $project->operatives()
        ->wherePivot('operative_id', $request->operative)
        ->wherePivot('project_measure_id', $request->project_measure)
        ->exists();

    if ($alreadyAssigned) {
        return redirect()->back()->with('error', 'Operative is already assigned to this project with the selected measure.');
    }

    // 4. Attach the operative to the project with the measure
    $project->operatives()->attach($request->operative, [
        'project_measure_id' => $request->project_measure
    ]);

    return redirect()->back()->with('success', 'Operative assigned to the project successfully.');
}
public function destroyProjectOperative($id)
    {

       DB::table('project_operatives')->where('id', $id)->delete();

    return redirect()->back()->with('success', 'Operative unassigned from project successfully!');
    }


    public function saveProjectUpload(Request $request, $id)
{
    $request->validate([
        'upload_measure' => 'required|exists:project_measures,id',
        'upload_file' => 'required|file|max:10240', // max 10MB
    ]);

    // Handle file upload
    if ($request->hasFile('upload_file')) {
        $file = $request->file('upload_file');

        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('project_uploads/' . $id, $filename, 'public');

        // Save in DB
        ProjectDocument::create([
            'project_folder_id' => $id,
            'filename' => $file->getClientOriginalName(),
            'upload_measure' => $request->upload_measure,
            'path' => $path,
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);

        return redirect()->back()->with('success', 'Document uploaded successfully!');
    }

    return redirect()->back()->with('error', 'No file uploaded.');
}

   public function destroyProjectUpload($id)
{
    // 1. Find the document or fail
    $document = ProjectDocument::findOrFail($id);

    // 2. Delete the physical file from storage
    if (Storage::disk('public')->exists($document->path)) {
        Storage::disk('public')->delete($document->path);
    }

    // 3. Delete the record from the database
    $document->delete();

    // 4. Redirect back with success message
    return redirect()->back()->with('success', 'Project document deleted successfully.');
}

    public function companyDocuments()
    {
        $companyDocuments = CompanyDocument::where('user_id',Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('user.company-documents.list',compact('companyDocuments'));
    }
    public function showCompanyDocumentForm($id = null)
    {
        $companyDocument = null;

        if ($id) {
            $companyDocument = CompanyDocument::findOrFail($id);
        }
        $title = 'GDR 11 - Company Documents';
        return view('user.company-documents.create', compact('companyDocument','title'));
    }

    public function createCompanyDocument(Request $request, $id = null)
    {
        $request->validate([
            'company_document_type' => 'required|string',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'renewal_date' => 'required|date|after_or_equal:date',
        ]);

        if ($id) {
            // Update existing document
            $companyDocument = CompanyDocument::findOrFail($id);
            $companyDocument->update([
                'type' => $request->company_document_type,
                'user_id' => auth()->id(), 
                'name' => $request->name,
                'description' => $request->description,
                'date' => $request->date,
                'renewal_date' => $request->renewal_date,
            ]);
            $message = 'Company Document updated successfully!';
        } else {
            // Create new document
            $companyDocument = CompanyDocument::create([
                'type' => $request->company_document_type,
                'user_id' => auth()->id(), 
                'name' => $request->name,
                'description' => $request->description,
                'date' => $request->date,
                'renewal_date' => $request->renewal_date,
            ]);
            $message = 'Company Document created successfully!';
        }
        $title = 'GDR 11 - Company Documents';
        return view('user.company-documents.create', compact('companyDocument', 'title', 'message'));
    }

    public function destroy($id)
    {

         // 1) Find the document or 404
        $document = CompanyDocument::with('files')->findOrFail($id);

        // 2) Delete each physical file from storage
        foreach ($document->files as $file) {
            if (Storage::disk('public')->exists($file->path)) {
                Storage::disk('public')->delete($file->path);
            }
        }

        // 3) Delete the document record (cascades to file records)
        $document->delete();

        // 4) Redirect back with a flash
        return redirect()
            ->back()
            ->with('success', 'Document and all its files deleted successfully!');
    }

   public function uploadCompanyDocument(Request $request, $documentId)
    {
        // 1) Validate the upload
        $request->validate([
            'company-document-file' => 'required|file|mimes:png,jpg,jpeg,doc,docx,pdf|max:2048',
        ]);

        // 2) Fetch the parent document
        $document = CompanyDocument::findOrFail($documentId);

        // 3) Grab the uploaded file
        $uploaded = $request->file('company-document-file');

        // 4) Build a unique filename
        $name      = pathinfo($uploaded->getClientOriginalName(), PATHINFO_FILENAME);
        $ext       = $uploaded->getClientOriginalExtension();
        $filename  = "{$document->id}_" . time() . "_" . Str::slug($name) . ".{$ext}";

        // 5) Store it on the public disk
        $path = $uploaded->storeAs('company_documents', $filename, 'public');

        // 6) Prepare metadata
        $data = [
            'company_document_id' => $document->id,
            'filename'            => $uploaded->getClientOriginalName(),
            'path'                => $path,
            'mime_type'           => $uploaded->getClientMimeType(),
            'size'                => $uploaded->getSize(),
        ];


            // 7b) Create new record
            CompanyDocumentFile::create($data);
            $message = 'File uploaded successfully!';

        // 8) Redirect back
        return redirect()
            ->back()
            ->with('success', $message);
    }
    
    public function destroyFile($documentId, $fileId)
    {
        $file = CompanyDocumentFile::where('company_document_id', $documentId)
                    ->findOrFail($fileId);
                    
        if (Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
        }
        $file->delete();
        
        return back()->with('success', 'File deleted.');
    }

    /** 
     * Download a file 
     */
    public function downloadCompanyDocument($documentId, $fileId)
    {
        $file = CompanyDocumentFile::where('company_document_id', $documentId)
                    ->findOrFail($fileId);

        return Storage::disk('public')
                      ->download($file->path, $file->filename);
    }

    
    public function subcontractors()
    {
    $subcontractors = Subcontractor::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
    return view('user.sub-contractors.list', compact('subcontractors'));
}

public function showSubcontractorForm($id = null)
{
    
    $subcontractor = $id ? Subcontractor::findOrFail($id) : null;
    $title = 'GDR 12 - Subcontractors';
    return view('user.sub-contractors.create', compact('subcontractor', 'title'));
}

public function saveSubcontractor(Request $request, $id = null)
{
    $request->validate([
        'company_name' => 'required|string|max:255',
        'email' => 'nullable|email',
    ]);
    
    $data = [
        'user_id' => Auth::id(),
        'company_name' => $request->company_name,
        'contact_name' => $request->contact_name,
        'address_1' => $request->address_1,
        'address_2' => $request->address_2,
        'address_3' => $request->address_3,
        'address_4' => $request->address_4,
        'postcode' => $request->postcode,
        'telephone' => $request->telephone,
        'fax' => $request->fax,
        'email' => $request->email,
        'approved_works' => $request->approved_works,
        'active' => $request->has('active'),
    ];
    
    if ($id) {
        $subcontractor = Subcontractor::findOrFail($id);
        $subcontractor->update($data);
        $message = 'Subcontractor updated successfully!';
    } else {
        $subcontractor = Subcontractor::create($data);
        $message = 'Subcontractor created successfully!';
    }
    
    $title = 'GDR 12 - Subcontractors';
    return view('user.sub-contractors.create', compact('subcontractor', 'title', 'message'));
}

public function destroySubcontractor($id)
{
    $subcontractor = Subcontractor::findOrFail($id);
    $subcontractor->delete();
    
    return redirect()
    ->back()
    ->with('success', 'Subcontractor deleted successfully!');
}
public function uploadSubcontractorDocument(Request $request, $subcontractorId)
{
    
    $subcontractor = Subcontractor::findOrFail($subcontractorId);
    


    $uploaded = $request->file('company-document-file');
    // 4) Build a unique filename
    $name      = pathinfo($uploaded->getClientOriginalName(), PATHINFO_FILENAME);
    $ext       = $uploaded->getClientOriginalExtension();
    $filename  = "{$subcontractor->id}_" . time() . "_" . Str::slug($name) . ".{$ext}";

        // 5) Store it on the public disk
        $path = $uploaded->storeAs('subcontractor_documents', $filename, 'public');
        // 6) Prepare metadata
        $data = [
            'subcontractor_id' => $subcontractor->id,
            'filename'            => $uploaded->getClientOriginalName(),
            'path'                => $path,
            'mime_type'           => $uploaded->getClientMimeType(),
            'size'                => $uploaded->getSize(),
        ];
        
        
        // 7b) Create new record
        SubcontractorDocument::create($data);
        $message = 'File uploaded successfully!';

        // 8) Redirect back
        return redirect()
        ->back()
        ->with('success', $message);
    }

    
    public function destroySubcontractorFile($id)
    {
        $file = SubcontractorDocument::findOrFail($id);
        
        if (Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
    }
    $file->delete();
    
    return back()->with('success', 'File deleted.');
}

public function downloadSubcontractorDocument($documentId, $fileId)
{
    $file = SubcontractorDocument::where('subcontractor_id', $documentId)
    ->findOrFail($fileId);
    
    return Storage::disk('public')
    ->download($file->path, $file->filename);
    
}

public function correctivePreventiveActions()
{
    $correctivePreventiveActions = CorrectivePreventive::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
    return view('user.corrective-preventive-actions.list', compact('correctivePreventiveActions'));
}
public function showcorrectivePreventiveForm($id = null)
{
    
    $correctivePreventiveAction = $id ? CorrectivePreventive::findOrFail($id) : null;
    $title = 'Corrective & Preventive Action Record';
    return view('user.corrective-preventive-actions.create', compact('correctivePreventiveAction', 'title'));
}
public function saveCorrectivePreventive(Request $request, $id = null)
{
    // Step 1: Validate the request
    $validated = $request->validate([
        'date' => 'required|date',
        'ncr_no' => 'required|string|max:255',
        'source' => 'required|string|max:255',
        'preventive_or_Corrective' => 'required|string',
        'issued_to' => 'required|string|max:255',
        'no_of_days' => 'required|integer',
        'status' => 'required|in:open,closed',
        'closed_date' => 'required|date',
        'closed_by' => 'required|string|max:255',
        'details_of_issue' => 'required|string',
        'summary_of_action_taken' => 'required|string',
        'root_cause' => 'required|string',
        'prevent_recurrence' => 'required|string',
    ]);

    $data = [
        'date' => $validated['date'],
        'ncr_no' => $validated['ncr_no'],
        'source' => $validated['source'],
        'preventive_or_Corrective' => $validated['preventive_or_Corrective'],
        'issued_to' => $validated['issued_to'],
        'no_of_days' => $validated['no_of_days'],
        'status' => $validated['status'],
        'date_closed' => $validated['closed_date'],
        'closed_by' => $validated['closed_by'],
        'details_of_issue' => $validated['details_of_issue'],
        'summary_of_action_taken' => $validated['summary_of_action_taken'],
        'root_cause' => $validated['root_cause'],
        'prevent_recurrence' => $validated['prevent_recurrence'],

    ];
    $data['user_id'] = Auth::id();
    $correctivePreventive = $id ? CorrectivePreventive::findOrFail($id) : null;
    if ($id) {
        $correctivePreventive->update($data);
        $message = 'Corrective/Preventive Action updated successfully.';
    } else {
        $correctivePreventive = CorrectivePreventive::create($data);
        $message = 'Corrective/Preventive Action created successfully.';
    }
    session()->flash('success', $message);
    $title = 'Corrective & Preventive Action Record';
    return redirect()
        ->route('corrective-preventive.form', $correctivePreventive->id ?? null)
        ->with('success', $message);
    
}
public function destroyCorrectivePreventive($id)
{
    $correctivePreventive = CorrectivePreventive::findOrFail($id);
    $correctivePreventive->delete();
    
    return redirect()
        ->back()
        ->with('success', 'Corrective/Preventive Action deleted successfully!');
}

 public function showCorrectivePreventiveDocuments(Request $request, $id)
    {
        $correctivePreventiveDocument = CorrectivePreventive::with('files')->findOrFail($id);
        
        return view('user.corrective-preventive-actions.documents',compact('correctivePreventiveDocument'));
    }
 
    public function uploadCorrectivePreventiveDocument(Request $request, $id)
    {
        $correctivePreventive = CorrectivePreventive::findOrFail($id);
        $uploaded = $request->file('file');
        // 4) Build a unique filename
        $name      = pathinfo($uploaded->getClientOriginalName(), PATHINFO_FILENAME);
        $ext       = $uploaded->getClientOriginalExtension();
        $filename  = "{$correctivePreventive->id}_" . time() . "_" . Str::slug($name) . ".{$ext}";

        // 5) Store it on the public disk
        $path = $uploaded->storeAs(Auth::user()->org.'/corrective_preventive', $filename, 'public');
        // 6) Prepare metadata
        $data = [
            'corrective_preventive_id' => $correctivePreventive->id,
            'filename'            => $uploaded->getClientOriginalName(),
            'path'                => $path,
            'mime_type'           => $uploaded->getClientMimeType(),
            'size'                => $uploaded->getSize(),
        ];
        
        
        // 7b) Create new record
        CorrectivePreventiveDocument::create($data);
        $message = 'File uploaded successfully!';

        // 8) Redirect back
        return redirect()
        ->back()
        ->with('success', $message);
    }

    public function correctivePreventiveDocumentDestroy($recordId, $documentId)
    {
        $correctivePreventiveRecord = CorrectivePreventive::where('user_id', Auth::id())->where('id', $recordId)->firstOrFail();
        if (!$correctivePreventiveRecord) {
            return redirect()
            ->back();
        }
        $document = CorrectivePreventiveDocument::findOrFail($documentId);
        $document->delete();
        
        return redirect()
            ->back()
            ->with('success', 'Document deleted successfully!');
    }
 

public function toolCalibrations()
{
    $toolCalibration = ToolCalibration::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
    return view('user.tool-calibrations.list', compact('toolCalibration'));
}

public function showToolCalibrationForm($id = null)
{
    
    $toolCalibration = $id ? ToolCalibration::findOrFail($id) : null;
    $title = 'GDR 04 - Tool Calibration, Checking & Servicing Record';
    return view('user.tool-calibrations.create', compact('toolCalibration', 'title'));
}


public function saveToolCalibration(Request $request, $id = null)
{
    
    // Step 1: Validate the request
    $validated = $request->validate([
        'item_of_equipment' => 'required|string',
        'serial_number' => 'required|string',
        'calibration_checking_requirements' => 'required|string',
        'measurement_ref_standard' => 'required|string',
        'date_purchased' => 'required|date',
        'date_calibrated' => 'required|date',
        'next_calibration_date' => 'required|date',
        'out_of_spec_reading_at_calibration' => 'required|string',
        'description' => 'required|string',
    ]);

    

    $validated['user_id'] = Auth::id();

    $tc = [
        'user_id' => Auth::id(),
        'item_of_equipment' => $request->item_of_equipment,
        'serial_number' => $request->serial_number,
        'description' => $request->description,
        'calibration_checking_requirements' => $request->calibration_checking_requirements,
        'measurement_ref_standard' => $request->measurement_ref_standard,
        'date_purchased' => $request->date_purchased,
        'date_calibrated' => $request->date_calibrated,
        'next_calibration_date' => $request->next_calibration_date,
        'out_of_spec_reading_at_calibration' => $request->out_of_spec_reading_at_calibration,
    ];
    
    
    
    $toolCalibration = $id ? ToolCalibration::findOrFail($id) : null;
    if ($id) {
        $toolCalibration->update($tc);
        $message = 'Tool updated successfully.';
    } else {
        $toolCalibration = ToolCalibration::create($tc);
        $message = 'Tool created successfully.';
    }

    session()->flash('success', $message);

    $title = 'GDR 04 - Tool Calibration, Checking & Servicing Record';

    return redirect()
    ->route('tool-calibration.form', $toolCalibration->id ?? null)
    ->with('success', $message);

}

public function destroyToolCalibration($id)
{
    $toolCalibration = ToolCalibration::findOrFail($id);
    $toolCalibration->delete();
    
    return redirect()
        ->back()
        ->with('success', 'Tool deleted successfully!');
    }

 public function showToolCalibrationDocuments(Request $request, $id)
    {
        $toolCalibration = ToolCalibration::with('files')->findOrFail($id);
        
        return view('user.tool-calibrations.documents',compact('toolCalibration'));
    }




public function uploadToolCalibrationDocument(Request $request, $id)
    {
        $toolCalibration = ToolCalibration::findOrFail($id);
        $uploaded = $request->file('file');
        // 4) Build a unique filename
        $name      = pathinfo($uploaded->getClientOriginalName(), PATHINFO_FILENAME);
        $ext       = $uploaded->getClientOriginalExtension();
        $filename  = "{$toolCalibration->id}_" . time() . "_" . Str::slug($name) . ".{$ext}";

        // 5) Store it on the public disk
        $path = $uploaded->storeAs(Auth::user()->org.'/tool_calibrations', $filename, 'public');
        // 6) Prepare metadata
        $data = [
            'tool_calibration_id' => $toolCalibration->id,
            'filename'            => $uploaded->getClientOriginalName(),
            'path'                => $path,
            'mime_type'           => $uploaded->getClientMimeType(),
            'size'                => $uploaded->getSize(),
        ];
        
        
        // 7b) Create new record
        ToolCalibrationDocument::create($data);
        $message = 'File uploaded successfully!';

        // 8) Redirect back
        return redirect()
        ->back()
        ->with('success', $message);
    }
    

    
    public function toolCalibrationDocumentDestroy($toolCalibrationId,$documentId)
    {
        $toolCalibration = ToolCalibration::where('user_id', Auth::id())->where('id', $toolCalibrationId)->firstOrFail();
        if (!$toolCalibration) {
            return redirect()
            ->back();
        }
        $document = ToolCalibrationDocument::findOrFail($documentId);
        $document->delete();
        
        return redirect()
            ->back()
            ->with('success', 'Document deleted successfully!');
    }
    



public function installationAuditRecords()
{
    $installationAuditRecords = InstallationAuditRecord::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
    return view('user.installation-audit.list', compact('installationAuditRecords'));
}

public function showInstallationAuditForm($id = null)
{
    
    $auditRecord = $id ? InstallationAuditRecord::with( 'measure')->findOrFail($id) : null;
    $title = 'GDR 05 - Installation Audit Record';
    $measures = ProjectMeasures::get(['id','name']);
    return view('user.installation-audit.create', compact('auditRecord', 'title','measures'));
}


public function saveInstallationAudit(Request $request, $id = null)
{
    // Step 1: Validate the request
    $validated = $request->validate([
        'audit_date' => 'required|date',
        'completed_date' => 'required|date',
        'installation_reference_number' => 'required|string|max:255',
        'installation_date' => 'required|date',
        'installation_type' => 'required',
        'transferred_to_GDR_02' => 'required|in:Yes,No',
        'supervisor' => 'required|string|max:255',
        'auditor' => 'required|string|max:255',
        'project_folder_comments' => 'required|string',
        'summary' => 'required|string',
        'corrective_preventive_actions' => 'required|string',
    ]);

    $validated['user_id'] = Auth::id();

    if ($id) {
        $auditRecord = InstallationAuditRecord::with('measure')->findOrFail($id);
        $auditRecord->update($validated);
        $message = 'Installation Audit Record updated successfully.';
    } else {
        $auditRecord = InstallationAuditRecord::create($validated);
        $message = 'Installation Audit Record created successfully.';
    }

    session()->flash('success', $message);

    $title = 'GDR 05 - Installation Audit Record';
    $measures = ProjectMeasures::get(['id', 'name']);

    return view('user.installation-audit.create', compact('auditRecord', 'title', 'measures'));
}


public function destroyInstallationAudit($id)
{
    $installationAudit = InstallationAuditRecord::findOrFail($id);
    $installationAudit->delete();
    
    return redirect()
        ->back()
        ->with('success', 'Personal Skills deleted successfully!');
    }

 public function showInstallationAuditDocuments(Request $request, $id)
    {
        $installationAuditRecord = InstallationAuditRecord::with('files')->findOrFail($id);
        
        return view('user.installation-audit.documents',compact('installationAuditRecord'));
    }


     public function uploadInstallationAuditDocument(Request $request, $id)
    {
        $installationAuditRecord = InstallationAuditRecord::findOrFail($id);
        $uploaded = $request->file('file');
        // 4) Build a unique filename
        $name      = pathinfo($uploaded->getClientOriginalName(), PATHINFO_FILENAME);
        $ext       = $uploaded->getClientOriginalExtension();
        $filename  = "{$installationAuditRecord->id}_" . time() . "_" . Str::slug($name) . ".{$ext}";

        // 5) Store it on the public disk
        $path = $uploaded->storeAs(Auth::user()->org.'/installation_audit_record', $filename, 'public');
        // 6) Prepare metadata
        $data = [
            'installation_audit_id' => $installationAuditRecord->id,
            'filename'            => $uploaded->getClientOriginalName(),
            'path'                => $path,
            'mime_type'           => $uploaded->getClientMimeType(),
            'size'                => $uploaded->getSize(),
        ];
        
        
        // 7b) Create new record
        InstallationAuditRecordDocument::create($data);
        $message = 'File uploaded successfully!';

        // 8) Redirect back
        return redirect()
        ->back()
        ->with('success', $message);
    }
     



public function complaintsRecords()
{
    $complaintsRecords = ComplaintsRecord::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
    return view('user.complaints-records.list', compact('complaintsRecords'));
}

public function showComplaintsRecordForm($id = null)
{
    $complaintsRecord = $id ? ComplaintsRecord::findOrFail($id) : null;
    $title = 'GDR 06 - Complaints Record';

    // Get projects with basic fields
    $projects = ProjectsFolder::get(['id', 'project_reference', 'measures_to_be_installed']);

    // Collect all measure IDs
    $allMeasureIds = collect($projects)
        ->pluck('measures_to_be_installed')
        ->flatten()
        ->unique()
        ->filter()
        ->all();

    // Fetch all related measure records at once
    $measures = ProjectMeasures::whereIn('id', $allMeasureIds)->get()->keyBy('id');

    // Map measures to each project
    foreach ($projects as $project) {
        $project->measures = collect($project->measures_to_be_installed)
            ->map(fn($id) => $measures[$id] ?? null)
            ->filter();
           
    }
    return view('user.complaints-records.create', compact('complaintsRecord', 'title', 'projects'));
}



public function complaintsRecordStore(Request $request, $id = null)
{

    
    
    $validated = $request->validate([
        'project_id' => 'required|exists:projects_folders,id',
        'complainantName' => 'required|string|max:255',
        'sources' => 'required|string|max:255',
        'dateOfComplaint' => 'nullable|date',
        'address' => 'nullable|string',
        'contactName' => 'nullable|string|max:255',
        'email' => 'nullable|email|max:255',
        'telephone' => 'nullable|string|max:50',
        'mobile' => 'nullable|string|max:50',
        'handledBy' => 'nullable|string|max:255',
        'natureOfComplaint' => 'nullable|string',
        'immediateAction' => 'nullable|string',
        'outcome' => 'nullable|string',
        'customerContactedIn1Day' => 'nullable|in:yes,no',
        'resolutionDelayReason' => 'nullable|string',
        'summaryOfFindings' => 'nullable|string',
        'correctiveActionRequired' => 'nullable|in:yes,no',
        'dateClosed' => 'nullable|date',
        'complainantSatisfied' => 'nullable|in:yes,no',

    ]);

    // Upload file if exists

   if ($request->hasFile('satisfactionEvidence')) {
    $file = $request->file('satisfactionEvidence');
    $filePath = $file->store('complaints/attachments/' . Auth::id(), 'public');
    $validated['satisfactionEvidence'] = $filePath;
    $validated['file_name'] = date('d-M-Y') . '.' . $file->getClientOriginalExtension();
}


    // Create or update
    $record = $id
        ? ComplaintsRecord::findOrFail($id)
        : new ComplaintsRecord();

    $record->user_id = Auth::id();
    $record->projects_folders_id = $validated['project_id'];
    $record->measure_id = $request->measure_id;
    $record->complainant_name = $validated['complainantName'];
    $record->source = $validated['sources'];
    $record->date_of_complaint = $validated['dateOfComplaint'] ?? null;
    $record->address = $validated['address'] ?? null;
    $record->contact_name = $validated['contactName'] ?? null;
    $record->contact_email = $validated['email'] ?? null;
    $record->contact_phone = $validated['telephone'] ?? null;
    $record->contact_mobile = $validated['mobile'] ?? null;
    $record->handled_by = $validated['handledBy'] ?? null;
    $record->nature_of_complaint = $validated['natureOfComplaint'] ?? null;
    $record->immediate_action_required = $validated['immediateAction'] ?? null;
    $record->outcome = $validated['outcome'] ?? null;
    $record->resolved_within_5_days = $validated['customerContactedIn1Day'] ?? null;
    $record->correctiveActionRequired = $validated['correctiveActionRequired'] ?? null;
    $record->resolution_comments = $validated['resolutionDelayReason'] ?? null;
    $record->findings = $validated['summaryOfFindings'] ?? null;
    $record->summary_of_findings = $validated['summaryOfFindings'] ?? null;
    $record->closed_out = $validated['dateClosed'] ?? null;
    $record->complainant_satisfied = $validated['complainantSatisfied'] ?? null;
    $record->verified_by = $validated['verifiedBy'] ?? null;
    $record->validator_position = $validated['validatorPosition'] ?? null;

    if (isset($validated['satisfactionEvidence'])) {
        $record->attachment_path = $validated['satisfactionEvidence'];
        $record->file_name = $validated['file_name'];
    }

    $record->save();

    return redirect()
        ->back()
        ->with('success', 'Complaint record has been ' . ($id ? 'updated' : 'created') . ' successfully.');
}

public function complaintsRecordDestroy($id)
    {
        
        $complaintsRecord = ComplaintsRecord::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        if (!$complaintsRecord) {
            return redirect()
            ->back();
        }
        $complaintsRecord->delete();
        
        return redirect()
        ->back()
        ->with('success', 'Complaints Record deleted successfully!');
    }

    public function showComplaintsDocumentsForm($id = null)
    {
        $complaintsRecord = $id ? ComplaintsRecord::with('files')->findOrFail($id) : null;
        $title = 'GDR06 - Complaints Record';        
        return view('user.complaints-records.documents', compact('complaintsRecord', 'title'));
    }
    public function uploadComplaintsDocument(Request $request, $id)
    {
        $complaintsRecord = ComplaintsRecord::findOrFail($id);
        $uploaded = $request->file('file');
        // 4) Build a unique filename
        $name      = pathinfo($uploaded->getClientOriginalName(), PATHINFO_FILENAME);
        $ext       = $uploaded->getClientOriginalExtension();
        $filename  = "{$complaintsRecord->id}_" . time() . "_" . Str::slug($name) . ".{$ext}";

        // 5) Store it on the public disk
        $path = $uploaded->storeAs(Auth::user()->org.'/complaint_documents', $filename, 'public');
        // 6) Prepare metadata
        $data = [
            'complaint_record_id' => $complaintsRecord->id,
            'filename'            => $uploaded->getClientOriginalName(),
            'path'                => $path,
            'mime_type'           => $uploaded->getClientMimeType(),
            'size'                => $uploaded->getSize(),
        ];
        
        
        // 7b) Create new record
        ComplaintDocument::create($data);
        $message = 'File uploaded successfully!';

        // 8) Redirect back
        return redirect()
        ->back()
        ->with('success', $message);
    }
   
    public function installationAuditDocumentDestroy($complaintId,$documentId)
    {
        $InstallationAuditRecord = InstallationAuditRecord::where('user_id', Auth::id())->where('id', $complaintId)->firstOrFail();
        if (!$InstallationAuditRecord) {
            return redirect()
            ->back();
        }
        $document = InstallationAuditRecordDocument::findOrFail($documentId);
        $document->delete();
        
        return redirect()
            ->back()
            ->with('success', 'Document deleted successfully!');
    }
    
    
   

    public function complaintDocumentDestroy($complaintId, $documentId)
    {
        $complaint = ComplaintsRecord::where('user_id', Auth::id())->where('id', $complaintId)->firstOrFail();
        if (!$complaint) {
            return redirect()
            ->back();
        }
        $document = ComplaintDocument::findOrFail($documentId);
        $document->delete();
        
        return redirect()
            ->back()
            ->with('success', 'Document deleted successfully!');
    }
    

public function personalSkills()
{
    $personalSkills = PersonalSkillsAndTraining::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
    return view('user.personal-skills.list', compact('personalSkills'));
}

public function showPersonalSkillsForm($id = null)
{
    
    $personalSkill = $id ? PersonalSkillsAndTraining::with('courses', 'competencies')->findOrFail($id) : null;
    $title = 'GDR 12 - Personal Skills';
    return view('user.personal-skills.create', compact('personalSkill', 'title'));
}


public function savePersonalSkills(Request $request, $id = null)
{
    

    $employeeData = [
        'user_id' => Auth::id(),
        'employee_name' => $request->employee_name,  
        'route_to_further_competence' => $request->route_to_further_competence,
    ];
    
    if ($id) {
        $employee = PersonalSkillsAndTraining::findOrFail($id);
        $employee->update($employeeData); // ✅ Correct: passing array
    } else {
        $employee = PersonalSkillsAndTraining::create($employeeData);
        $id = $employee->id; // Ensure $id is set for use below
    }
    
    // Handle course creation
    if (!empty($request->courseName) || !empty($request->course_date) || !empty($request->renewal_date)) {
        $course = [
            'skill_id' => $id,
            'course_name' => $request->courseName ?? null,
            'course_date' => $request->courseDate ?? null,
            'renewal_date' => $request->renewalDate ?? null,
            'course_description' => $request->courseDescription ?? null,
        ];
        SkillsCourse::create($course);
    }
    
    // Handle competence creation
    if (!empty($request->competenceIn) || !empty($request->competenceLevel) || !empty($request->experienceLevel)) {
        $competence = [
            'skill_id' => $id,
            'competence_in' => $request->competenceIn ?? null,
            'competence_level' => $request->competenceLevel ?? null,
            'experience_level' => $request->experienceLevel ?? null,
        ];
        Competencies::create($competence);
    }
    
    return view('user.personal-skills.create', [
        'personalSkill' => $employee,
        'message' => 'Personal Skills saved successfully.',
    ]);
}


public function destroyPersonalSkills($id)
{
    $personalSkill = PersonalSkillsAndTraining::findOrFail($id);
    // Delete associated courses
    $personalSkill->courses()->delete();
    // Delete associated competencies
    $personalSkill->competencies()->delete();
    $personalSkill->delete();
    
    return redirect()
        ->back()
        ->with('success', 'Personal Skills deleted successfully!');
    }

    public function destroySkillsCourse($skillId, $courseId)
    {
        
        $personalSkill = PersonalSkillsAndTraining::where('user_id', Auth::id())->where('id', $skillId)->firstOrFail();
        if (!$personalSkill) {
            return redirect()
            ->back();
        }
        $course = SkillsCourse::where('id', $courseId)->first();
        $course->delete();
        
        return redirect()
        ->back()
        ->with('success', 'Course deleted successfully!');
    }
    
    public function destroySkillsCompetence($skillId, $competenceId)
    {

    $personalSkill = PersonalSkillsAndTraining::where('user_id', Auth::id())->where('id', $skillId)->firstOrFail();
    if (!$personalSkill) {
        return redirect()
            ->back();
    }
    $competence = Competencies::where('skill_id', $skillId)->findOrFail($competenceId);
    $competence->delete();
    
    return redirect()
        ->back()
        ->with('success', 'Competence deleted successfully!');
} 
    

public function suppliers()
{
    $suppliers = Supplier::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
    return view('user.suppliers.list', compact('suppliers'));
}

public function saveSupplier(Request $request, $id = null)
{
    $request->validate([
            'supplier_name' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'address_1' => 'nullable|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'address_3' => 'nullable|string|max:255',
            'address_4' => 'nullable|string|max:255',
            'postcode' => 'nullable|string|max:20',
            'telephone' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'product' => 'nullable|string|max:255',
        ]);
        
        $data = $request->except('_token');
        $data['user_id'] = Auth::id();
        
        if ($id) {
            $supplier = Supplier::findOrFail($id);
            $supplier->update($data);
            $message = 'Supplier updated successfully!';
        } else {
            $supplier = Supplier::create($data);
            $message = 'Supplier created successfully!';
        }

        return view('user.suppliers.create', compact('supplier',  'message'));
    }

    public function showSupplierForm($id = null)
    {

        $supplier = $id ? Supplier::findOrFail($id) : null;
        $title = 'GDR 12 - Suppliers';
        return view('user.suppliers.create', compact('supplier', 'title'));
    }

    public function destroySupplier($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        
        return redirect()
            ->back()
            ->with('success', 'Supplier deleted successfully!');
    }
}
