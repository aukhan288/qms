@extends('layouts.app')
@section('content')
@php
    use App\Enums\TemplateCategory;
    use App\Enums\DocumentType;
@endphp
<div class="d-none">
    <button type="button" class="btn btn-primary btn-sm text-white mb-3 ms-auto" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
      Add Template
    </button>
</div>
<div class="card p-3">
 <form id="orgForm" method="post" action="{{ route('template.create') }}" enctype="multipart/form-data" novalidate>
        @csrf
 
        
         <div class="row">
          <div class="col-sm-7 mb-3">
<label for="name" class="form-label">Template Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="col-sm-2 mb-3">
             <label for="document_type" class="form-label">Document Type <span class="text-danger">*</span></label>
            <select class="form-select" id="document_type" name="document_type" required>
              <option value="">Select type</option>
              @foreach(DocumentType::cases() as $type)
                <option value="{{ $type->value }}">{{ strtoupper($type->value) }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-sm-3 mb-3">
               <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
            <select class="form-select" id="category" name="category" required>
              <option value="">Select category</option>
              @foreach(TemplateCategory::cases() as $category)
                <option value="{{ $category->value }}">{{ ucfirst($category->value) }}</option>
              @endforeach
            </select>
          </div>
         </div> 
 
          <!-- HTML Content -->
      <div class="mb-3">
  <label for="editor" class="form-label">HTML Content <span class="text-danger">*</span></label>
  <!-- This is the editor container. The textarea will be replaced by Quill.js -->
<textarea name="html_content" id="editor" class="form-control" rows="10"></textarea>


</div>



        <div class="modal-footer">
          <button type="submit" class="btn btn-primary text-white">Save</button>
        </div>
      </form>
      </div>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="orgForm" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="modal-header bg-primary text-white">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Template</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <!-- Template Name -->
          <div class="mb-3">
            <label for="name" class="form-label">Template Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
        
         <div class="row">
          <div class="col-sm-4 mb-3">
             <label for="document_type" class="form-label">Document Type <span class="text-danger">*</span></label>
            <select class="form-select" id="document_type" name="document_type" required>
              <option value="">Select type</option>
              @foreach(DocumentType::cases() as $type)
                <option value="{{ $type->value }}">{{ strtoupper($type->value) }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-sm-8 mb-3">
               <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
            <select class="form-select" id="category" name="category" required>
              <option value="">Select category</option>
              @foreach(TemplateCategory::cases() as $category)
                <option value="{{ $category->value }}">{{ ucfirst($category->value) }}</option>
              @endforeach
            </select>
          </div>
         </div> 
 
          <!-- HTML Content -->
        <div class="mb-3" >
          <label for="html_content" class="form-label">HTML Content <span class="text-danger">*</span></label>
          <textarea class="form-control" id="html_content" name="html_content" rows="6" required></textarea>
        </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary text-white">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function () {
     CKEDITOR.replace('editor', {
    toolbar: [
       { name: 'document', items: ['Source'] },
      { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline'] },
      { name: 'paragraph', items: ['NumberedList', 'BulletedList'] },
      { name: 'links', items: ['Link', 'Unlink'] },
      { name: 'insert', items: ['Image', 'Table'] },
      { name: 'tools', items: ['Maximize'] },
      { name: 'editing', items: ['Scayt'] }
    ]
  });
  });
</script>





@endsection