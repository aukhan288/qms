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
             <h3 class="text-success">GDR 04 - Tool Calibration, Checking & Servicing Record</h3>
             <div>
                 <button onclick="window.location.href='{{ route('tool-calibration.form') }}'" class="btn btn-success">
                     Add New
                 </button>
             </div>
         </div>

        <table class="table table-responsive table-striped table-bordered">
            <thead>
                <th>Item of Equipment</th>
                <th>Serial Number</th>
                <th>Date Calibrated, Serviced or Checked</th>
                <th>Next Calibration</th>
                <th>Options</th>
            </thead>
            <tbody>
                @foreach ( $toolCalibrations as $tc )
                <tr>
                    <td>{{ $tc->item_of_equipment }}</td>
                    <td>{{ $tc->serial_number }}</td>
                    <td>{{ $tc->date_calibrated }}</td>
                    <td>{{ $tc->next_calibration_date }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                                {{-- Edit --}}
                                <a href="{{ route('tool-calibration.store', $tc->id) }}" class="me-2 text-primary">
                                    <i class="mdi mdi-pencil"></i>
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('tool-calibration.destroy', $tc->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Tool?');">
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