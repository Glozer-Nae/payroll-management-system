@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">My Dashboard</h2>
    <p class="text-muted">Welcome back! Here is your summary for the current period.</p>
</div>

<div class="row g-4">
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4 text-center d-flex flex-column justify-content-center">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-calendar-check fs-3"></i>
                </div>
                <h6 class="text-muted text-uppercase fw-bold mb-2">Attendance This Month</h6>
                <h2 class="fw-bolder text-dark mb-0">{{ $attendanceCount }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4 text-center d-flex flex-column justify-content-center">
                <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-hourglass-split fs-3"></i>
                </div>
                <h6 class="text-muted text-uppercase fw-bold mb-2">Pending Leaves</h6>
                <h2 class="fw-bolder text-dark mb-0">{{ $pendingLeaves }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4 text-center d-flex flex-column justify-content-center">
                <div class="bg-info bg-opacity-10 text-info rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-clock-history fs-3"></i>
                </div>
                <h6 class="text-muted text-uppercase fw-bold mb-2">Overtime Hours</h6>
                <h2 class="fw-bolder text-dark mb-0">{{ $overtimeHours }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4 text-center d-flex flex-column justify-content-center">
                <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-wallet2 fs-3"></i>
                </div>
                <h6 class="text-muted text-uppercase fw-bold mb-2">Latest Salary</h6>
                @if($latestPayroll)
                    <h2 class="fw-bolder text-success mb-0">₱{{ number_format($latestPayroll->net_salary, 2) }}</h2>
                @else
                    <h5 class="text-muted fst-italic mb-0">No Payroll Yet</h5>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection