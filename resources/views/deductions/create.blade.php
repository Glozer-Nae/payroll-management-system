@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <div class="mb-4">
        <h2 class="fw-bold mb-0">Add Deduction</h2>
        <p class="text-muted mb-0">Create a new deduction rule for payroll</p>
    </div>

    <div class="card shadow-sm border-0 rounded-4" style="max-width: 600px;">
        <div class="card-body p-4 p-md-5">
            
            <form method="POST" action="{{ route('deductions.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary">Deduction Name</label>
                    <input type="text" name="name" class="form-control bg-light border-0 shadow-sm" placeholder="e.g., SSS, PhilHealth, Tax" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary">Type</label>
                    <select name="type" class="form-select bg-light border-0 shadow-sm" required>
                        <option value="percentage">Percentage (%)</option>
                        <option value="fixed">Fixed Amount (₱)</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary">Value</label>
                    <input type="number" step="0.01" name="value" class="form-control bg-light border-0 shadow-sm" placeholder="0.00" required>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('deductions.index') }}" class="btn btn-light fw-semibold">Cancel</a>
                    <button type="submit" class="btn btn-primary fw-bold px-4">
                        <i class="bi bi-check-lg me-1"></i> Save Deduction
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection