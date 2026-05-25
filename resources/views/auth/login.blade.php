@extends('layouts.guest')

@section('content')
<div class="container-fluid vh-100">
    <div class="row h-100">
        
        {{-- LEFT SIDE --}}
        <div class="col-md-6 d-none d-md-flex flex-column justify-content-center align-items-center bg-dark text-white">
            <div class="text-center w-75">
                <i class="bi bi-cash-stack display-1 text-primary mb-4"></i>
                <h1 class="display-5 fw-bold">Payroll Management System</h1>
                <p class="lead mt-3 text-white-50">
                    Manage employees, payrolls, attendance, overtime, and leave requests efficiently.
                </p>
            </div>
        </div>

        {{-- RIGHT SIDE --}}
        <div class="col-md-6 d-flex justify-content-center align-items-center bg-light">
            <div class="card shadow-sm p-4 p-md-5 w-100 border-0 rounded-4" style="max-width: 450px;">
                
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-dark">Welcome Back</h2>
                    <p class="text-muted">Sign in to your account</p>
                </div>

                {{-- SESSION STATUS --}}
                @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                   {{-- EMAIL --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg bg-light border-0 shadow-sm @error('email') is-invalid @enderror" required autofocus>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">Password</label>
                        <input type="password" name="password" class="form-control form-control-lg bg-light border-0 shadow-sm @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- REMEMBER & FORGOT PWD --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label text-muted small" for="remember">Remember Me</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-decoration-none small fw-semibold">Forgot Password?</a>
                        @endif
                    </div>

                    {{-- BUTTON --}}
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-3">
                        Sign In
                    </button>
                    
                    @if (Route::has('register'))
                        <div class="text-center mt-4 text-muted small">
                            Don't have an account? <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">Register here</a>
                        </div>
                    @endif
                </form>

            </div>
        </div>

    </div>
</div>
@endsection