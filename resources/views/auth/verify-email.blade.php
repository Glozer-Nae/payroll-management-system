@extends('layouts.guest')

@section('content')
<div class="container-fluid vh-100">
    <div class="row h-100">
        
        <div class="col-md-6 d-none d-md-flex flex-column justify-content-center align-items-center bg-dark text-white">
            <div class="text-center w-75">
                <i class="bi bi-envelope-check display-1 text-primary mb-4"></i>
                <h1 class="display-5 fw-bold">Verify Your Email</h1>
                <p class="lead mt-3 text-white-50">Just one more step before you can access the system.</p>
            </div>
        </div>

        <div class="col-md-6 d-flex justify-content-center align-items-center bg-light">
            <div class="card shadow-sm p-4 p-md-5 w-100 border-0 rounded-4" style="max-width: 500px;">
                
                <div class="mb-4 text-muted small lh-lg">
                    Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success small shadow-sm border-0 mb-4" role="alert">
                        <i class="bi bi-check-circle me-1"></i> A new verification link has been sent to the email address you provided during registration.
                    </div>
                @endif

                <div class="d-flex align-items-center justify-content-between mt-4">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary fw-bold rounded-3 px-4">
                            Resend Email
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link text-decoration-none text-muted">
                            Log Out
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection