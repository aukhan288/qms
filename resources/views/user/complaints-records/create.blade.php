@extends('layouts.base')
@section('page')
<div class="row py-5 ms-5 me-5">
    <x-user-side_menu />
    <div class="col-md-9">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>  
        @endif
        <form action="{{ route('complaints-record.store', $complaintsRecord->id ?? null) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-success">{{ $title ?? '' }}</h2>
                <div>
                    <button type="submit" class="p-2">
                        <strong>{{ isset($complaintsRecord) ? 'Update' : 'Save' }}</strong>
                    </button>
                    @if (isset($complaintsRecord))
                    <button type="button" onclick="window.location.href='{{ route('complaints-documents', $complaintsRecord->id) }}'" complaints-documents class="p-2">
                        <strong>Uploads</strong>
                    </button>
                    @endif
                </div>

            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
    <label for="projects" class="form-label">Project</label>
   <!-- Hidden input -->
<input type="hidden" name="project_id" id="project_id">

<!-- Project + Measure dropdown -->
<select class="form-select form-select-lg" name="measure_id" id="projects">
    <option value="">Select a project (if relevant)</option>
    @foreach ($projects as $project)
        @if ($project->measures->isNotEmpty())
            <optgroup label="{{ $project->project_reference }}">
                @foreach ($project->measures as $measure)
                    <option 
                        value="{{ $measure->id }}"
                        data-project-id="{{ $project->id }}"
                        {{ old('measure_id', $complaintsRecord->measure_id ?? '') == $measure->id ? 'selected' : '' }}>
                        {{ $project->project_reference }} - {{ $measure->name }}
                    </option>
                @endforeach
            </optgroup>
        @endif
    @endforeach
</select>

<!-- Place JS directly after DOM elements -->



