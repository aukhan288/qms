@extends('layouts.base')

@section('page')
<div class="row py-5 ms-5 me-5">
    <x-user-side_menu />

    <div class="col-md-9">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
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
            <h2 class="text-success">Subcontractors</h2>
            <div>
                <button onclick="window.location.href='{{ route('subcontractor.form') }}'" class="btn btn-success">
                    Add New
                </button>
            </div>
        </div>

        <table class="table table-responsive table-striped table-bordered">
            <thead>
                <tr>
                    <th>Company Name</th>
                    <th>Contact Name</th>
                    <th>Telephone</th>
                    <th>Active</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subcontractors as $sc)
                    <tr>
                        <td>{{ $sc->company_name }}</td>
                        <td>{{ $sc->contact_name }}</td>
                        <td>{{ $sc->telephone }}</td>
                        <td>
                            <span class="badge bg-{{ $sc->active ? 'success' : 'secondary' }}">
                                {{ $sc->active ? 'Yes' : 'No' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                {{-- Edit --}}
                                <a href="{{ route('subcontractor.form', $sc->id) }}" class="me-2 text-primary">
                                    <i class="mdi mdi-pencil"></i>
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('subcontractor.destroy', $sc->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this subcontractor?');">
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

                @if ($subcontractors->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center">No subcontractors found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
