<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DeductionTypeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserManagementController::class);
        Route::post('/users/{user}/reset-password', [UserManagementController::class, 'resetPassword'])
            ->name('users.reset-password');

        Route::resource('employees', EmployeeController::class);

        Route::resource('departments', DepartmentController::class);
        Route::resource('deductions', DeductionTypeController::class);
        Route::resource('attendances', AttendanceController::class);

        Route::get('/leaves', [LeaveController::class, 'index'])->name('leaves.index');
        Route::post('/leaves/{leave}/approve', [LeaveController::class, 'approve'])->name('leaves.approve');
        Route::post('/leaves/{leave}/reject', [LeaveController::class, 'reject'])->name('leaves.reject');
    });

    Route::middleware('role:admin,payroll_officer')->group(function () {
        Route::get('/employees-view', [EmployeeController::class, 'viewOnly'])
            ->name('employees.view');

        Route::get('/payrolls', [PayrollController::class, 'index'])
            ->name('payrolls.index');
        Route::post('/generate-payroll', [PayrollController::class, 'generatePayroll'])
            ->name('payroll.generate');
        Route::post('/payrolls/{payroll}/finalize', [PayrollController::class, 'finalize'])
            ->name('payroll.finalize');
    });

    Route::middleware('role:admin,payroll_officer,employee')->group(function () {

    Route::get('/payrolls/{payroll}', [PayrollController::class, 'show'])
        ->name('payrolls.show');

    Route::get('/payrolls/{payroll}/pdf', [PayrollController::class, 'download'])
        ->name('payroll.pdf');

});

    Route::middleware('role:employee')->group(function () {
        Route::get('/my-profile', [EmployeeController::class, 'myProfile'])
            ->name('employees.my');
        Route::get('/my-payrolls', [PayrollController::class, 'myPayrolls'])
            ->name('payrolls.my');
        Route::get('/my-attendance', [AttendanceController::class, 'myAttendance'])
            ->name('attendances.my');

        Route::get('/apply-leave', [LeaveController::class, 'create'])->name('leaves.create');
        Route::post('/apply-leave', [LeaveController::class, 'store'])->name('leaves.store');
        Route::get('/my-leaves', [LeaveController::class, 'myLeaves'])->name('leaves.my');
    });
});

require __DIR__.'/auth.php';
