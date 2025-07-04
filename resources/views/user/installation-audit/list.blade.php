@extends('layouts.base')
@section('page')
<div class="row py-5 ms-5 me-5">
    <x-user-side_menu />
    <div class="col-md-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-success">Personal Skills & Training Record</h2>
            <div>
               <button onclick="window.location.href='{{ route('installation-audit.form') }}'" class="btn btn-success">
                    Add New
                </button>
            </div>
        </div>
        <table class="table table-responsive table-bordered table-striped">
            <thead>
                <th>Date of planned audit</th>
                <th>Auditor</th>
                <th>Procedure / Area of installation process to be audited</th>
                <th>Date Audit Completed</th>
                <th>Options</th>
            </thead>
            <tbody>
                @foreach ($installationAuditRecords as $auditRecord ) 
                 <tr>
                    <td>{{ $auditRecord->audit_date }}</td>
                    <td>{{ $auditRecord->auditor }}</td>
                    <td>{{ $auditRecord->measure?->name }}</td>
                    <td>{{ $auditRecord->completed_date }}</td>
                    <td>
        <div class="d-flex">
            <!-- Delete Button -->
           <form action="{{ route('installation-audit.destroy', $auditRecord->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this complaint?');">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm me-2" type="submit">
                    <i class="mdi mdi-delete text-danger"></i>
                </button>
            </form>

            <!-- Edit Button -->
            <button class="btn btn-sm" onclick="window.location.href='{{ route('installation-audit.form', $auditRecord->id) }}'">
                <i class="mdi mdi-pencil text-primary"></i>
            </button>


        </div>
    </td>
                 </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection