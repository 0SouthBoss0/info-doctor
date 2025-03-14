<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function show($id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        return response()->json($patient);
    }

    public function search(Request $request)
    {
        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $middleName = $request->input('middle_name');
        $age = $request->input('age');

        $query = Patient::query();

        if ($firstName) {
            $query->where('first_name', $firstName);
        }
        if ($lastName) {
            $query->where('last_name', $lastName);
        }
        if ($middleName) {
            $query->where('middle_name', $middleName);
        }
        if ($age) {
            $query->where('age', $age);
        }

        $patients = $query->get();
        return response()->json($patients);

    }

    public function addMedicalHistory(Request $request, $id)
    {

        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $newMedicalHistory = $request->input('medical_history');

        if (empty($newMedicalHistory)) {
            return response()->json(['message' => 'Medical history data is required'], 400);
        }

        $currentMedicalHistory = $patient->medical_history ?? '';
        $updatedMedicalHistory = $currentMedicalHistory . "\n" . $newMedicalHistory;

        $patient->medical_history = $updatedMedicalHistory;
        $patient->updated_at = now();
        $patient->save();

        return response()->json([
            'message' => 'Medical history updated successfully',
            'patient' => $patient
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'age' => 'required|integer|min:0',
            'medical_history' => 'nullable|string',
        ]);

        $patient = Patient::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'middle_name' => $request->input('middle_name'),
            'age' => $request->input('age'),
            'medical_history' => $request->input('medical_history'),
        ]);

        return response()->json([
            'message' => 'Patient created successfully',
            'patient' => $patient
        ], 201);
    }

}
