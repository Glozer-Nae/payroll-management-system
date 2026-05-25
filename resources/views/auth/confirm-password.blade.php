@extends('layouts.guest')

@section('content')
<div class="container-fluid vh-100">
    <div class="row h-100">
        
        <div class="col-md-6 d-none d-md-flex flex-column justify-content-center align-items-center bg-dark text-white">
            <div class="text-center w-75">
                <i class="bi bi-shield-check display-1 text-primary mb-4"></i>
                <h1 class="display-5 fw-bold">Secure Area</h1>
                <p class="lead mt-3 text-white-50">Additional verification is required to proceed.</p>
            </div>
        </div>

        <div class="col-md-6 d-flex justify-content-center align-items-center bg-light">
            <div class="card shadow-sm p-4 p-md-5 w-100 border-0 rounded-4" style="max-width: 450px;">
                
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-dark">Confirm Password</h3>
                    <p class="text-muted small">This is a secure area of the application. Please confirm your password before continuing.</p>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">Password</label>
                        <input type="password" name="password" class="form-control bg-light @error('password') is-invalid @enderror" required autofocus>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-3">Confirm</button>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection