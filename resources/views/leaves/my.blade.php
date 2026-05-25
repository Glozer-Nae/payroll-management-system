@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">My Leaves</h2>
    <a href="{{ route('leaves.create') ?? '#' }}" class="btn btn-primary rounded-pill px-4 fw-semibold">
        <i class="bi bi-plus-lg me-1"></i> Apply Leave
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0 mt-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary">
                    <tr>
                        <th class="py-3 px-4 border-0">Leave Type</th>
                        <th class="py-3 border-0">Dates</th>
                        <th class="py-3 border-0">Status</th>
                        <th class="py-3 px-4 border-0 text-end">Paid?</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($leaves as $leave)
                    <tr>
                        <td class="px-4 py-3 fw-bold text-dark">
                            {{ ucfirst($leave->type) }}
                        </td>
                        <td class="py-3 text-muted">
                            <i class="bi bi-calendar-event small me-2 text-secondary"></i>
                            {{ \Carbon\Carbon::parse($leave->start_date)->format('M d, Y') }} 
                            <span class="text-muted mx-1">to</span> 
                            {{ \Carbon\Carbon::parse($leave->end_date)->format('M d, Y') }}
                        </td>
                        <td class="py-3">
                            @if($leave->status === 'approved')
                                <span class="badge bg-success bg-opacity-25 text-success border border-success rounded-pill px-3 py-2">Approved</span>
                            @elseif($leave->status === 'pending')
                                <span class="badge bg-warning text-dark bg-opacity-25 border border-warning rounded-pill px-3 py-2">Pending</span>
                            @else
                                <span class="badge bg-danger bg-opacity-25 text-danger border border-danger rounded-pill px-3 py-2">Rejected</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-end">
                            @if($leave->is_paid)
                                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 rounded-pill px-3">Yes</span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-3">No</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bi bi-calendar-x fs-1 text-secondary mb-2"></i>
                                <span>You have no leave history.</span>
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