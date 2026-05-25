@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <h2 class="fw-bold mb-0">Attendance Records</h2>
    <a href="{{ route('attendances.create') }}" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Add Attendance
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
        
        {{-- ✅ FILTER --}}
        <form method="GET" class="row g-2 align-items-end mb-4 bg-light p-3 rounded-3 border border-light-subtle w-auto d-inline-flex">
            <div class="col-auto">
                <label class="form-label text-muted small fw-semibold mb-1">Filter by Date</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-calendar-day text-muted"></i></span>
                    <input type="date" name="date" class="form-control bg-white border-start-0 shadow-none" value="{{ request('date') }}">
                </div>
            </div>
            <div class="col-auto">
                <button class="btn btn-secondary px-4 fw-semibold">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
            </div>
        </form>

        {{-- ✅ TABLE --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary">
                    <tr>
                        <th class="py-3 px-3 border-0">Employee</th>
                        <th class="py-3 border-0">Date</th>
                        <th class="py-3 border-0">Status</th>
                        <th class="py-3 px-3 border-0 text-end">Action</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($attendances as $att)
                    <tr>
                        <td class="px-3 py-3 fw-bold text-dark">
                            <i class="bi bi-person text-secondary me-2"></i>
                            {{ $att->employee->first_name }} {{ $att->employee->last_name }}
                        </td>
                        <td class="py-3 text-muted fw-semibold">
                            {{ \Carbon\Carbon::parse($att->date)->format('M d, Y') }}
                        </td>
                        <td class="py-3">
                            @if($att->status === 'present')
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1">Present</span>
                            @elseif($att->status === 'late')
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-3 py-1">Late</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-1">Absent</span>
                            @endif
                        </td>
                        <td class="px-3 py-3 text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('attendances.edit', $att->id) }}" class="btn btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('attendances.destroy', $att->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this record?');">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bi bi-clipboard-x fs-1 text-secondary mb-2"></i>
                                <span>No attendance records found.</span>
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