@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                <h4 class="fw-bold mb-0">Add Attendance Record</h4>
                <p class="text-muted small mt-1">
                    Manually log an employee's daily attendance.
                </p>
            </div>

            <div class="card-body p-4">

                {{-- VALIDATION ERRORS --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('attendances.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">
                            Select Employee
                        </label>

                        <select name="employee_id"
                                class="form-select bg-light border-0 py-2 shadow-none"
                                required>

                            <option value="" disabled selected>
                                -- Choose an Employee --
                            </option>

                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">
                                    {{ $emp->first_name }}
                                    {{ $emp->last_name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="row g-3 mb-4">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">
                                Date
                            </label>

                            <input type="date"
                                   name="date"
                                   class="form-control bg-light border-0 py-2 shadow-none"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">
                                Status
                            </label>

                            <select name="status"
                                    id="status"
                                    class="form-select bg-light border-0 py-2 shadow-none"
                                    required>

                                <option value="present">Present</option>
                                <option value="late">Late</option>
                                <option value="absent">Absent</option>

                            </select>
                        </div>

                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">
                            Overtime Hours
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light border-0 text-muted">
                                <i class="bi bi-clock-history"></i>
                            </span>

                            <input type="number"
                                   id="overtime_hours"
                                   name="overtime_hours"
                                   class="form-control bg-light border-0 py-2 shadow-none"
                                   min="0"
                                   value="0">

                        </div>

                        <div class="form-text small">
                            Overtime is disabled for absent employees.
                        </div>
                    </div>

                    <hr class="text-muted my-4">

                    <div class="d-flex justify-content-end gap-2">

                        <a href="{{ route('attendances.index') }}"
                           class="btn btn-light fw-bold px-4 rounded-3 text-muted">
                            Cancel
                        </a>

                        <button type="submit"
                                class="btn btn-primary fw-bold px-4 rounded-3">

                            <i class="bi bi-floppy me-1"></i>
                            Save Record
                        </button>

                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const status = document.getElementById('status');
    const overtime = document.getElementById('overtime_hours');

    function toggleOvertime() {

        if (status.value === 'absent') {

            overtime.value = 0;
            overtime.setAttribute('readonly', true);

        } else {

            overtime.removeAttribute('readonly');
        }
    }

    toggleOvertime();

    status.addEventListener('change', toggleOvertime);
});
</script>

@endsection