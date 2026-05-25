@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">My Payslips</h2>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        
        {{-- ✅ FILTER --}}
        <form method="GET" class="row g-2 align-items-end mb-4 bg-light p-3 rounded-3 border border-light-subtle">
            <div class="col-md-4">
                <label class="form-label text-muted small fw-semibold mb-1">Filter by Month</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-calendar-month text-muted"></i></span>
                    <input type="month" name="month" value="{{ request('month') }}" class="form-control bg-white border-start-0 shadow-none">
                </div>
            </div>
            <div class="col-md-auto d-flex gap-2">
                <button class="btn btn-primary px-4 fw-semibold">
                    <i class="bi bi-search me-1"></i> Filter
                </button>
                <a href="{{ route('payrolls.my') }}" class="btn btn-outline-secondary px-3">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary">
                    <tr>
                        <th class="py-3 px-3 border-0">Month</th>
                        <th class="py-3 border-0">Gross Pay</th>
                        <th class="py-3 border-0">Deductions</th>
                        <th class="py-3 border-0">Net Pay</th>
                        <th class="py-3 px-3 border-0 text-end">Action</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($payrolls as $p)
                    <tr>
                        <td class="px-3 py-3 fw-bold text-dark">
                            <i class="bi bi-calendar2-check text-primary me-2"></i>
                            {{ \Carbon\Carbon::parse($p->month)->format('F Y') }}
                        </td>
                        <td class="py-3 text-success fw-semibold">₱{{ number_format($p->salary, 2) }}</td>
                        <td class="py-3 text-danger fw-semibold">- ₱{{ number_format($p->deductions, 2) }}</td>
                        <td class="py-3 fw-bold fs-6">₱{{ number_format($p->net_salary, 2) }}</td>
                        <td class="px-3 py-3 text-end">
                            <a href="{{ route('payrolls.show', $p->id) }}" class="btn btn-outline-info btn-sm rounded-pill px-3">
                                <i class="bi bi-eye me-1"></i> View Payslip
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bi bi-receipt fs-1 text-secondary mb-2"></i>
                                <span>No payslips found for the selected month.</span>
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