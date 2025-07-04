@extends('layouts.base')
@section('page')
<div class="row py-5 ms-5 me-5">
    <x-user-side_menu />
    <div class="col-md-9">
        <form action="" method="post">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-success">Corrective & Preventive Action Record</h3>
            <div>
               <button type="submit" class="btn btn-success">
                    Add New
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="" class="form-label">Date</label>
                    <input
                        type="date"
                        class="form-control"
                        name=""
                        id=""
                        aria-describedby="helpId"
                        placeholder=""
                    />
                </div>
                
            </div>
            <div class="col-sm-6"></div>
        </div>
        </form>


    </div>
</div>
@endsection