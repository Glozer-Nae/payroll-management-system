@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="fw-bold mb-0">Employee Directory</h2>
        <p class="text-muted mb-0">Manage your organization's workforce.</p>
    </div>
    <a href="{{ route('employees.create') }}" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
        <i class="bi bi-person-plus-fill me-1"></i> Add Employee
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary">
                    <tr>
                        <th class="py-3 px-3 border-0">Name</th>
                        <th class="py-3 border-0">Position</th>
                        <th class="py-3 border-0">Salary</th>
                        <th class="py-3 border-0">Status</th>
                        <th class="py-3 px-3 border-0 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($employees as $emp)
                    <tr>
                        <td class="px-3 py-3 fw-bold text-dark">
                            <i class="bi bi-person-circle text-secondary me-2 fs-5 align-middle"></i>
                            {{ $emp->first_name }} {{ $emp->last_name }}
                        </td>
                        <td class="py-3 text-muted">{{ $emp->position }}</td>
                        <td class="py-3 fw-semibold text-success">₱{{ number_format($emp->salary, 2) }}</td>
                        <td class="py-3">
                            @if($emp->is_active && $emp->user && $emp->user->is_active)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1">Active</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-1">Inactive</span>
                            @endif
                        </td>
                        <td class="px-3 py-3 text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('employees.edit', $emp->id) }}" class="btn btn-outline-primary" title="Edit Employee">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('employees.destroy', $emp->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger" title="Delete Employee" onclick="return confirm('Are you sure you want to permanently delete this employee?');">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bi bi-people fs-1 text-secondary mb-2"></i>
                                <span>No employees found in the directory.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection