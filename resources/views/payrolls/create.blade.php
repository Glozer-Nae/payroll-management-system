@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        
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
                <h4 class="fw-bold mb-0">Generate Manual Payroll</h4>
                <p class="text-muted small mt-1">Create a custom payroll entry for a specific employee.</p>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('payroll.generate') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">Select Employee</label>
                        <select name="employee_id" class="form-select bg-light border-0 py-2 shadow-none" required>
                            <option value="" disabled selected>-- Choose an Employee --</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">
                                    {{ $emp->first_name }} {{ $emp->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">Manual Deductions (₱)</label>
                        <input type="number" step="0.01" name="deductions" placeholder="0.00" class="form-control bg-light border-0 py-2 shadow-none" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">Pay Date</label>
                        <input type="date" name="pay_date" class="form-control bg-light border-0 py-2 shadow-none" required>
                    </div>

                    <hr class="text-muted my-4">

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg fw-bold rounded-3">
                            <i class="bi bi-calculator me-1"></i> Generate Payroll
                        </button>
                        <a href="{{ route('payrolls.index') }}" class="btn btn-light fw-semibold rounded-3 text-muted">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection