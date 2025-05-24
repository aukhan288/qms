@extends('layouts.app')

@section('content')
@php
    use App\Enums\TemplateCategory;
    use App\Enums\DocumentType;
@endphp



<div class="card p-3">
    <form id="orgForm"
          method="POST"
          action="{{ $template ? route('template.create', $template->id) : route('template.create') }}"
          enctype="multipart/form-data"
          novalidate>
        @csrf

        <div class="row">
            <div class="col-sm-7 mb-3">
                <label for="name" class="form-label">Template Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" required
                       value="{{ old('name', $template->name ?? '') }}">
            </div>
            <div class="col-sm-2 mb-3">
                <label for="document_type" class="form-label">Document Type <span class="text-danger">*</span></label>
                <select class="form-select" id="document_type" name="document_type" required>
                    <option value="">Select type</option>
                  @foreach(\App\Enums\DocumentType::cases() as $type)
    @php
        $selectedValue = old('document_type') ?? ($template->document_type->value ?? $template->document_type ?? null);
    @endphp

    <option value="{{ $type->value }}"
        {{ $selectedValue == $type->value ? 'selected' : '' }}>
        {{ strtoupper($type->value) }}
    </option>
@endforeach

                </select>
            </div>
           
            <div class="col-sm-3 mb-3">
                <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                <select class="form-select" id="category" name="category" required>
                    <option value="">Select category</option>
                 @foreach(\App\Enums\TemplateCategory::cases() as $category)
    @php
        $selectedValue = old('category') ?? ($template->category->value ?? $template->category ?? null);
    @endphp

    <option value="{{ $category->value }}"
        {{ $selectedValue == $category->value ? 'selected' : '' }}>
        {{ ucfirst($category->value) }}
    </option>
@endforeach

                </select>
            </div>
            
              <div class="col-sm-1 mb-3">
                <label for="ref" class="form-label">Ref # <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="ref" name="ref" required
                       value="{{ old('ref', $template->ref ?? '') }}">
            </div>
              <div class="col-sm-1 mb-3">
                <label for="revision" class="form-label">Revision <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="revision" name="revision" required
                       value="{{ old('revision', $template->revision ?? '') }}">
            </div>
              <div class="col-sm-1 mb-3">
                <label for="pages" class="form-label">No. Pages <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="pages" name="pages" required
                       value="{{ old('pages', $template->pages ?? '') }}">
            </div>
            <div class="col-sm-3 mb-3">
              <label for="revision_date" class="form-label">Revision Date <span class="text-danger">*</span></label>
              <input type="date" class="form-control" id="revision_date" name="revision_date" required
                     value="{{ old('revision_date', $template->revision_date ?? '') }}">
          </div>
       

        <!-- HTML Content -->
        <div class="mb-3">
            <label for="editor" class="form-label">Content <span class="text-danger">*</span></label>
           <textarea name="content" id="editor" class="form-control" style="height: 300px; overflow-y: auto; resize: vertical;">
    {{ old('content', $template->content ?? '') }}
</textarea>


        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary text-white">{{ $template ? 'Update' : 'Save' }}</button>
        </div>
    </form>
</div>

{{-- CKEditor Script --}}
<script>
  
    document.addEventListener('DOMContentLoaded', function () {
        // CKEDITOR.replace('editor', {
        //     toolbar: [
        //         { name: 'document', items: ['Source'] },
        //         { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline'] },
        //         { name: 'paragraph', items: ['NumberedList', 'BulletedList'] },
        //         { name: 'links', items: ['Link', 'Unlink'] },
        //         { name: 'insert', items: ['Image', 'Table'] },
        //         { name: 'tools', items: ['Maximize'] },
        //         { name: 'editing', items: ['Scayt'] }
        //     ]
        // });
    });
</script>
@endsection
