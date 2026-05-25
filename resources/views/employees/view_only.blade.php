@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0">Employee Directory (View Only)</h2>
        <p class="text-muted mb-0">Read-only employee directory for payroll processing.</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary">
                    <tr>
                        <th class="py-3 px-3 border-0">Employee Name</th>
                        <th class="py-3 border-0">Department</th>
                        <th class="py-3 border-0">Position</th>
                        <th class="py-3 px-3 border-0">Status</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($employees as $employee)
                        <tr>
                            <td class="px-3 py-3 fw-bold text-dark">
                                <i class="bi bi-person-circle text-secondary me-2"></i>
                                {{ $employee->first_name }} {{ $employee->last_name }}
                            </td>
                            <td class="py-3 text-muted">{{ $employee->department->name ?? 'Unassigned' }}</td>
                            <td class="py-3 text-muted">{{ $employee->position }}</td>
                            <td class="px-3 py-3">
                                @if($employee->is_active)
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1">Active</span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-3 py-1">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
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