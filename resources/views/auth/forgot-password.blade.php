@extends('layouts.guest')

@section('content')
<div class="container-fluid vh-100">
    <div class="row h-100">
        
        <div class="col-md-6 d-none d-md-flex flex-column justify-content-center align-items-center bg-dark text-white">
            <div class="text-center w-75">
                <i class="bi bi-shield-lock display-1 text-primary mb-4"></i>
                <h1 class="display-5 fw-bold">Secure Recovery</h1>
                <p class="lead mt-3 text-white-50">Regain access to your Payroll Management account securely.</p>
            </div>
        </div>

        <div class="col-md-6 d-flex justify-content-center align-items-center bg-light">
            <div class="card shadow-sm p-4 p-md-5 w-100 border-0 rounded-4" style="max-width: 450px;">
                
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-dark">Forgot Password?</h3>
                    <p class="text-muted small">No problem. Let us know your email address and we will email you a password reset link.</p>
                </div>

                @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm small" role="alert">
                        <i class="bi bi-check-circle-fill me-1"></i>{{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control bg-light @error('email') is-invalid @enderror" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-3">
                        Email Password Reset Link
                    </button>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="text-decoration-none text-muted small"><i class="bi bi-arrow-left me-1"></i> Back to login</a>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection