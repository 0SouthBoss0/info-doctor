<?php


use App\Http\Controllers\PatientController;
Route::get('/patients/{id}', [PatientController::class, 'show']);
Route::get('/search', [PatientController::class, 'search']);
Route::post('/patients/add-medical-history/{id}', [PatientController::class, 'addMedicalHistory']);
Route::post('/add-patient', [PatientController::class, 'store']);
