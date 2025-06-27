@extends('layouts.base')
@section('page')
<div class="row py-5 ms-5 me-5">
    <x-user-side_menu />
    <div class="col-md-9 card p-4">
      
        <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="projectInfo-tab" data-bs-toggle="tab" data-bs-target="#projectInfo" type="button" role="tab" aria-controls="projectInfo" aria-selected="true">Project Info</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="projectOperatives-tab" data-bs-toggle="tab" data-bs-target="#projectOperatives" type="button" role="tab" aria-controls="projectOperatives" aria-selected="false">Project Operatives</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="projectComplaints-tab" data-bs-toggle="tab" data-bs-target="#projectComplaints" type="button" role="tab" aria-controls="projectComplaints" aria-selected="false">Project Complaints</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="projectUploads-tab" data-bs-toggle="tab" data-bs-target="#projectUploads" type="button" role="tab" aria-controls="projectUploads" aria-selected="false">Project Uploads</button>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="projectInfo" role="tabpanel" aria-labelledby="projectInfo-tab">
     <form action="{{ route('projects-folder.save', $project->id ?? '') }}" method="POST">
    @csrf
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
@endif
   <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
        <h4 class="text-success">{{ $title??'' }}</h4>
        <div>
            <button type="submit" class="btn btn-secondary">{{ isset($project) ? 'Update' : 'Save' }}</button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">

            <div class="mb-3">
                <label>Project Reference</label>
                <input type="text" name="project_reference" class="form-control"
                       value="{{ old('project_reference', $project->project_reference ?? '') }}">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-3">
                <label>Customer Name</label>
                <input type="text" name="customer_name" class="form-control"
                       value="{{ old('customer_name', $project->customer_name ?? '') }}">
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">

            <div class="mb-3">
                <label>Address Line 1</label>
                <input type="text" name="address_line_1" class="form-control"
                       value="{{ old('address_line_1', $project->address_line_1 ?? '') }}">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-3">
                <label>Address Line 2</label>
                <input type="text" name="address_line_2" class="form-control"
                       value="{{ old('address_line_2', $project->address_line_2 ?? '') }}">
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">

            <div class="mb-3">
                <label>City</label>
                <input type="text" name="city" class="form-control"
                       value="{{ old('city', $project->city ?? '') }}">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-3">
                <label>County</label>
                <input type="text" name="county" class="form-control"
                       value="{{ old('county', $project->county ?? '') }}">
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">

            <div class="mb-3">
                <label>Postcode</label>
                <input type="text" name="postcode" class="form-control"
                       value="{{ old('postcode', $project->postcode ?? '') }}">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-3">
                <label>E-mail</label>
                <input type="text" name="email" class="form-control"
                       value="{{ old('email', $project->email ?? '') }}">
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">

            <div class="mb-3">
                <label>Land Line Number</label>
                <input type="text" name="land_line_number" class="form-control"
                       value="{{ old('land_line_number', $project->land_line_number ?? '') }}">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-3">
                <label>Mobile Number</label>
                <input type="text" name="mobile_number" class="form-control"
                       value="{{ old('mobile_number', $project->mobile_number ?? '') }}">
            </div>

        </div>
    </div>
     <h4 class="text-success">Retrofit Coordinator</h4>


<div class="row mt-2">
        <div class="col-sm-6">

            <div class="mb-3">
                <label>Retrofit Coordinator</label>
                <input type="text" name="retrofit_coordinator_name" class="form-control"
                       value="{{ old('retrofit_coordinator_name', $project->retrofit_coordinator_name ?? '') }}">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-3">
                <label>Contact Number</label>
                <input type="text" name="retrofit_coordinator_contact_number" class="form-control"
                       value="{{ old('retrofit_coordinator_contact_number', $project->retrofit_coordinator_contact_number ?? '') }}">
            </div>

        </div>
    </div>
