@extends('layouts.base')
@section('page')
@php
    use App\Enums\CompanyDocumentType;
@endphp
<style>
    select.form-select {
    height: 41px;
    border-radius: 2px;
    line-height: 14px;
    font-size: 14px;
}
</style>
<div class="row py-5 ms-5 me-5">
     <x-user-side_menu />
     <div class="col-md-9">
        @if(isset($message))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

       <form action="{{ route('create-company-document', $companyDocument?->id ?? null) }}" method="POST">
    @csrf

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success">{{ $title ?? '' }}</h2>
        <div>
            <button type="submit" class="p-2"><strong>Save</strong></button>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-sm-6">
            <div class="mb-3">
                <label for="company_document_type" class="form-label">Type<span class="text-danger">*</span></label>
                <select
                    class="form-select form-select-lg @error('company_document_type') is-invalid @enderror"
                    name="company_document_type"
                    id="company_document_type"
                >
                    <option value="">Select Type</option>
                    @foreach (CompanyDocumentType::cases() as $type)
                        <option value="{{ $type->value }}" {{ old('company_document_type', $companyDocument->type ?? '') == $type->value ? 'selected' : '' }}>
                            {{ ucwords(str_replace('_', ' ', $type->value)) }}
                        </option>
                    @endforeach
                </select>
                @error('company_document_type')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-sm-6">
            <div class="mb-3">
                <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                <input
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    name="name"
                    id="name"
                    value="{{ old('name', $companyDocument->name ?? '') }}"
                />
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="mb-3">
                <label for="date" class="form-label">Date<span class="text-danger">*</span></label>
                <input
                    type="date"
                    class="form-control @error('date') is-invalid @enderror"
                    name="date"
                    id="date"
                    value="{{ old('date', $companyDocument->date ?? '') }}"
                />
                @error('date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-sm-6">
            <div class="mb-3">
                <label for="renewal_date" class="form-label">Renewal Date (if relevant)<span class="text-danger">*</span></label>
                <input
                    type="date"
                    class="form-control @error('renewal_date') is-invalid @enderror"
                    name="renewal_date"
                    id="renewal_date"
                    value="{{ old('renewal_date', $companyDocument->renewal_date ?? '') }}"
                />
                @error('renewal_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="mb-3">
                <label for="description" class="form-label">Description<span class="text-danger">*</span></label>
                <textarea
                    class="form-control @error('description') is-invalid @enderror"
                    name="description"
                    id="description"
                    rows="3"
                >{{ old('description', $companyDocument->description ?? '') }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</form>

@if (isset($companyDocument) && $companyDocument->id)
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-success">Documents</h2>
    <div>
        <button type="button" data-bs-toggle="modal"
    data-bs-target="#modalId" class="p-2"><strong>Uploads</strong></button>
</div>
</div>
<table class="table table-responsive table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th>File Name</th>
            <th>Date Uploaded</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($companyDocument?->files ?? [] as $file)
            <tr>
                <td>{{ $file->filename }}</td>
                <td>{{ $file->created_at->format('Y-m-d H:i:s') }}</td>
                <td class="d-flex align-items-center">
                    <a 
                href="{{ route('download-company-document', [
                  'documentId' => $companyDocument->id,
                  'fileId'     => $file->id,
                ]) }}" 
                class=" me-2"
              >
                <i class="mdi mdi-download"></i>
              </a>
              {{-- Delete --}}
              <form 
                action="{{ route('delete-company-document-file', [
                  'documentId' => $companyDocument->id,
                  'fileId'     => $file->id,
                ]) }}" 
                method="POST" 
                onsubmit="return confirm('Delete this file?')" 
              >
                @csrf
                @method('DELETE')
                <button class="border-0">
                  <i class="mdi mdi-delete text-danger"></i>
                </button>
              </form>
                </td>
            </tr>
        @endforeach
    </tbody>
    </table>
    @endif
    </div>
</div>
<!-- Modal trigger button -->

@if (isset($companyDocument) && $companyDocument->id)
<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div
    class="modal fade"
    id="modalId"
    tabindex="-1"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    
    role="dialog"
    aria-labelledby="modalTitleId"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md"
        role="document"
    >
    <form 
    action="{{ route('upload-company-document', [
        'documentId' => $companyDocument?->id,
    ]) }}" 
    method="POST" 
    enctype="multipart/form-data"
>
@csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    Modal title
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="" class="form-label">Choose file</label>
                   <input
                        type="file"
                        class="form-control"
                        name="company-document-file"
                        id="your_input_id"
                        accept=".jpg,.jpeg,.png,.doc,.docx"
                        placeholder=""
                        aria-describedby="fileHelpId"
                    />

                </div>
                
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Close
                </button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
        </form>
    </div>
</div>
   @endif
<!-- Optional: Place to the bottom of scripts -->
<script>
    const myModal = new bootstrap.Modal(
        document.getElementById("modalId"),
        options,
    );
</script>

@endsection