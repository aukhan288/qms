@extends('layouts.base')

@section('title', 'Login')

@section('page')
<div class="row justify-content-center py-5">
    <div class="col-md-8 col-lg-8 card p-5 bg-dark">
        <h3 class="text-white mb-4">Login</h3>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <div class="mb-3">
                <label class="text-white">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="text-white">Password</label>
                <input type="password" name="password" class="form-control" required>
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="d-flex justify-content-between">
                <div>
                    <div class="form-check text-white">
                      <input type="checkbox" name="remember" class="form-check-input" id="remember">
                      <label class="form-check-label" for="remember">Remember Me</label>
                    </div>
                    <div class="text-center">
                      <a href="{{ route('password.request') }}">Forgot Password?</a>
                    </div>
                </div> 
                <button type="submit" class="btn bg-success text-white" style="height: 38px;">Login</button>
            </div>
            
        </form>
    </div>
    <div class="col-sm-4">
        <img class="img-fluid" src="https://qms.easy-pasplus.com/templates/easypasplus_qms/images/competent-person.png" alt="">
    </div>
</div>
@endsection
