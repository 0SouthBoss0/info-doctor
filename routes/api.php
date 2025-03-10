<?php


use App\Http\Controllers\PatientController;
Route::get('/patients/{id}', [PatientController::class, 'show']);
