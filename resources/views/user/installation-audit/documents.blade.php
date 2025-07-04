@extends('layouts.base')
@section('page')
 <div class="row py-5 ms-5 me-5">
    <x-user-side_menu />
    <div class="col-md-9">
         @if(session('success'))
            {{-- Flash Message for Success --}}
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-success">GDR05 - Installation Audit Record</h2>
            <div>
               <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    Add New
</button>

            </div>
        </div>
         <table class="table table-responsive table-bordered table-striped">
  <thead>
    <th>File</th>
    <th>Date Uploaded</th>
    <th>Options</th>
  </thead>
  <tbody>
    @foreach ($toolCalibration->files as $file )
        <tr>
        <td>{{ $file->filename }}</td>
        <td>{{ $file->created_at->format('d-m-Y') }}</td>

       <td>
    <div class="d-flex flex-row align-items-center gap-2">
        {{-- Download Button --}}
        <a href="{{ asset('storage/' . $file->path) }}" class="btn btn-link text-primary p-0" download>
            <i class="mdi mdi-download"></i>
        </a>

        {{-- Delete Form --}}
        <form action="{{ url('innstaller-records/delete-installation-audit-document/'.$toolCalibration->id.'/' . $file->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this document?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-link text-danger p-0">
                <i class="mdi mdi-delete"></i>
            </button>
        </form>
    </div>
</td>

        </tr>
    @endforeach
  </tbody>
</table>
    </div>
 </div>
 <!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <form action="{{ route('upload-installation-audit-document', $toolCalibration->id) }}" method="POST" enctype="multipart/form-data">
       @csrf
       <div class="modal-body">
        <div class="mb-3">
            <label for="" class="form-label">Choose file <small class="text-muted">(Upload word or Image)</small></label>
            <input
                type="file"
                class="form-control"
                name="file"
                id="file"
                placeholder=""
                accept=".doc,.docx,.png,.jpg,.jpeg,.gif"
                aria-describedby="fileHelpId"
            />
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Upload</button>
      </div>
       </form>
    </div>
  </div>
</div>
@endsection