@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        
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
                <h4 class="fw-bold mb-0">Add New Employee</h4>
                <p class="text-muted small mt-1">Enter the personal and professional details of the new hire.</p>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('employees.store') }}" method="POST">
                    @csrf

                    <h6 class="fw-bold text-uppercase text-primary mb-3">Personal Information</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control bg-light border-0 py-2 shadow-none" placeholder="e.g. Jane" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control bg-light border-0 py-2 shadow-none" placeholder="e.g. Doe" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control bg-light border-0 py-2 shadow-none" placeholder="jane.doe@company.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Account Password</label>
                            <input type="password" name="password" class="form-control bg-light border-0 py-2 shadow-none" placeholder="Create a strong password" required>
                        </div>
                    </div>

                    <hr class="text-light-subtle my-4">
                    <h6 class="fw-bold text-uppercase text-primary mb-3">Employment Details</h6>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Department</label>
                            @if($departments->isEmpty())
                                <div class="text-danger small mb-1"><i class="bi bi-info-circle"></i> No departments available.</div>
                            @endif
                            <select name="department_id" class="form-select bg-light border-0 py-2 shadow-none" required>
                                <option value="" disabled selected>-- Select Department --</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Position</label>
                            <input type="text" name="position" value="{{ old('position') }}" class="form-control bg-light border-0 py-2 shadow-none" placeholder="e.g. Software Engineer" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Base Salary</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted">₱</span>
                                <input type="number" step="0.01" name="salary" value="{{ old('salary') }}" class="form-control bg-light border-0 py-2 shadow-none" placeholder="0.00" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Account Status</label>
                            <select name="is_active" class="form-select bg-light border-0 py-2 shadow-none" required>
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <hr class="text-muted my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('employees.index') }}" class="btn btn-light fw-bold px-4 rounded-3 text-muted">Cancel</a>
                        <button type="submit" class="btn btn-primary fw-bold px-4 rounded-3">
                            <i class="bi bi-person-plus me-1"></i> Save Employee
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection