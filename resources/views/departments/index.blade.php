@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="fw-bold mb-0">Departments</h2>
        <p class="text-muted mb-0">Manage organizational departments and divisions.</p>
    </div>
    <a href="{{ route('departments.create') }}" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
        <i class="bi bi-plus-circle me-1"></i> Add Department
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary">
                    <tr>
                        <th class="py-3 px-3 border-0">Department Name</th>
                        <th class="py-3 px-3 border-0 text-end" style="width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($departments as $dept)
                    <tr>
                        <td class="px-3 py-3 fw-bold text-dark">
                            <i class="bi bi-building text-primary opacity-50 me-2 fs-5 align-middle"></i>
                            {{ $dept->name }}
                        </td>
                        <td class="px-3 py-3 text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('departments.edit', $dept->id) }}" class="btn btn-outline-primary" title="Edit Department">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('departments.destroy', $dept->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger" title="Delete Department" onclick="return confirm('Are you sure you want to delete this department?');">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="text-center py-5 text-muted">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bi bi-building-dash fs-1 text-secondary mb-2"></i>
                                <span>No departments found. Click "Add Department" to create one.</span>
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