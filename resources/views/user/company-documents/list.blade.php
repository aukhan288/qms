@extends('layouts.base')
@section('page')
@php
    use App\Enums\CompanyDocumentType;
@endphp
<div class="row py-5 ms-5 me-5">
     <x-user-side_menu />
     <div class="col-md-9">
        @if(session('success'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-success">Company Documents</h2>
            <div>
               <button onclick="window.location.href='{{ url('innstaller-records/company-document') }}'">
    Add New
</button>

            </div>
        </div>
        <table class="table table-responsive table-striped table-bordered">
            <thead>
                <th>Type</th>
                <th>Name</th>
                <th>Date</th>
                <th>Renewal Date</th>
                <th>Options</th>
            </thead>
            <tbody>
                @foreach ( $companyDocuments as $cd)
                <tr>
                    <td>{{ $cd->type }}</td>
                    <td>{{ $cd->name }}</td>
                    <td>{{ $cd->date }}</td>
                    <td>{{ $cd->renewal_date }}</td>
                    <td>
    <div class="d-flex flex-row align-items-center">
        {{-- Edit Link --}}
        <a class="me-2 text-primary" href="{{ url('innstaller-records/company-document/' . $cd->id) }}">
            <i class="mdi mdi-pencil"></i>
        </a>
        {{-- Delete Form --}}
        <form action="{{ url('innstaller-records/company-document/' . $cd->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this document?');">
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
@endsection