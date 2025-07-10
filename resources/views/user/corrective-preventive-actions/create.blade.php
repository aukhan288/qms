@extends('layouts.base')
@section('page')
<div class="row py-5 ms-5 me-5">
    <x-user-side_menu />
    <div class="col-md-9">
       <form action="{{ route('corrective-preventive.store', $correctivePreventiveAction->id ?? null) }}" method="POST">
    @csrf
   <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-success">{{ $title ?? '' }}</h2>
                <div>
                    <button type="submit" class="p-2">
                        <strong>{{ isset($correctivePreventiveAction) ? 'Update' : 'Save' }}</strong>
                    </button>
                    @if (isset($correctivePreventiveAction))
                    <button type="button" onclick="window.location.href='{{ route('corrective-preventive-documents', $correctivePreventiveAction->id) }}'" complaints-documents class="p-2">
                        <strong>Uploads</strong>
                    </button>               
                    @endif
                </div>

            </div>
    <h3 class="text-success">Source Details</h3>
    <div class="row">
        <div class="col-sm-6 mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                   value="{{ old('date', $correctivePreventiveAction->date ?? '') }}">
            @error('date') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="col-sm-6 mb-3">
            <label class="form-label">NCR No (if applicable)</label>
            <input type="text" name="ncr_no" class="form-control @error('ncr_no') is-invalid @enderror"
                   value="{{ old('ncr_no', $correctivePreventiveAction->ncr_no ?? '') }}">
            @error('ncr_no') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 mb-3">
            <label class="form-label">Source</label>
            <select name="source" class="form-select @error('source') is-invalid @enderror">
                <option value="">Please Select</option>
                @foreach(['Management Review', 'Internal Audit', 'External Audit', 'Customer', 'GDP', 'Installer', 'Preventive', 'Feedback','Other (Please Specify)'] as $option)
                    <option value="{{ $option }}" {{ old('source', $correctivePreventiveAction->source ?? '') == $option ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endforeach
                
            </select>
            @error('source') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="col-sm-6 mb-3">
            <label class="form-label">Preventive or Corrective?</label>
            <select name="preventive_or_Corrective" class="form-select @error('preventive_or_Corrective') is-invalid @enderror">
                <option value="" >Please Select</option>
                <option value="Preventive" {{ old('preventive_or_Corrective', $correctivePreventiveAction->preventive_or_Corrective ?? '') == 'Preventive' ? 'selected' : '' }}>Preventive</option>
                <option value="Corrective" {{ old('preventive_or_Corrective', $correctivePreventiveAction->preventive_or_Corrective ?? '') == 'Corrective' ? 'selected' : '' }}>Corrective</option>
            </select>
            @error('preventive_or_Corrective') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4 mb-3">
            <label class="form-label">Issued To</label>
            <input type="text" name="issued_to" class="form-control @error('issued_to') is-invalid @enderror"
                   value="{{ old('issued_to', $correctivePreventiveAction->issued_to ?? '') }}">
            @error('issued_to') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="col-sm-4 mb-3">
            <label class="form-label">No of Days</label>
            <input type="number" name="no_of_days" class="form-control @error('no_of_days') is-invalid @enderror"
                   value="{{ old('no_of_days', $correctivePreventiveAction->no_of_days ?? '') }}">
            @error('no_of_days') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="col-sm-4 mb-3">
            <label class="form-label d-block">Status</label>
            <div class="d-flex align-items-between">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" value="open"
                        {{ old('status', $correctivePreventiveAction->status ?? '') == 'open' ? 'checked' : '' }}>
                    <label class="form-check-label">Open</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" value="closed"
                        {{ old('status', $correctivePreventiveAction->status ?? '') == 'closed' ? 'checked' : '' }}>
                    <label class="form-check-label">Closed</label>
                </div>
            </div>
            @error('status') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 mb-3">
            <label class="form-label">Date Closed</label>
            <input type="date" name="closed_date" class="form-control @error('closed_date') is-invalid @enderror"
                   value="{{ old('closed_date', $correctivePreventiveAction->date_closed ?? '') }}">
            @error('closed_date') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="col-sm-6 mb-3">
            <label class="form-label">Closed By</label>
            <input type="text" name="closed_by" class="form-control @error('closed_by') is-invalid @enderror"
                   value="{{ old('closed_by', $correctivePreventiveAction->closed_by ?? '') }}">
            @error('closed_by') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
    </div>

    <h3 class="text-success">Action Details</h3>

    <div class="mb-3">
    <label class="form-label">Details of Issue</label>
    <textarea name="details_of_issue" class="form-control @error('details_of_issue') is-invalid @enderror" rows="3">{{ old('details_of_issue', $correctivePreventiveAction->details_of_issue ?? '') }}</textarea>
    @error('details_of_issue') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Summary of Action Taken</label>
    <textarea name="summary_of_action_taken" class="form-control @error('summary_of_action_taken') is-invalid @enderror" rows="3">{{ old('summary_of_action_taken', $correctivePreventiveAction->summary_of_action_taken ?? '') }}</textarea>
    @error('summary_of_action_taken') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Root Cause</label>
    <textarea name="root_cause" class="form-control @error('root_cause') is-invalid @enderror" rows="3">{{ old('root_cause', $correctivePreventiveAction->root_cause ?? '') }}</textarea>
    @error('root_cause') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">What can be done to prevent a recurrence?</label>
    <textarea name="prevent_recurrence" class="form-control @error('prevent_recurrence') is-invalid @enderror" rows="3">{{ old('prevent_recurrence', $correctivePreventiveAction->prevent_recurrence ?? '') }}</textarea>
    @error('prevent_recurrence') <div class="text-danger">{{ $message }}</div> @enderror
</div>
</form>



    </div>
</div>
@endsection