@extends('layouts.base')
@section('page')
<div class="row py-5 ms-5 me-5">
    <x-user-side_menu />
    <div class="col-md-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-success">Corrective & Preventive Action Record</h3>
            <div>
               <button onclick="window.location.href='{{ route('installation-audit.form') }}'" class="btn btn-success">
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
        </table>
    </div>
</div>
@endsection