@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <div class="mb-4">
        <h2 class="fw-bold mb-0">Edit Deduction</h2>
        <p class="text-muted mb-0">Update settings for {{ $deduction->name }}</p>
    </div>

    <div class="card shadow-sm border-0 rounded-4" style="max-width: 600px;">
        <div class="card-body p-4 p-md-5">
            
            <form method="POST" action="{{ route('deductions.update', $deduction) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary">Deduction Name</label>
                    <input type="text" name="name" value="{{ $deduction->name }}" class="form-control bg-light border-0 shadow-sm" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary">Type</label>
                    <select name="type" class="form-select bg-light border-0 shadow-sm" required>
                        <option value="percentage" {{ $deduction->type == 'percentage' ? 'selected' : '' }}>
                            Percentage (%)
                        </option>
                        <option value="fixed" {{ $deduction->type == 'fixed' ? 'selected' : '' }}>
                            Fixed Amount (₱)
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary">Value</label>
                    <input type="number" step="0.01" name="value" value="{{ $deduction->value }}" class="form-control bg-light border-0 shadow-sm" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary">Status</label>
                    <select name="is_active" class="form-select bg-light border-0 shadow-sm" required>
                        <option value="1" {{ $deduction->is_active ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$deduction->is_active ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('deductions.index') }}" class="btn btn-light fw-semibold">Cancel</a>
                    <button type="submit" class="btn btn-success fw-bold px-4">
                        <i class="bi bi-save me-1"></i> Update Deduction
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection