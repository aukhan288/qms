@extends('layouts.base')
@section('page')
@php
    use App\Enums\CompanyDocumentType;
@endphp
<style>
    select.form-select {
    height: 41px;
    border-radius: 2px;
    line-height: 14px;
    font-size: 14px;
}
</style>
<div class="row py-5 ms-5 me-5">
     <x-user-side_menu />
     <div class="col-md-9">
        @if(isset($message))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
    <form action="{{ route('suppliers.store', $supplier->id ?? null) }}" method="POST">
    @csrf
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success">GDR 08 - Approved Suppliers List</h2>
        <div>
            <button type="submit" class="btn btn-primary">{{ isset($supplier) ? 'Update' : 'Create' }}</button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="mb-3">
                <label for="supplier_name" class="form-label">Supplier Name</label>
                <input type="text" name="supplier_name" class="form-control" value="{{ old('supplier_name', $supplier->supplier_name ?? '') }}" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-3">
                <label for="contact_name" class="form-label">Contact Name</label>
                <input type="text" name="contact_name" class="form-control" value="{{ old('contact_name', $supplier->contact_name ?? '') }}">
            </div>
        </div>
    </div>
    <div class="row">
        @for ($i = 1; $i <= 4; $i++)
        <div class="col-sm-6">
            <div class="mb-3">
                <label for="address_{{ $i }}" class="form-label">Address {{ $i }}</label>
                <input type="text" name="address_{{ $i }}" class="form-control" value="{{ old("address_$i", $supplier["address_$i"] ?? '') }}">
            </div>
        </div>
        @endfor
    </div>
    <div class="row">
        <div class="col-sm-2">
            <div class="mb-3">
                <label for="postcode" class="form-label">Postcode</label>
                <input type="text" name="postcode" class="form-control" value="{{ old('postcode', $supplier->postcode ?? '') }}">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="mb-3">
                <label for="telephone" class="form-label">Telephone</label>
                <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $supplier->telephone ?? '') }}">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="mb-3">
                <label for="fax" class="form-label">Fax</label>
                <input type="text" name="fax" class="form-control" value="{{ old('fax', $supplier->fax ?? '') }}">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $supplier->email ?? '') }}">
            </div>
            </div>
    </div>




    <div class="mb-3">
        <label for="product" class="form-label">Product</label>
        <textarea name="product" class="form-control" rows="3">{{ old('product', $supplier->product ?? '') }}</textarea>
    </div>

    <div class="form-check mb-3">
        <input type="checkbox" name="active" class="form-check-input" id="activeCheck" value="1" {{ old('active', $supplier->active ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="activeCheck">Active?</label>
    </div>
</form>
    </div>
</div>
@endsection