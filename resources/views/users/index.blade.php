@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="fw-bold mb-0">User Management</h2>
        <p class="text-muted mb-0">Manage system access, accounts, and roles.</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
        <i class="bi bi-person-plus-fill me-1"></i> Add User
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary">
                    <tr>
                        <th class="py-3 px-3 border-0">Name</th>
                        <th class="py-3 border-0">Email</th>
                        <th class="py-3 border-0">Role</th>
                        <th class="py-3 border-0">Status</th>
                        <th class="py-3 px-3 border-0 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($users as $user)
                    <tr>
                        <td class="px-3 py-3 fw-bold text-dark">
                            <i class="bi bi-person-circle text-secondary me-2 fs-5 align-middle"></i>
                            {{ $user->name }}
                        </td>
                        <td class="py-3 text-muted">{{ $user->email }}</td>
                        <td class="py-3">
                            @if($user->role == 'admin')
                                <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1">Admin</span>
                            @elseif($user->role == 'payroll_officer')
                                <span class="badge bg-info bg-opacity-10 text-info px-2 py-1">Payroll Officer</span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-1">Employee</span>
                            @endif
                        </td>
                        <td class="py-3">
                            @if($user->is_active)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1">Active</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-1">Inactive</span>
                            @endif
                        </td>
                        <td class="px-3 py-3 text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-primary" title="Edit User">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                
                                <form method="POST" action="{{ route('users.reset-password', $user) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-warning" title="Reset Password to password123" onclick="return confirm('Reset password to password123?');">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete User" onclick="return confirm('Are you sure you want to delete this user?');">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bi bi-people fs-1 text-secondary mb-2"></i>
                                <span>No users found.</span>
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