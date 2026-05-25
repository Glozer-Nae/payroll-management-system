@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="fw-bold mb-0">Admin Dashboard</h2>
        <p class="text-muted mb-0">Overview of company statistics and payroll metrics.</p>
    </div>
    
    {{-- ✅ FILTER --}}
    <form method="GET" class="d-flex bg-white p-2 rounded-pill shadow-sm border border-light-subtle">
        <input type="month" name="month" value="{{ $month }}" class="form-control border-0 bg-transparent shadow-none" required>
        <button class="btn btn-primary rounded-pill px-4 fw-semibold ms-2">
            <i class="bi bi-funnel me-1"></i> Filter
        </button>
    </form>
</div>

{{-- ✅ METRICS CARDS --}}
<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
            <div class="card-body p-4 position-relative">
                <div class="text-muted small text-uppercase fw-bold mb-1">Total Employees</div>
                <h2 class="fw-bolder mb-0 text-dark">{{ $totalEmployees }}</h2>
                <i class="bi bi-people position-absolute text-primary opacity-25" style="font-size: 4rem; right: 10px; bottom: -10px;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
            <div class="card-body p-4 position-relative">
                <div class="text-muted small text-uppercase fw-bold mb-1">Total Payroll</div>
                <h2 class="fw-bolder mb-0 text-dark">₱{{ number_format($totalSalary, 2) }}</h2>
                <i class="bi bi-cash-stack position-absolute text-success opacity-25" style="font-size: 4rem; right: 10px; bottom: -10px;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
            <div class="card-body p-4 position-relative">
                <div class="text-muted small text-uppercase fw-bold mb-1">Employees Paid</div>
                <h2 class="fw-bolder mb-0 text-dark">{{ $employeesPaid }}</h2>
                <i class="bi bi-check2-circle position-absolute text-info opacity-25" style="font-size: 4rem; right: 10px; bottom: -10px;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
            <div class="card-body p-4 position-relative">
                <div class="text-muted small text-uppercase fw-bold mb-1">With Deductions</div>
                <h2 class="fw-bolder mb-0 text-dark">{{ $employeesWithDeductions }}</h2>
                <i class="bi bi-exclamation-triangle position-absolute text-warning opacity-25" style="font-size: 4rem; right: 10px; bottom: -10px;"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    {{-- ✅ PAYROLL TREND CHART --}}
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold mb-0">Monthly Payroll Trend</h5>
            </div>
            <div class="card-body p-4">
                <div style="height: 300px;">
                    <canvas id="payrollChart"
                        data-labels='@json($monthlyData->pluck("label"))'
                        data-values='@json($monthlyData->pluck("total"))'>
                    </canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- ✅ RECENT PAYROLL SUMMARY --}}
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Recent Payroll Summary</h5>
                <a href="{{ route('payrolls.index') }}" class="btn btn-sm btn-light text-primary fw-semibold">View All</a>
            </div>
            <div class="card-body p-0 mt-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary small">
                            <tr>
                                <th class="px-4 py-3 border-0">Employee</th>
                                <th class="py-3 border-0">Net Salary</th>
                                <th class="py-3 px-4 border-0 text-end">Status</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @foreach($payrollSummary as $row)
                            <tr>
                                <td class="px-4 py-3 fw-bold text-dark">
                                    {{ $row->first_name }} {{ $row->last_name }}
                                    <div class="text-muted small fw-normal">{{ $row->month }}</div>
                                </td>
                                <td class="py-3 text-success fw-semibold">
                                    ₱{{ number_format($row->net_salary, 2) }}
                                    <div class="text-muted small fw-normal">Gross: ₱{{ number_format($row->salary, 2) }}</div>
                                </td>
                                <td class="px-4 py-3 text-end">
                                    @if(strtolower($row->status) === 'paid')
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Paid</span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1">{{ ucfirst($row->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ ATTENDANCE SUMMARY --}}
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold mb-0">Attendance Exceptions</h5>
                <p class="text-muted small mt-1">Employees with absences or overtime.</p>
            </div>
            <div class="card-body p-0 mt-2">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary small">
                            <tr>
                                <th class="px-4 py-3 border-0">Employee</th>
                                <th class="py-3 border-0 text-center">Absences</th>
                                <th class="py-3 px-4 border-0 text-center">Overtime (Hrs)</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @foreach($attendanceSummary as $row)
                            <tr>
                                <td class="px-4 py-3 fw-bold text-dark">
                                    {{ $row->first_name }} {{ $row->last_name }}
                                </td>
                                <td class="py-3 text-center text-danger fw-semibold">
                                    {{ $row->total_absences > 0 ? $row->total_absences : '-' }}
                                </td>
                                <td class="px-4 py-3 text-center text-primary fw-semibold">
                                    {{ $row->total_overtime_hours > 0 ? $row->total_overtime_hours : '-' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const canvas = document.getElementById('payrollChart');
        const labels = JSON.parse(canvas.dataset.labels);
        const dataValues = JSON.parse(canvas.dataset.values);
        const ctx = canvas.getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Payroll (₱)',
                    data: dataValues,
                    backgroundColor: 'rgba(13, 110, 253, 0.8)',
                    borderRadius: 6,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5], color: '#e9ecef' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endsection