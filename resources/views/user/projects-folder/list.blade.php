@extends('layouts.base')
@section('page')
<div class="row py-5 ms-5 me-5">
    <x-user-side_menu />
    <div class="col-md-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-success">Project Folders</h2>
            <div>
               <button onclick="window.location.href='{{ route('projects-folder.form') }}'" class="btn btn-success">
    Add New
</button>

            </div>
        </div>
        <table class="table table-responsive table-striped table-bordered">
               <thead>
                   <tr>
                       <th>Project Ref</th>
                       <th>GDP / ECO Specifier</th>
                       <th>Location</th>
                       <th>Completion Date</th>
                       <th>Measures</th>
                       <th>Options</th>
                   </tr>
               </thead>
               <tbody>
                   @foreach ($projectsFolder as $sc)

                       <tr>
                           <td>{{ $sc->project_reference }}</td>
                           <td>{{ $sc->eem_specifier }}</td>
                           <td>{{ $sc->contract_completed_date }}</td>
                             <td>
                            {{ $sc->postcode }}
                            @if ($sc->postcode && $sc->city)
                                ,
                            @endif
                            {{ $sc->city }}
                        </td>
                          <td>
  
</td>

                           <td>
                               <div class="d-flex align-items-center">
                                   {{-- Edit --}}
                                   <a href="{{ route('projects-folder.form', $sc->id) }}" class="me-2 text-primary">
                                       <i class="mdi mdi-pencil"></i>
                                   </a>
   
                                   {{-- Delete --}}
                                   <form action="{{ route('projects-folder.destroy', $sc->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this subcontractor?');">
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
   
                   @if ($projectsFolder->isEmpty())
                       <tr>
                           <td colspan="7" class="text-center">No projects folder found.</td>
                       </tr>
                   @endif
               </tbody>
           </table>
    </div>
</div>
@endsection