@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="fw-bold mb-1">Payroll Officer Dashboard</h2>
        <p class="text-muted mb-0">Payroll processing summary for <strong>{{ \Carbon\Carbon::parse($month)->format('F Y') }}</strong>.</p>
    </div>

    <a href="{{ route('payrolls.index') }}" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
        <i class="bi bi-card-list me-1"></i> Open Payrolls
    </a>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-success bg-opacity-10 text-success rounded p-2 me-3">
                        <i class="bi bi-cash-stack fs-4"></i>
                    </div>
                    <div class="text-muted small text-uppercase fw-bold">Total Payroll This Month</div>
                </div>
                <h3 class="fw-bolder text-dark mb-0">₱{{ number_format($totalPayrollThisMonth, 2) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded p-2 me-3">
                        <i class="bi bi-person-check fs-4"></i>
                    </div>
                    <div class="text-muted small text-uppercase fw-bold">Employees Paid</div>
                </div>
                <h3 class="fw-bolder text-dark mb-0">{{ $employeesPaid }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-warning bg-opacity-10 text-warning rounded p-2 me-3">
                        <i class="bi bi-file-earmark-text fs-4"></i>
                    </div>
                    <div class="text-muted small text-uppercase fw-bold">Draft Payrolls</div>
                </div>
                <h3 class="fw-bolder text-dark mb-0">{{ $totalDraftPayrolls }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-primary bg-opacity-10 border border-primary border-opacity-10">
    <div class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div class="d-flex align-items-center">
            <i class="bi bi-gear-fill text-primary fs-1 me-3 opacity-75"></i>
            <div>
                <h5 class="fw-bold text-dark mb-1">Payroll Processing Hub</h5>
                <p class="text-muted mb-0">Generate, review, and finalize monthly payroll records for all employees.</p>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('employees.view') }}" class="btn btn-outline-primary bg-white fw-semibold px-4">
                <i class="bi bi-people me-1"></i> Employees View
            </a>
            <a href="{{ route('payrolls.index') }}" class="btn btn-primary fw-semibold px-4 shadow-sm">
                <i class="bi bi-calculator me-1"></i> Manage Payrolls
            </a>
        </div>
    </div>
</div>
@endsection