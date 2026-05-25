@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="bg-primary p-4 text-center pb-5">
                <h3 class="text-white fw-bold mb-0">My Profile</h3>
            </div>
            
            <div class="card-body p-4 bg-white text-center" style="margin-top: -40px;">
                <div class="bg-white p-2 d-inline-block rounded-circle shadow-sm mb-3">
                    <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="bi bi-person-fill fs-1"></i>
                    </div>
                </div>

                <h4 class="fw-bold text-dark mb-1">{{ $employee->first_name }} {{ $employee->last_name }}</h4>
                <p class="text-muted mb-4">{{ $employee->position }}</p>

                <ul class="list-group list-group-flush text-start mt-2">
                    <li class="list-group-item px-3 py-3 d-flex justify-content-between align-items-center border-light-subtle">
                        <span class="text-muted fw-semibold"><i class="bi bi-building me-2"></i> Department</span>
                        <span class="fw-bold">{{ $employee->department->name ?? 'Unassigned' }}</span>
                    </li>
                    <li class="list-group-item px-3 py-3 d-flex justify-content-between align-items-center border-light-subtle">
                        <span class="text-muted fw-semibold"><i class="bi bi-briefcase me-2"></i> Position</span>
                        <span class="fw-bold">{{ $employee->position }}</span>
                    </li>
                    <li class="list-group-item px-3 py-3 d-flex justify-content-between align-items-center border-light-subtle border-bottom-0">
                        <span class="text-muted fw-semibold"><i class="bi bi-cash-stack me-2"></i> Base Salary</span>
                        <span class="fw-bold text-success">₱{{ number_format($employee->salary, 2) }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection