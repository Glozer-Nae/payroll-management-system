<?php

namespace App\Http\Controllers;

use App\Models\DeductionType;
use Illuminate\Http\Request;

class DeductionTypeController extends Controller
{
    // =========================
    // LIST
    // =========================
    public function index()
    {
        $deductions = DeductionType::latest()->get();

        return view('deductions.index', compact('deductions'));
    }

    // =========================
    // CREATE FORM
    // =========================
    public function create()
    {
        return view('deductions.create');
    }

    // =========================
    // STORE
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
        ]);

        DeductionType::create([
            'name' => $request->name,
            'type' => $request->type,
            'value' => $request->value,
            'is_active' => true,
        ]);

        return redirect()
            ->route('deductions.index')
            ->with('success', 'Deduction created successfully');
    }

    // =========================
    // EDIT FORM
    // =========================
    public function edit(DeductionType $deduction)
    {
        return view('deductions.edit', compact('deduction'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, DeductionType $deduction)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);

        $deduction->update([
            'name' => $request->name,
            'type' => $request->type,
            'value' => $request->value,
            'is_active' => $request->is_active,
        ]);

        return redirect()
            ->route('deductions.index')
            ->with('success', 'Deduction updated successfully');
    }

    // =========================
    // DELETE
    // =========================
    public function destroy(DeductionType $deduction)
    {
        $deduction->delete();

        return back()->with('success', 'Deduction deleted successfully');
    }
}