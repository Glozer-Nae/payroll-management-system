@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">My Attendance History</h2>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0 mt-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary">
                    <tr>
                        <th class="py-3 px-4 border-0">Date</th>
                        <th class="py-3 px-4 border-0 text-end">Status</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($attendances as $att)
                    <tr>
                        <td class="px-4 py-3 text-dark fw-semibold">
                            <i class="bi bi-calendar2-day text-primary me-2"></i>
                            {{ \Carbon\Carbon::parse($att->date)->format('l, F j, Y') }}
                        </td>
                        <td class="px-4 py-3 text-end">
                            @if($att->status === 'present')
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1 fs-6">Present</span>
                            @elseif($att->status === 'late')
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-3 py-1 fs-6">Late</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-1 fs-6">Absent</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="text-center py-5 text-muted">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bi bi-calendar-x fs-1 text-secondary mb-2"></i>
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