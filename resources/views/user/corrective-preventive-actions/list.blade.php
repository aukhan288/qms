@extends('layouts.base')
@section('page')
<div class="row py-5 ms-5 me-5">
    <x-user-side_menu />
    <div class="col-md-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-success">Corrective & Preventive Action Record</h3>
            <div>
               <button onclick="window.location.href='{{ route('corrective-preventive.form') }}'" class="btn btn-success">
                    Add New
                </button>
            </div>
        </div>
        <table class="table table-responsive table-bordered table-striped">
            <thead>
                <th>Date</th>
                <th>NCR No</th>
                <th>Source</th>
                <th>Action Type</th>
                <th>Date Closed</th>
                <th>Status</th>
                <th>Options</th>
            </thead>
            <tbody>
                @foreach ($correctivePreventiveActions as $action)
                <tr>
                    <td>{{ $action->date }}</td>
                    <td>{{ $action->ncr_no }}</td>
                    <td>{{ $action->source }}</td>
                    <td>{{ $action->preventive_or_Corrective }}</td>
                    <td>{{ $action->date_closed }}</td>
                    <td>{{ $action->status }}</td>
                    <td>
                        <div class="d-flex">
                            <!-- Delete Button -->
                            <form action="{{ route('corrective-preventive.destroy', $action->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this action?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm me-2" type="submit">
                                    <i class="mdi mdi-delete text-danger"></i>
                                </button>
                            </form>

                            <!-- Edit Button -->
                            <button class="btn btn-sm" onclick="window.location.href='{{ route('corrective-preventive.form', $action->id) }}'">
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