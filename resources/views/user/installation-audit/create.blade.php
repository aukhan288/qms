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
<form action="{{ route('installation-audit.form', $auditRecord->id ?? null) }}" method="POST">
    @csrf
<div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-success">GDR 05 - Installation Audit Record</h2>
            <div>
               <button type="submit" class="btn btn-sm btn-success">
                    Save & Close
                </button>
                   @if (isset($auditRecord))
                    <button type="button" class="btn btn-sm btn-secondary" onclick="window.location.href='{{ route('installation-audit-documents', $auditRecord->id) }}'" complaints-documents class="p-2">
                        <strong>Uploads</strong>
                    </button>
                    @endif
            </div>
        </div>
        <h4 class="text-success">Installation Audit Details</h4>
        <div class="row">
            <div class="col-sm-6">
               <div class="mb-3">
                    <label for="audit_date" class="form-label">Audit Date</label>
                    <input type="date" class="form-control @error('audit_date') is-invalid @enderror" id="audit_date" name="audit_date" value="{{ old('audit_date', $auditRecord->audit_date ?? '') }}">
                    @error('audit_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="completed_date" class="form-label">Completed Date</label>
                    <input type="date" class="form-control @error('completed_date') is-invalid @enderror" id="completed_date" name="completed_date" value="{{ old('completed_date', $auditRecord->completed_date ?? '') }}">
                    @error('completed_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="col-sm-6">
               <div class="mb-3">
                    <label for="installation_reference_number" class="form-label">Installation Reference Number</label>
                    <input type="text" class="form-control @error('installation_reference_number') is-invalid @enderror" id="installation_reference_number" name="installation_reference_number" value="{{ old('installation_reference_number', $auditRecord->installation_reference_number ?? '') }}">
                    @error('installation_reference_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="installation_date" class="form-label">Installation Date</label>
                    <input type="date" class="form-control @error('installation_date') is-invalid @enderror" id="installation_date" name="installation_date" value="{{ old('installation_date', $auditRecord->installation_date ?? '') }}">
                    @error('installation_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
               
                <div class="mb-3">
    <label for="installation_type" class="form-label">Installation Type</label>
    <select class="form-select @error('installation_type') is-invalid @enderror" id="installation_type" name="installation_type">
        <option value="">-- Select --</option>
        @foreach ($measures as $measure)
            <option value="{{ $measure->id }}"
                {{ old('installation_type', $auditRecord->installation_type ?? '') == $measure->id ? 'selected' : '' }}>
                {{ $measure->name }}
            </option>
        @endforeach
    </select>
    @error('installation_type')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

            </div>
            <div class="col-sm-6">
 <div class="mb-3">
                    <label for="supervisor" class="form-label">Supervisor</label>
                    <input type="text" class="form-control @error('supervisor') is-invalid @enderror" id="supervisor" name="supervisor" value="{{ old('supervisor', $auditRecord->supervisor ?? '') }}">
                    @error('supervisor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="mb-3">
        <label for="auditor" class="form-label">Auditor</label>
        <input type="text" class="form-control @error('auditor') is-invalid @enderror" id="auditor" name="auditor" value="{{ old('auditor', $auditRecord->auditor ?? '') }}">
        @error('auditor')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label class="form-label d-block">Actions transferred to GDR 02?</label>
                    <div class="d-flex">
                       <div class="form-check form-check-inline">
                        <input class="form-check-input @error('transferred_to_GDR_02') is-invalid @enderror" type="radio" name="transferred_to_GDR_02" id="transferred_yes" value="Yes" {{ old('transferred_to_GDR_02', $auditRecord->transferred_to_GDR_02 ?? '') == 'Yes' ? 'checked' : '' }}>
                        <label class="form-check-label" for="transferred_yes">Yes</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('transferred_to_GDR_02') is-invalid @enderror" type="radio" name="transferred_to_GDR_02" id="transferred_no" value="No" {{ old('transferred_to_GDR_02', $auditRecord->transferred_to_GDR_02 ?? '') == 'No' ? 'checked' : '' }}>
                            <label class="form-check-label" for="transferred_no">No</label>
                        </div>
                    </div>
                    

                    @error('transferred_to_GDR_02')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

    

    

   


    

    

    

    <div class="mb-3">
        <label for="project_folder_comments" class="form-label">Project Folder Comments</label>
        <textarea class="form-control @error('project_folder_comments') is-invalid @enderror" id="project_folder_comments" name="project_folder_comments" rows="3">{{ old('project_folder_comments', $auditRecord->project_folder_comments ?? '') }}</textarea>
        @error('project_folder_comments')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="summary" class="form-label">Summary</label>
        <textarea class="form-control @error('summary') is-invalid @enderror" id="summary" name="summary" rows="3">{{ old('summary', $auditRecord->summary ?? '') }}</textarea>
        @error('summary')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="corrective_preventive_actions" class="form-label">Corrective & Preventive Actions</label>
        <textarea class="form-control @error('corrective_preventive_actions') is-invalid @enderror" id="corrective_preventive_actions" name="corrective_preventive_actions" rows="3">{{ old('corrective_preventive_actions', $auditRecord->corrective_preventive_actions ?? '') }}</textarea>
        @error('corrective_preventive_actions')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</form>
 </div>
</div>
<script>
    $(document).ready(function() {
    $('#installation_type').select2();
});

</script>
@endsection