</div>

                </div>

                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="complainantName" class="form-label">Complainant Name</label>
                        <input type="text" class="form-control" name="complainantName" id="complainantName" value="{{ old('complainant_name', $complaintsRecord->complainant_name ?? '') }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="sources" class="form-label">Sources</label>
                       <select class="form-select form-select-lg" name="sources" id="sources">
                            <option value="" disabled {{ old('source', $complaintsRecord->source ?? '') == '' ? 'selected' : '' }}>Select one</option>
                            <option value="Customer" {{ old('sources', $complaintsRecord->source ?? '') == 'Customer' ? 'selected' : '' }}>Customer</option> 
                            <option value="Installer" {{ old('source', $complaintsRecord->source ?? '') == 'Installer' ? 'selected' : '' }}>Installer</option> 
                            <option value="Employee" {{ old('source', $complaintsRecord->source ?? '') == 'Employee' ? 'selected' : '' }}>Employee</option> 
                            <option value="Other" {{ old('source', $complaintsRecord->source ?? '') == 'Other' ? 'selected' : '' }}>Other</option> 
                        </select>

                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="dateOfComplaint" class="form-label">Date of Complaint</label>
                        <input type="date" class="form-control" name="dateOfComplaint" id="dateOfComplaint" value="{{ old('date_of_complaint', $complaintsRecord->date_of_complaint ?? '') }}"/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" name="address" id="address" rows="3">{{ old('address', $complaintsRecord->address ?? '') }}</textarea>

                    </div>
                </div>
            </div>

            <h4 class="text-success">Contact Details</h4>
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="contactName" class="form-label">Name</label>
                        <input type="text" class="form-control" name="contactName" id="contactName" value="{{ old('contact_name', $complaintsRecord->contact_name ?? '') }}"/>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="text" class="form-control" name="email" id="email" value="{{ old('contact_email', $complaintsRecord->contact_email ?? '') }}"/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Telephone</label>
                        <input type="tel" class="form-control" name="telephone" id="telephone" value="{{ old('contact_phone', $complaintsRecord->contact_phone ?? '') }}"/>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile</label>
                        <input type="tel" class="form-control" name="mobile" id="mobile" value="{{ old('contact_mobile', $complaintsRecord->contact_mobile ?? '') }}"/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="handledBy" class="form-label">Person dealing with the Complaint</label>
                        <input type="text" class="form-control" name="handledBy" id="handledBy" value="{{ old('handled_by', $complaintsRecord->handled_by ?? '') }}"/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="mb-3">
                        <label for="natureOfComplaint" class="form-label">Nature of Complaint</label>
                        <textarea class="form-control" name="natureOfComplaint" id="natureOfComplaint" rows="3">{{ old('nature_of_complaint', $complaintsRecord->nature_of_complaint ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="mb-3">
                        <label for="immediateAction" class="form-label">Immediate Action Requested by Customer</label>
                        <textarea class="form-control" name="immediateAction" id="immediateAction" rows="3">{{ old('immediate_action_required', $complaintsRecord->immediate_action_required ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="mb-3">
                        <label for="outcome" class="form-label">Outcome</label>
                        <textarea class="form-control" name="outcome" id="outcome" rows="3">{{ old('outcome', $complaintsRecord->outcome ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <label>Customer contacted within 1 working day?</label>
                    <div class="d-flex">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="customerContactedIn1Day" id="customerContactedYes" value="yes"
                            {{ old('resolved_within_5_days', $complaintsRecord->resolved_within_5_days ?? '') == 'Yes' ? 'checked' : '' }}>
                            <label class="form-check-label" for="customerContactedYes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="customerContactedIn1Day" id="customerContactedNo" value="no"
                            {{ old('resolved_within_5_days', $complaintsRecord->resolved_within_5_days ?? '') == 'No' ? 'checked' : '' }}>
                            <label class="form-check-label" for="customerContactedNo">No</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="mb-3">
                        <label for="resolutionDelayReason" class="form-label">If not, why not?</label>
                        <textarea class="form-control" name="resolutionDelayReason" id="resolutionDelayReason" rows="3">{{ old('outcome', $complaintsRecord->outcome ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="mb-3">
                        <label for="summaryOfFindings" class="form-label">Summary of Findings / Why did it happen? / Action Taken</label>
                        <textarea class="form-control" name="summaryOfFindings" id="summaryOfFindings" rows="3">{{ old('summary_of_findings', $complaintsRecord->summary_of_findings ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <label>Is there any corrective / preventive action required?</label>
                    <div class="d-flex">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="correctiveActionRequired" id="correctiveYes" value="yes"
                            {{ old('correctiveActionRequired', $complaintsRecord->correctiveActionRequired ?? '') == 'Yes' ? 'checked' : '' }}>
                            <label class="form-check-label" for="correctiveYes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="correctiveActionRequired" id="correctiveNo" value="no"
                            {{ old('correctiveActionRequired', $complaintsRecord->correctiveActionRequired ?? '') == 'No' ? 'checked' : '' }}>
                            <label class="form-check-label" for="correctiveNo">No</label>
                        </div>
                    </div>
                    <p class="form-text text-muted">(If yes, please add this to GDR02 Corrective & Preventive Action Record)</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="dateClosed" class="form-label">Date Closed</label>
                        <input type="date" class="form-control" name="dateClosed" id="dateClosed" value="{{ old('closed_out', $complaintsRecord->closed_out ?? '') }}"/>
                    </div>
                </div>

                <div class="col-sm-6">
                    <label>Is complainant satisfied with result?</label>
                    <div class="d-flex pt-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="complainantSatisfied" id="satisfiedYes" value="yes"
                             {{ old('complainant_satisfied', $complaintsRecord->complainant_satisfied ?? '') == 'Yes' ? 'checked' : '' }}>
                            <label class="form-check-label" for="satisfiedYes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="complainantSatisfied" id="satisfiedNo" value="no"
                            {{ old('complainant_satisfied', $complaintsRecord->complainant_satisfied ?? '') == 'No' ? 'checked' : '' }}>
                            <label class="form-check-label" for="satisfiedNo">No</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="mb-3">
                        <label for="satisfactionEvidence" class="form-label">Evidence of Complainant Satisfaction</label>
                      @if(isset($complaintsRecord) && $complaintsRecord->attachment_path)
                        <br> <a href="{{ asset('storage/' . $complaintsRecord->attachment_path) }}" target="_blank">
                            {{ $complaintsRecord->file_name }}
                        </a>
                        <button class="ms-2 btn btn-sm"><i class="mdi mdi-delete text-danger"></i></button>
                    @else
                        <input type="file" class="form-control" name="satisfactionEvidence" id="satisfactionEvidence" />
                    @endif

                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#projects').select2({
            placeholder: 'Select a project',
            allowClear: true,
        });

        $('#sources').select2({
            placeholder: 'Select a source',
            allowClear: true
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('projects');
    const hiddenInput = document.getElementById('project_id');

    function updateHiddenProjectId() {
        const selectedOption = select.options[select.selectedIndex];
        const projectId = selectedOption ? selectedOption.getAttribute('data-project-id') : '';
        hiddenInput.value = projectId || '';
        console.log('✅ Selected project_id:', projectId);
    }

    // Run once after the page loads
    updateHiddenProjectId();

    // Wait for Select2 to initialize and attach to 'change' event
    $(select).on('select2:select', function (e) {
        updateHiddenProjectId();
    });

    // Also in case of deselection
    $(select).on('select2:unselect', function (e) {
        updateHiddenProjectId();
    });
});
</script>
@endsection
