@extends('layouts.base')
@section('page')
@php
    use Illuminate\Support\Carbon;
@endphp
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
        
    <form action="{{ route('tool-calibration.store', $toolCalibration->id ?? null) }}" method="POST">
    @csrf

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-success">GDR 04 - Tool Calibration, Checking & Servicing Record</h3>
        <div>    
            <button type="submit" class="btn btn-success">
                {{ isset($toolCalibration) ? 'Update' : 'Save' }}
            </button>

            @if (isset($toolCalibration))
                <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('tool-calibration-documents', $toolCalibration->id) }}'">
                    Uploads
                </button>
            @endif
            
        </div>
    </div>

    <div class="row">

        <div class="col-sm-6">
            <div class="mb-3">
                <label class="form-label">Item of Equipment</label>
                <input type="text" name="item_of_equipment"
                    class="form-control @error('item_of_equipment') is-invalid @enderror"
                    value="{{ old('item_of_equipment', $toolCalibration->item_of_equipment ?? '') }}" required>
                @error('item_of_equipment') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="col-sm-6">
            <div class="mb-3">
                <label class="form-label">Serial Number</label>
                <input type="text" name="serial_number"
                    class="form-control @error('serial_number') is-invalid @enderror"
                    value="{{ old('serial_number', $toolCalibration->serial_number ?? '') }}">
                @error('serial_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="col-sm-6">
            <div class="mb-3">
                <label class="form-label">Calibration / Checking Requirements</label>
                <input type="text" name="calibration_checking_requirements"
                    class="form-control @error('calibration_checking_requirements') is-invalid @enderror"
                    value="{{ old('calibration_checking_requirements', $toolCalibration->calibration_checking_requirements ?? '') }}">
                @error('calibration_checking_requirements') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="col-sm-6">
            <div class="mb-3">
                <label class="form-label">Measurement Ref Standard</label>
                <input type="text" name="measurement_ref_standard"
                    class="form-control @error('measurement_ref_standard') is-invalid @enderror"
                    value="{{ old('measurement_ref_standard', $toolCalibration->measurement_ref_standard ?? '') }}">
                @error('measurement_ref_standard') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="col-sm-6">
            <div class="mb-3">
                <label class="form-label">Date Purchased</label>
                <input type="date" name="date_purchased"
                    class="form-control @error('date_purchased') is-invalid @enderror"
                    value="{{ old('date_purchased',isset($toolCalibration) ? Carbon::parse($toolCalibration->date_purchased)->format('Y-m-d') : '') }}">
                @error('date_purchased') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="col-sm-6">
            <div class="mb-3">
                <label class="form-label">Date Calibrated, Serviced or Checked</label>
                <input type="date" name="date_calibrated"
                    class="form-control @error('date_calibrated') is-invalid @enderror"
                    value="{{ old('date_calibrated', isset($toolCalibration) ?Carbon::parse($toolCalibration->date_calibrated)->format('Y-m-d') : '') }}">
                @error('date_calibrated') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="col-sm-6">
            <div class="mb-3">
                <label class="form-label">Next Calibration Date</label>
                <input type="date" name="next_calibration_date"
                    class="form-control @error('next_calibration_date') is-invalid @enderror"
                    value="{{ old('next_calibration_date', isset($toolCalibration) ?Carbon::parse($toolCalibration->next_calibration_date)->format('Y-m-d') : '') }}">
                @error('next_calibration_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="col-sm-6">
            <div class="mb-3">
                <label class="form-label">Out of Spec Reading at Calibration</label>
                <input type="text" name="out_of_spec_reading_at_calibration"
                    class="form-control @error('out_of_spec_reading_at_calibration') is-invalid @enderror"
                    value="{{ old('out_of_spec_reading_at_calibration', $toolCalibration->out_of_spec_reading_at_calibration ?? '') }}">
                @error('out_of_spec_reading_at_calibration') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="col-sm-12">
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description"
                    class="form-control @error('description') is-invalid @enderror"
                    rows="5">{{ old('description', $toolCalibration->description ?? '') }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

    </div>
</form>


    </div>
</div>
@endsection