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
            <h2 class="text-success">Approved Suppliers List</h2>
            <div>
                <button onclick="window.location.href='{{ route('supplier.form') }}'" class="btn btn-success">
                    Add New
                </button>
            </div>
        </div>
        <table class="table table-responsive table-striped table-bordered">
            <thead>
                <tr>
                    <th>Company Name</th>
                    <th>Contact</th>
                    <th>Telephone</th>
                    <th>Products / Service</th>
                    <th>Active</th>
                    <th>Options</th>
                </tr>
                   <tbody>
                     @foreach ( $suppliers as $supplier )
                        <tr>
                            <td>{{ $supplier->supplier_name }}</td>
                            <td>{{ $supplier->contact_name }}</td>
                            <td>{{ $supplier->telephone }}</td>
                            <td>{{ $supplier->product }}</td>
                            <td>{{ $supplier->is_active ? 'Yes' : 'No' }}</td>
                            <td>
                               <div class="d-flex align-items-center">
                                {{-- Edit --}}
                                <a href="{{ route('supplier.form', $supplier->id) }}" class="me-2 text-primary">
                                    <i class="mdi mdi-pencil"></i>
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this supplier?');">
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
            </thead>
        </table>
    </div>
</div>

@endsection