<div class="row">
        <div class="col-sm-6">

            <div class="mb-3">
                <label>Email Address</label>
                <input type="text" name="retrofit_coordinator_email" class="form-control"
                       value="{{ old('retrofit_coordinator_email', $project->retrofit_coordinator_email ?? '') }}">
            </div>
        </div>
    </div>
     <h4 class="text-success">EEM Specifier Information</h4>


<div class="row mt-2">
        <div class="col-sm-6">

            <div class="mb-3">
                <label>EEM Specifier</label>
                <input type="text" name="eem_specifier" class="form-control"
                       value="{{ old('eem_specifier', $project->eem_specifier ?? '') }}">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-3">
                <label>Contact Name</label>
                <input type="text" name="eem_specifier_contact_name" class="form-control"
                       value="{{ old('eem_specifier_contact_name', $project->eem_specifier_contact_name ?? '') }}">
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            
            <div class="mb-3">
                <label>Office Telephone No.</label>
                <input type="text" name="eem_specifier_office_phone" class="form-control"
                value="{{ old('eem_specifier_office_phone', $project->eem_specifier_office_phone ?? '') }}">
            </div>
        </div>
        <div class="col-sm-6">
            
            <div class="mb-3">
                <label>Contact E-mail</label>
                <input type="text" name="eem_specifier_email" class="form-control"
                value="{{ old('eem_specifier_email', $project->eem_specifier_email ?? '') }}">
            </div>
        </div>
    </div>
    <h4 class="text-success">Key Installation Dates</h4>


<div class="row mt-2">
       <div class="col-sm-6">

           <div class="mb-3">
               <label>Start Date</label>
               <input type="date" name="start_date" class="form-control"
                      value="{{ old('start_date', $project->start_date ?? '') }}">
           </div>
       </div>
       <div class="col-sm-6">
           <div class="mb-3">
               <label>Date Contract Completed</label>
               <input type="date" name="contract_completed_date" class="form-control"
                      value="{{ old('contract_completed_date', $project->contract_completed_date ?? '') }}">
           </div>

       </div>
   </div>

    {{-- Other fields... --}}

    <h4 class="text-success mt-2">Measures to be Installed</h4>
    <div class="row">
        <div class="col-sm-6">
            <div id="measures-wrapper">
     

   
            <div class="input-group mb-2">
@php
    // Decode the stored JSON string from the DB
    $measures = old('measures_to_be_installed', isset($project) ? json_decode($project->measures_to_be_installed ?? '[]', true) : []);
@endphp

<select name="measures_to_be_installed[]" class="form-select measure-select" multiple>
    <option></option>
    @foreach ($projectMeasures as $pm)
        <option value="{{ $pm->id }}" {{ in_array((string) $pm->id, $measures) ? 'selected' : '' }}>
            {{ $pm->name }}
        </option>
    @endforeach
</select>

</div>

    </div>
        </div>
    </div>



 
</form>
  </div>
  <div class="tab-pane fade" id="projectOperatives" role="tabpanel" aria-labelledby="projectOperatives-tab">
    <div class="d-flex justify-content-end mt-2">
        <button class="btn btn-secondary me-2">Add Project Operative</button>
        <button class="btn btn-secondary">Return to Records</button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Measure</th>
                <th>Operative Name</th>
                <th>Competence</th>
                <th>Competence Level</th>
                <th>Experience</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Project operatives will be listed here -->
        </tbody>
    </table>
  </div>
  <div class="tab-pane fade" id="projectComplaints" role="tabpanel" aria-labelledby="projectComplaints-tab">...</div>
  <div class="tab-pane fade" id="projectUploads" role="tabpanel" aria-labelledby="projectUploads-tab">...</div>
   
</div>
    </div>
   

<script>
  $(document).ready(function () {
        $('.measure-select').select2({
            placeholder: "-- Select Measure(s) --",
            allowClear: true
        });
    });
</script>

    </div>
</div>
@endsection