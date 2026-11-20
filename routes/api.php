<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\IncomeController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('doctors', [DoctorController::class, 'index'])->name('api.v1.doctor.index');
Route::post('doctors', [DoctorController::class, 'store'])->name('api.v1.doctor.store');
Route::get('doctors/{doctor}', [DoctorController::class, 'show'])->name('api.v1.doctor.show');
Route::put('doctors/{doctor}', [DoctorController::class, 'update'])->name('api.v1.doctor.update');
Route::delete('doctors/{doctor}', [DoctorController::class, 'destroy'])->name('api.v1.doctor.destroy');

Route::get('patients', [PatientController::class, 'index'])->name('api.v1.patient.index');
Route::post('patients', [PatientController::class, 'store'])->name('api.v1.patient.store');
Route::get('patients/{patient}', [PatientController::class, 'show'])->name('api.v1.patient.show');
Route::put('patients/{patient}', [PatientController::class, 'update'])->name('api.v1.patient.update');
Route::delete('patients/{patient}', [PatientController::class, 'destroy'])->name('api.v1.patient.destroy');

Route::get('incomes', [IncomeController::class, 'index'])->name('api.v1.income.index');
Route::post('incomes', [IncomeController::class, 'store'])->name('api.v1.income.store');
Route::get('incomes/{income}', [IncomeController::class, 'show'])->name('api.v1.income.show');
Route::put('incomes/{income}', [IncomeController::class, 'update'])->name('api.v1.income.update');
Route::delete('incomes/{income}', [IncomeController::class, 'destroy'])->name('api.v1.income.destroy');