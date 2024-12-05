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
        <div class=" p-3 col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header text-center btn-theme">
                    <h4 class="h4 fw-bold">Confirm Password</h4>
                </div>
                <div class="card-body bg-light">
                    <p class="mb-4 text-gray-600">Please confirm your password before continuing.</p>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="current-password">

                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-end">
                            <button type="submit" class="btn btn-theme btn-lg text-white fw-bold">
                                Confirm Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
