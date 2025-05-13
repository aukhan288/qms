@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <h3 class="text-center mb-4">Reset Password</h3>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <div class="mb-3">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" required autofocus>
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Send Reset Link</button>
            </div>
        </form>
    </div>
</div>
@endsection
