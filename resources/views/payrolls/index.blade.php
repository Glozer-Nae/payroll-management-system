@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0">Payroll Records</h2>
        <p class="text-muted mb-0">
            Logged in as: <strong class="text-primary">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</strong>
        </p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
        {{-- ✅ GENERATE PAYROLL --}}
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'payroll_officer')
        <div class="bg-light p-3 rounded-3 mb-4 border border-light-subtle">
            <form method="POST" action="{{ route('payroll.generate') }}" class="row g-2 align-items-end">
                @csrf
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary small mb-1">Generate Monthly Payroll</label>
                    <input type="month" name="month" class="form-control bg-white shadow-none" required>
                </div>
                <div class="col-md-auto">
                    <button class="btn btn-success px-4 fw-semibold">
                        <i class="bi bi-gear-fill me-1"></i> Generate Payroll
                    </button>
                </div>
            </form>
        </div>
        @endif

        {{-- ✅ FILTER --}}
        <form method="GET" class="row g-3 align-items-end mb-4">
            <div class="col-md-3">
                <label class="form-label text-muted small fw-semibold mb-1">Filter by Month</label>
                <input type="month" name="month" class="form-control shadow-none" value="{{ request('month') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small fw-semibold mb-1">Search Employee</label>
                <input type="text" name="employee" class="form-control shadow-none" placeholder="Enter employee name..." value="{{ request('employee') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted small fw-semibold mb-1">Status</label>
                <select name="status" class="form-select shadow-none">
                    <option value="">All Statuses</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="finalized" {{ request('status') == 'finalized' ? 'selected' : '' }}>Finalized</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100 fw-semibold">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary">
                    <tr>
                        <th class="py-3 px-3 border-0">Employee</th>
                        <th class="py-3 border-0">Month</th>
                        <th class="py-3 border-0">Gross Salary</th>
                        <th class="py-3 border-0">Deductions</th>
                        <th class="py-3 border-0">Net Salary</th>
                        <th class="py-3 border-0">Status</th> 
                        <th class="py-3 px-3 border-0 text-end">Action</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($payrolls as $pay)
                    <tr>
                        <td class="px-3 py-3 fw-bold text-dark">{{ $pay->employee->first_name }} {{ $pay->employee->last_name }}</td>
                        <td class="py-3 text-muted">{{ \Carbon\Carbon::parse($pay->month)->format('F Y') }}</td>
                        <td class="py-3 text-success fw-semibold">₱{{ number_format($pay->salary, 2) }}</td>
                        <td class="py-3 text-danger fw-semibold">₱{{ number_format($pay->deductions, 2) }}</td>
                        <td class="py-3 fw-bold">₱{{ number_format($pay->net_salary, 2) }}</td>
                        <td class="py-3">
                            @if($pay->status === 'draft')
                                <span class="badge bg-warning text-dark bg-opacity-25 border border-warning rounded-pill px-3 py-2">Draft</span>
                            @else
                                <span class="badge bg-success bg-opacity-25 text-success border border-success rounded-pill px-3 py-2">Finalized</span>
                            @endif
                        </td>
                        <td class="px-3 py-3 text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('payrolls.show', $pay->id) }}" class="btn btn-outline-info" title="View Payslip">
                                    <i class="bi bi-file-text"></i> View
                                </a>

                                @if(($pay->status === 'draft') && (auth()->user()->role === 'admin' || auth()->user()->role === 'payroll_officer'))
                                    <form method="POST" action="{{ route('payroll.finalize', $pay->id) }}" class="d-inline">
                                        @csrf
                                        <button class="btn btn-outline-success" title="Finalize Payroll" onclick="return confirm('Are you sure you want to finalize this payroll?');">
                                            <i class="bi bi-check-circle"></i> Finalize
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bi bi-folder2-open fs-1 text-secondary mb-2"></i>
                                <span>No payroll records found for the selected criteria.</span>
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