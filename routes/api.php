<?php


use App\Http\Controllers\PatientController;
Route::get('/patients/{id}', [PatientController::class, 'show']);
Route::get('/search', [PatientController::class, 'search']);
