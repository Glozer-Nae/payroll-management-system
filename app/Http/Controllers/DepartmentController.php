<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        $departments = Department::latest()->get();
        return view('departments.index', compact('departments'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Department::create($request->all());

        return redirect()->route('departments.index')->with('success', 'Department created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }


    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $department->update($request->all());

        return redirect()->route('departments.index')->with('success', 'Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Department $department)
{
    if ($department->employees()->count() > 0) {
        return redirect()->route('departments.index')
            ->with('error', 'Cannot delete department with assigned employees.');
    }

    $department->delete();

    return redirect()->route('departments.index')->with('success', 'Deleted');
}
}
