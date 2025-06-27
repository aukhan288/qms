@extends('layouts.base')
@section('page')
<div class="row py-5 ms-5 me-5">
    <x-user-side_menu />
    <div class="col-md-9">
         <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-success">Complaints Record</h2>
            <div>
               <button onclick="window.location.href='{{ url('innstaller-records/complaints-record') }}'">
    Add New
</button>

            </div>
        </div>
        <table class="table table-responsive table-bordered table-striped">
  <thead>
    <th>Date of Complaint</th>
    <th>Complainant Name</th>
    <th>Nature of Complaint</th>
    <th>Date Complaint Closed</th>
    <th>Options</th>
  </thead>
  <tbody>
  @foreach ($complaintsRecords as $cr)   
<tr>
    <td>{{ $cr->date_of_complaint }}</td>
    <td>{{ $cr->complainant_name }}</td>
    <td>{{ $cr->nature_of_complaint }}</td>
    <td>{{ $cr->closed_out }}</td>
    <td>
        <div class="d-flex">
            <!-- Delete Button -->
            <form action="{{ route('complaints-record.destroy', $cr->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this complaint?');">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm me-2" type="submit">
                    <i class="mdi mdi-delete text-danger"></i>
                </button>
            </form>

            <!-- Edit Button -->
            <button class="btn btn-sm" onclick="window.location.href='{{ route('complaints-record.form', $cr->id) }}'">
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
