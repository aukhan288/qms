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
    <form action="{{ route('subcontractors.store', $subcontractor->id ?? null) }}" method="POST">
    @csrf
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success">GDR 09 - Approved Subcontractors List</h2>
        <div>
            <button type="submit" class="btn btn-primary">{{ isset($subcontractor) ? 'Update' : 'Create' }}</button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="mb-3">
                <label for="company_name" class="form-label">Company Name</label>
                <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $subcontractor->company_name ?? '') }}" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-3">
                <label for="contact_name" class="form-label">Contact Name</label>
                <input type="text" name="contact_name" class="form-control" value="{{ old('contact_name', $subcontractor->contact_name ?? '') }}">
            </div>
        </div>
    </div>
    <div class="row">
        @for ($i = 1; $i <= 4; $i++)
        <div class="col-sm-6">
            <div class="mb-3">
                <label for="address_{{ $i }}" class="form-label">Address {{ $i }}</label>
                <input type="text" name="address_{{ $i }}" class="form-control" value="{{ old("address_$i", $subcontractor["address_$i"] ?? '') }}">
            </div>
        </div>
        @endfor
    </div>
    <div class="row">
        <div class="col-sm-2">
            <div class="mb-3">
                <label for="postcode" class="form-label">Postcode</label>
                <input type="text" name="postcode" class="form-control" value="{{ old('postcode', $subcontractor->postcode ?? '') }}">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="mb-3">
                <label for="telephone" class="form-label">Telephone</label>
                <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $subcontractor->telephone ?? '') }}">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="mb-3">
                <label for="fax" class="form-label">Fax</label>
                <input type="text" name="fax" class="form-control" value="{{ old('fax', $subcontractor->fax ?? '') }}">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $subcontractor->email ?? '') }}">
            </div>
            </div>
    </div>




    <div class="mb-3">
        <label for="approved_works" class="form-label">Approved Works</label>
        <textarea name="approved_works" class="form-control" rows="3">{{ old('approved_works', $subcontractor->approved_works ?? '') }}</textarea>
    </div>

    <div class="form-check mb-3">
        <input type="checkbox" name="active" class="form-check-input" id="activeCheck" value="1" {{ old('active', $subcontractor->active ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="activeCheck">Active?</label>
    </div>
</form>
@if (isset($subcontractor))
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
    @foreach ($subcontractor?->files ?? [] as $file)
            <tr>
                <td>{{ $file->filename }}</td>
                <td>{{ $file->created_at->format('Y-m-d H:i:s') }}</td>
                <td class="d-flex align-items-center">
                    <a 
                href="{{ route('download-subcontractor-document', [
                  'documentId' => $subcontractor->id,
                  'fileId'     => $file->id,
                ]) }}" 
                class=" me-2"
              >
                <i class="mdi mdi-download"></i>
              </a>
              {{-- Delete --}}
              <form 
                action="{{ route('subcontractor-document.destroy', [
                  'documentId' => $subcontractor->id,
                  'id'     => $file->id,
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
@if (isset($subcontractor) && $subcontractor->id)
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
    action="{{ route('upload-subcontractor-document', [
        'subcontractorId' => $subcontractor?->id,
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