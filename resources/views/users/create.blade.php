@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3 mb-4" role="alert">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                    <strong>Please correct the following errors:</strong>
                </div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                <h4 class="fw-bold mb-0">Create User</h4>
                <p class="text-muted small mt-1">Provision a new account for the system.</p>
            </div>

            <div class="card-body p-4">
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-person"></i></span>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control bg-light border-0 py-2 shadow-none" placeholder="e.g. John Doe" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control bg-light border-0 py-2 shadow-none" placeholder="name@company.com" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control bg-light border-0 py-2 shadow-none" placeholder="Create a secure password" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">System Role</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-shield-check"></i></span>
                            <select name="role" class="form-select bg-light border-0 py-2 shadow-none" required>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="payroll_officer" {{ old('role') == 'payroll_officer' ? 'selected' : '' }}>Payroll Officer</option>
                                <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Employee</option>
                            </select>
                        </div>
                    </div>

                    <hr class="text-muted my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('users.index') }}" class="btn btn-light fw-bold px-4 rounded-3 text-muted">Cancel</a>
                        <button type="submit" class="btn btn-primary fw-bold px-4 rounded-3">
                            <i class="bi bi-person-check me-1"></i> Save User
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>
@endsection