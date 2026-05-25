@extends('layouts.app')

@section('content')
<style>
    @media print {
        body { background-color: white !important; }
        nav, .navbar, .no-print { display: none !important; }
        main { padding: 0 !important; }
        .card { box-shadow: none !important; border: 1px solid #dee2e6 !important; border-radius: 0 !important; margin: 0 !important;}
        .container { max-width: 100% !important; padding: 0 !important; }
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    @if(Auth::user()->role === 'employee')
        <a href="{{ route('payrolls.my') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
    @else
        <a href="{{ route('payrolls.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
    @endif
    <div class="d-flex gap-2">
        <a href="{{ route('payroll.pdf', $payroll->id) }}" class="btn btn-dark rounded-pill px-4 fw-semibold">
            <i class="bi bi-file-earmark-pdf me-1"></i> Download PDF
        </a>
        <button onclick="window.print()" class="btn btn-primary rounded-pill px-4 fw-semibold">
            <i class="bi bi-printer me-1"></i> Print Payslip
        </button>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
            
            <div class="row border-bottom pb-4 mb-4">
                <div class="col-sm-6 text-center text-sm-start">
                    <h3 class="fw-bold text-dark mb-0 d-flex align-items-center justify-content-center justify-content-sm-start gap-2">
                        <i class="bi bi-buildings text-primary"></i> {{ config('app.name', 'Company Name') }}
                    </h3>
                    <p class="text-muted small mt-1 mb-0">Official Payroll Payslip</p>
                </div>
                <div class="col-sm-6 text-center text-sm-end mt-3 mt-sm-0">
                    <h5 class="text-uppercase fw-bold text-muted mb-1">Payslip</h5>
                    <p class="mb-0 fw-semibold">Month: <span class="text-dark">{{ \Carbon\Carbon::parse($payroll->month)->format('F Y') }}</span></p>
                    <p class="text-muted small">Pay Date: {{ $payroll->pay_date ? \Carbon\Carbon::parse($payroll->pay_date)->format('M d, Y') : now()->format('M d, Y') }}</p>
                </div>
            </div>

            <div class="bg-light p-3 rounded-3 mb-4 border border-light-subtle">
                <div class="row">
                    <div class="col-sm-6">
                        <p class="mb-1 text-muted small text-uppercase fw-bold">Employee Information</p>
                        <h5 class="fw-bold mb-1">{{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}</h5>
                        <p class="mb-0 text-muted">{{ $payroll->employee->position }}</p>
                    </div>
                    <div class="col-sm-6 text-sm-end mt-3 mt-sm-0 d-flex flex-column justify-content-center">
                        <p class="mb-1 text-muted small text-uppercase fw-bold">Status</p>
                        <div>
                            @if($payroll->status === 'draft')
                                <span class="badge bg-warning text-dark px-3 py-2 fs-6 rounded-1">Draft</span>
                            @else
                                <span class="badge bg-success px-3 py-2 fs-6 rounded-1">Finalized</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 g-4">
                <div class="col-md-6">
                    <h6 class="fw-bold border-bottom pb-2 mb-3 text-success text-uppercase">Earnings</h6>
                    <table class="table table-borderless table-sm mb-0">
                        <tbody>
                            <tr>
                                <td class="text-secondary py-2">Gross Base Salary</td>
                                <td class="text-end fw-semibold py-2">₱{{ number_format($payroll->salary, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-secondary py-2">Overtime Pay</td>
                                <td class="text-end fw-semibold py-2">₱{{ number_format($payroll->overtime_pay, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6">
                    <h6 class="fw-bold border-bottom pb-2 mb-3 text-danger text-uppercase">Deductions</h6>
                    <table class="table table-borderless table-sm mb-0">
                        <tbody>
                            @if($payroll->absences_deduction > 0)
                            <tr>
                                <td class="text-secondary py-2">Absences Deduction</td>
                                <td class="text-end fw-semibold text-danger py-2">- ₱{{ number_format($payroll->absences_deduction, 2) }}</td>
                            </tr>
                            @endif
                            
                            @if($payroll->leaves_deduction > 0)
                            <tr>
                                <td class="text-secondary py-2">Unpaid Leave Deduction</td>
                                <td class="text-end fw-semibold text-danger py-2">- ₱{{ number_format($payroll->leaves_deduction, 2) }}</td>
                            </tr>
                            @endif

                            @foreach($payroll->payrollDeductions as $deduction)
                            <tr>
                                <td class="text-secondary py-2">{{ $deduction->deductionType->name }}</td>
                                <td class="text-end fw-semibold text-danger py-2">- ₱{{ number_format($deduction->amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row border-top pt-4 mt-2">
                <div class="col-md-6 offset-md-6">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-semibold text-muted">Total Gross Pay:</span>
                        <span class="fw-bold">₱{{ number_format($payroll->salary + $payroll->overtime_pay, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 border-bottom pb-3">
                        <span class="fw-semibold text-muted">Total Deductions:</span>
                        <span class="fw-bold text-danger">- ₱{{ number_format($payroll->deductions, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between bg-dark text-white p-3 rounded-3 shadow-sm">
                        <span class="fw-bold fs-5">NET SALARY:</span>
                        <span class="fw-bold fs-5">₱{{ number_format($payroll->net_salary, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-5 pt-4 text-end">
                <div class="d-inline-block border-top border-dark pt-2 px-4 text-center">
                    <p class="mb-0 fw-bold">Authorized Signature</p>
                    <small class="text-muted">Finance Department</small>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection