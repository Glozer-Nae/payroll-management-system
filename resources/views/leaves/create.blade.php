@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                <h4 class="fw-bold mb-0">Apply for Leave</h4>
                <p class="text-muted small mt-1">Submit a new time-off request for approval.</p>
            </div>

            <div class="card-body p-4">
                <form method="POST" action="{{ route('leaves.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">Leave Type</label>
                        <select name="type" class="form-select bg-light border-0 py-2 shadow-none" required>
                            <option value="" disabled selected>-- Select Type --</option>
                            <option value="sick">Sick Leave</option>
                            <option value="vacation">Vacation Leave</option>
                            <option value="emergency">Emergency Leave</option>
                        </select>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Start Date</label>
                            <input type="date" name="start_date" class="form-control bg-light border-0 py-2 shadow-none" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">End Date</label>
                            <input type="date" name="end_date" class="form-control bg-light border-0 py-2 shadow-none" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">Payment Setup</label>
                        <select name="is_paid" class="form-select bg-light border-0 py-2 shadow-none" required>
                            <option value="1">Paid Leave</option>
                            <option value="0">Unpaid Leave</option>
                        </select>
                    </div>

                    <hr class="text-muted my-4">

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold rounded-3">
                            <i class="bi bi-send me-1"></i> Submit Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection