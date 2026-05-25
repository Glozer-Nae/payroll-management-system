<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Employee;
use App\Models\Department;

class DefaultUsersSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // ADMIN
        // =========================
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // =========================
        // PAYROLL OFFICER
        // =========================
        User::updateOrCreate(
            ['email' => 'officer@gmail.com'],
            [
                'name' => 'Payroll Officer',
                'password' => Hash::make('payroll123'),
                'role' => 'payroll_officer',
                'is_active' => true,
            ]
        );

        // =========================
        // EMPLOYEE USER
        // =========================
        $employeeUser = User::updateOrCreate(
            ['email' => 'employee@gmail.com'],
            [
                'name' => 'Employee User',
                'password' => Hash::make('employee123'),
                'role' => 'employee',
                'is_active' => true,
            ]
        );

        // =========================
        // DEFAULT DEPARTMENT
        // =========================
        $department = Department::firstOrCreate([
            'name' => 'Human Resources'
        ]);

        // =========================
        // EMPLOYEE RECORD
        // =========================
        Employee::updateOrCreate(
            ['user_id' => $employeeUser->id],
            [
                'department_id' => $department->id,
                'first_name' => 'Employee',
                'last_name' => 'User',
                'position' => 'Staff',
                'salary' => 20000,
                'is_active' => true,
            ]
        );
    }
}