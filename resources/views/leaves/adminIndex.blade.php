@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Leave Requests</h2>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
        
        {{-- ✅ FILTER --}}
        <form method="GET" class="row g-2 align-items-end mb-4 bg-light p-3 rounded-3 border border-light-subtle">
            <div class="col-md-4">
                <label class="form-label text-muted small fw-semibold mb-1">Filter by Status</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-funnel text-muted"></i></span>
                    <select name="status" class="form-select bg-white border-start-0 shadow-none">
                        <option value="">All Requests</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
            </div>
            <div class="col-md-auto d-flex gap-2">
                <button class="btn btn-primary px-4 fw-semibold">
                    Filter
                </button>
            </div>
        </form>

        {{-- ✅ TABLE --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary">
                    <tr>
                        <th class="py-3 px-3 border-0">Employee</th>
                        <th class="py-3 border-0">Leave Type</th>
                        <th class="py-3 border-0">Dates</th>
                        <th class="py-3 border-0">Status</th>
                        <th class="py-3 border-0">Paid</th>
                        <th class="py-3 px-3 border-0 text-end">Action</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($leaves as $leave)
                    <tr>
                        <td class="px-3 py-3 fw-bold text-dark">
                            <i class="bi bi-person-circle text-secondary me-2"></i>
                            {{ $leave->employee->first_name }}
                        </td>
                        <td class="py-3 text-muted fw-semibold">
                            {{ ucfirst($leave->type) }}
                        </td>
                        <td class="py-3 text-muted">
                            <i class="bi bi-calendar3 small me-1"></i> 
                            {{ \Carbon\Carbon::parse($leave->start_date)->format('M d, Y') }} 
                            <i class="bi bi-arrow-right mx-1"></i> 
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
                        <td class="py-3">
                            @if($leave->is_paid)
                                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 rounded-pill px-3">Yes</span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-3">No</span>
                            @endif
                        </td>
                        <td class="px-3 py-3 text-end">
                            @if($leave->status == 'pending')
                                <div class="btn-group btn-group-sm">
                                    <form method="POST" action="{{ route('leaves.approve', $leave->id) }}" class="d-inline">
                                        @csrf
                                        <button class="btn btn-outline-success" title="Approve" onclick="return confirm('Approve this leave request?');">
                                            <i class="bi bi-check-lg fw-bold"></i> Approve
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('leaves.reject', $leave->id) }}" class="d-inline ms-1">
                                        @csrf
                                        <button class="btn btn-outline-danger" title="Reject" onclick="return confirm('Reject this leave request?');">
                                            <i class="bi bi-x-lg fw-bold"></i> Reject
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-muted small fst-italic">Processed</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bi bi-inbox fs-1 text-secondary mb-2"></i>
                                <span>No leave requests found.</span>
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