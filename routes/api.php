<?php

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::get('/v1/patients/{id}', [PatientController::class, 'show']);
Route::get('/v1/search-patients', [PatientController::class, 'search']);
Route::post('/v1/patients/add-medical-history/{id}', [PatientController::class, 'addMedicalHistory']);
Route::post('/v1/add-patients', [PatientController::class, 'store']);
