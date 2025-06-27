<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Template;
use App\Enums\TemplateCategory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;
use PhpOffice\PhpWord\SimpleType\Jc;
use HTMLPurifier;
use HTMLPurifier_Config;
use PhpOffice\PhpWord\Element\AbstractContainer;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\Style\Table as TableStyle;


class TemplateController extends Controller
{
    public function index()
    {
        return view('admin.templates');
    }
    
    public function showTemplateForm($id = null)
    {
        $template = null;

        if ($id) {
            $template = Template::findOrFail($id);
        }
        $title = $id ? 'Edit Template' : 'Create Template';
        return view('admin.create-template', compact('template','title'));
    }


    public function create(Request $request, $id = null)
{
    try {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            // 'title' => 'required|string|max:255',
            'revision' => 'required|integer',
            'pages' => 'required|integer',
            'revision_date' => 'required|date',
            'ref' => 'required|string|max:100',
            'category' => 'required|string',
            'document_type' => 'required|in:word,pdf',
            'content' => 'nullable|string',
        ]);
if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('templates', 'public');
        }

// 'file' => 'nullable|file|mimes:doc,docx|max:2048',
        // If $id is provided, fetch the template or create a new one
        $template = $id ? Template::findOrFail($id) : new Template();

        // Assign common fields
        $template->name = $request->name;
        $template->title = $request->title;
        $template->user_id = Auth::id();
        $template->revision = $request->revision;
        $template->pages = $request->pages;
        $template->revision_date = $request->revision_date;
        $template->ref = $request->ref;
        $template->category = $request->category;
        $template->document_type = $request->document_type;

        // Handle content or file based on document type
        if ($request->document_type === 'pdf') {
            $template->content = $request->content;
            $template->file_path = null; // remove any previous file
        } elseif ($request->document_type === 'word' && $request->hasFile('file')) {
            $directory = storage_path('app/public/templates');
            if (!is_dir($directory)) {
                mkdir($directory, 0775, true);
            }
            $filePath = $filePath = $request->file('file')->store('templates'); // stores in storage/app/templates;
            $template->file_path = $filePath;
            $template->content = null; // remove any previous HTML content
        }

        // Save the template
        $template->save();

        $message = $id ? 'Template updated successfully.' : 'Template created successfully.';
        return redirect()->back()->with('success', $message);
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to save template: ' . $e->getMessage());
    }
}


    
  public function templatesList(Request $request)
{
    $query = Template::query();

    // Search logic
    if (!empty($request->input('search.value'))) {
        $search = $request->input('search.value');
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('ref', 'like', "%{$search}%")
              ->orWhere('category', 'like', "%{$search}%")
              ->orWhere('document_type', 'like', "%{$search}%");
        });
    }

    // Optional filters (custom from client)
    if ($request->has('category')) {
        $cat = $request->input('category');
        is_array($cat)
            ? $query->whereIn('category', $cat)
            : $query->where('category', $cat);
    }

    if ($request->has('document_type')) {
        $type = $request->input('document_type');
        is_array($type)
            ? $query->whereIn('document_type', $type)
            : $query->where('document_type', $type);
    }

    // Get total count before filtering
    $recordsTotal = Template::count();

    // Count after filtering
    $recordsFiltered = $query->count();

    // Ordering
    $orderColumnIndex = $request->input('order.0.column');
    $orderDirection = $request->input('order.0.dir', 'desc');
    $columns = ['id', 'ref', 'name', 'published', 'document_type', 'category', 'created_at'];

    if (isset($columns[$orderColumnIndex])) {
        $query->orderBy($columns[$orderColumnIndex], $orderDirection);
    } else {
        $query->orderBy('id', 'desc'); // default
    }

    // Pagination
    $start = $request->input('start', 0);
    $length = $request->input('length', 10);
    $data = $query->skip($start)->take($length)->get();

    return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => $recordsTotal,
        'recordsFiltered' => $recordsFiltered,
        'data' => $data,
    ]);
}




    public function downloadFile(Request $request)
    {
        $template = Template::findOrFail($request->id);
        
        $imagePath = public_path('storage/' . Auth::user()->profile_pic);
        if (!file_exists($imagePath)) {
            abort(404, 'Profile image not found.');
        }
        
        $template->content = str_replace(
            ['{{ Name }}', '{{ CompanyName }}', '{{ Street }}', '{{ District }}', '{{ City }}', '{{ PostalCode }}'],
            [Auth::user()->name, Auth::user()->org, Auth::user()->street, Auth::user()->district, Auth::user()->city, Auth::user()->postal_code],
            $template->content
        );

        $imageData = base64_encode(file_get_contents($imagePath));
        $mimeType = mime_content_type($imagePath);
        $imageTag = '<img src="data:' . $mimeType . ';base64,' . $imageData . '" style="max-width: 100px;" />';
        if ($template->document_type->value == 'pdf') {
         
            $html = '
        <html>
        <head>
            <style>
                @page {
                    margin: 100px 50px 50px 50px;
                }

                body {
                    font-family: sans-serif;
                }

                header {
                    position: fixed;
                    top: -80px;
                    left: 0;
                    right: 0;
                    height: 80px;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    flex-direction: row;
                }

                .header-left {
                    flex: 1;
                    text-align: left;
                }

                .header-center {
                    flex: 1;
                    text-align: center;
                    font-weight: bold;
                    font-size: 14px;
                    position: fixed;
                    top: -60px;
                    left: 40%;
                }

                footer {
                    position: fixed;
                    bottom: -30px;
                    left: 0;
                    right: 0;
                    height: 50px;
                    font-size: 12px;
                }

                .content {
                    margin-top: 20px;
                }
                p{
                 font-size:12px;
                }
                ol {
                    font-size: 12px;
                }
                ul {
                    font-size: 12px;
                }
            </style>
        </head>
        <body>

            <header>
                <div class="header-left">' . $imageTag . '</div>
                <div class="header-center">' . $template->title . '</div>
            </header>

            <footer>
                <div style="width: 100%; font-size: 12px; display: flex; justify-content: space-between;">
                    <div style="text-align: left;">
                        Rev '.$template->revision.' '.$template->revision_date.'<br>
                        &copy; LAMTANS &trade; 2025
                    </div>
                    <div style="text-align: right;">
                        A01 Page 
                        <script type="text/php">
                            if (isset($pdf)) {
                                echo $pdf->page_number . " of " . $pdf->page_count;
                            }
                        </script>
                    </div>
                </div>
            </footer>

            <div class="content">
                ' . $template->content . '
            </div>

        </body>
        </html>
        ';

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
            
            return $pdf->download($template->name . '.pdf');
        } else if ($template->document_type->value == 'word') {
 // Step 1: Load original Word document
$sourcePath = storage_path('app/public/' . $template->file_path);

if (!file_exists($sourcePath)) {
    abort(404, 'File not found.');
}

$phpWord = IOFactory::load($sourcePath);

// Define header/footer table styles
$headerTableStyleName = 'HeaderTable';
$headerTableStyle = ['borderSize' => 0, 'borderColor' => 'FFFFFF', 'cellMargin' => 0];
$footerTableStyleName = 'FooterTable';
$footerTableStyle = ['borderSize' => 0, 'borderColor' => 'FFFFFF', 'cellMargin' => 50];

$phpWord->addTableStyle($headerTableStyleName, $headerTableStyle);
$phpWord->addTableStyle($footerTableStyleName, $footerTableStyle);

// Define a new style for main content tables with borders (for new tables, if any)
$customTableStyleName = 'CustomBorderStyle';
$customTableStyle = [
    'borderSize' => 6,
    'borderColor' => '000000', // Use hex color code for black
    'cellMargin' => 80,
];
$phpWord->addTableStyle($customTableStyleName, $customTableStyle);

// Fix: Manually apply borders to each cell of existing tables
foreach ($phpWord->getSections() as $section) {
    foreach ($section->getElements() as $element) {
        if ($element instanceof Table) {
            foreach ($element->getRows() as $row) {
                foreach ($row->getCells() as $cell) {
                    $cellStyle = $cell->getStyle();
                    $cellStyle->setBorderSize(6);
                    $cellStyle->setBorderColor('000000');
                }
            }
        }
    }
}

// Process each section to add header/footer
foreach ($phpWord->getSections() as $section) {

    // Add Header
    $header = $section->addHeader();
    $headerTable = $header->addTable($headerTableStyleName);
    $headerTable->addRow();

    
    $imagePath = public_path('storage/' . Auth::user()?->profile_pic);
    if (file_exists($imagePath)) {
        $headerTable->addCell(1000, ['valign' => 'center'])->addImage($imagePath, [
            'width' => 80,
            'alignment' => Jc::LEFT,
        ]);
    } else {
        Log::error('Profile image not found: ' . $imagePath);
        $headerTable->addCell(1000)->addText('');
    }

    $headerTable->addCell(8000, ['valign' => 'center'])->addText(
        $template->ref . ' ' . $template->name,
        ['bold' => true, 'size' => 14],
        ['alignment' => Jc::CENTER]
    );

    // Add Footer
    $footer = $section->addFooter();
    $footerTable = $footer->addTable($footerTableStyleName);
    $footerTable->addRow();

    $leftCell = $footerTable->addCell(7000);
    $leftCell->addText('Rev ' . $template->revision . ' ' . $template->revision_date, ['size' => 10]);
    $leftCell->addText('© LAMTANS™ 2025', ['size' => 10]);

    $rightCell = $footerTable->addCell(3000, ['valign' => 'bottom']);
    $rightCell->addPreserveText('Page {PAGE} of {NUMPAGES}', null, ['alignment' => Jc::RIGHT]);
}

// Save modified document
$filename = $template->name . '.docx';
$savePath = storage_path('app/' . $filename);
$writer = IOFactory::createWriter($phpWord, 'Word2007');
$writer->save($savePath);

// Return as download
return response()->download($savePath, $filename)->deleteFileAfterSend(true);


        } else {
            abort(400, 'Unsupported document type.');
        }
    }
}
