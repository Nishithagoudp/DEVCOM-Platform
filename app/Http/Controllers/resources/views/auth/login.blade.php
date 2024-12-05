@extends('layouts.front')

@section('content')
<style>
    .btn-theme {
        background-color: #ff6b6b;
        color: white;
        border: none;
    }
    .btn-theme:hover {
        background-color: #e05e5e;
    }
</style>
<div class="container mt-4 mb-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header text-center btn-theme">
                    <h4 class="h4 fw-bold">Login to DevCom</h4>
                </div>
                <div class="card-body bg-light">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <a href="{{ route('register') }}" class="text-decoration-none text-danger fw-bold">Don't Have an Account? Register</a>
                            <a href="#" class="text-decoration-none text-danger fw-bold">Forgot Password?</a>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-theme btn-lg text-white fw-bold">Sign In</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
