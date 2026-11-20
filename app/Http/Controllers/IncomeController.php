<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::with(['doctor', 'patient'])->get();
        return response()->json($incomes);
    }

    public function show(Income $income)
    {
        return response()->json($income->load(['doctor', 'patient']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'habitacion' => 'required|string|max:255',
            'fecha' => 'required|date',
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
        ]);

        $income = Income::create($validated);
        return response()->json($income, 201);
    }

    public function update(Request $request, Income $income)
    {
        $validated = $request->validate([
            'habitacion' => 'required|string|max:255',
            'fecha' => 'required|date',
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
        ]);

        $income->update($validated);
        return response()->json($income);
    }

    public function destroy(Income $income)
    {
        $income->delete();
        return response()->json($income);
    }
}
