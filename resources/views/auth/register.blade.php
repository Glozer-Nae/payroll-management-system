@extends('layouts.guest')

@section('content')
<div class="container-fluid vh-100">
    <div class="row h-100">
        
        <div class="col-md-6 d-none d-md-flex flex-column justify-content-center align-items-center bg-dark text-white">
            <div class="text-center w-75">
                <i class="bi bi-person-plus display-1 text-primary mb-4"></i>
                <h1 class="display-5 fw-bold">Join the Team</h1>
                <p class="lead mt-3 text-white-50">Create your account to access the Payroll Management System.</p>
            </div>
        </div>

        <div class="col-md-6 d-flex justify-content-center align-items-center bg-light">
            <div class="card shadow-sm p-4 p-md-5 w-100 border-0 rounded-4" style="max-width: 450px;">
                
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-dark">Register</h2>
                    <p class="text-muted">Set up your new account</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- NAME --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control bg-light @error('name') is-invalid @enderror" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control bg-light @error('email') is-invalid @enderror" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Password</label>
                        <input type="password" name="password" class="form-control bg-light @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- CONFIRM PASSWORD --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control bg-light" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-3">Register</button>

                    <div class="text-center mt-4 text-muted small">
                        Already registered? <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">Sign in</a>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection