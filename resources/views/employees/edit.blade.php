@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                <h4 class="fw-bold mb-0">Edit Employee Profile</h4>
                <p class="text-muted small mt-1">Update details for {{ $employee->first_name }} {{ $employee->last_name }}.</p>
            </div>

            <div class="card-body p-4">
                <form method="POST" action="{{ route('employees.update', $employee) }}">
                    @csrf
                    @method('PUT')

                    <h6 class="fw-bold text-uppercase text-primary mb-3">Personal Information</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">First Name</label>
                            <input type="text" name="first_name" value="{{ $employee->first_name }}" class="form-control bg-light border-0 py-2 shadow-none" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Last Name</label>
                            <input type="text" name="last_name" value="{{ $employee->last_name }}" class="form-control bg-light border-0 py-2 shadow-none" required>
                        </div>
                    </div>

                    <hr class="text-light-subtle my-4">
                    <h6 class="fw-bold text-uppercase text-primary mb-3">Employment Details</h6>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Department</label>
                            <select name="department_id" class="form-select bg-light border-0 py-2 shadow-none" required>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ $employee->department_id == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Position</label>
                            <input type="text" name="position" value="{{ $employee->position }}" class="form-control bg-light border-0 py-2 shadow-none" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Base Salary</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted">₱</span>
                                <input type="number" step="0.01" name="salary" value="{{ $employee->salary }}" class="form-control bg-light border-0 py-2 shadow-none" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Account Status</label>
                            <select name="is_active" class="form-select bg-light border-0 py-2 shadow-none" required>
                                <option value="1" {{ $employee->is_active ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !$employee->is_active ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <hr class="text-muted my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('employees.index') }}" class="btn btn-light fw-bold px-4 rounded-3 text-muted">Cancel</a>
                        <button type="submit" class="btn btn-primary fw-bold px-4 rounded-3">
                            <i class="bi bi-check2-circle me-1"></i> Update Employee
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection