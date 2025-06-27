@extends('layouts.base')
@section('page')
<div class="row py-5 ms-5 me-5">
    <x-user-side_menu />
    <div class="col-md-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-success">Personal Skills & Training Record</h2>
            <div>
               <button onclick="window.location.href='{{ route('personal-skills.form') }}'" class="btn btn-success">
    Add New
</button>

            </div>
        </div>
          <table class="table table-responsive table-striped table-bordered">
               <thead>
                   <tr>
                       <th>Employee Name</th>
                       <th>Competent In</th>
                       <th>Competence Level</th>
                       <th>Experience Level</th>
                       <th>Options</th>
                   </tr>
               </thead>
               <tbody>
                @foreach ($personalSkills as $personalSkill)
                    <tr>
                        <td>{{ $personalSkill->employee_name }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <a href="{{ route('personal-skills.form', $personalSkill->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('personal-skills.destroy', $personalSkill->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
               </tbody>
            </table>
    </div>
</div>
@endsection