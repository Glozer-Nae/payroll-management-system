@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Deduction Management</h2>
            <p class="text-muted mb-0">Manage system-wide payroll deductions</p>
        </div>
        <a href="{{ route('deductions.create') }}" class="btn btn-primary shadow-sm fw-semibold">
            <i class="bi bi-plus-circle me-1"></i> Add Deduction
        </a>
    </div>

    {{-- Table Card --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-3 px-4 text-secondary fw-semibold">Name</th>
                        <th class="py-3 text-secondary fw-semibold">Type</th>
                        <th class="py-3 text-secondary fw-semibold">Value</th>
                        <th class="py-3 text-secondary fw-semibold">Status</th>
                        <th class="py-3 text-secondary fw-semibold text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($deductions as $deduction)
                        <tr>
                            <td class="px-4 fw-medium">{{ $deduction->name }}</td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ ucfirst($deduction->type) }}
                                </span>
                            </td>
                            <td class="fw-semibold">
                                @if($deduction->type === 'percentage')
                                    {{ $deduction->value }}%
                                @else
                                    ₱{{ number_format($deduction->value, 2) }}
                                @endif
                            </td>
                            <td>
                                @if($deduction->is_active)
                                    <span class="badge rounded-pill bg-success">Active</span>
                                @else
                                    <span class="badge rounded-pill bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('deductions.edit', $deduction) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('deductions.destroy', $deduction) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this deduction?');">
                                        <i class="bi bi-trash3"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                                No deductions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection