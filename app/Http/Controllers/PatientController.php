<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Cloudinary\Cloudinary;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();
        return response()->json($patients);
    }

    public function show($id)
    {
        $patient = Patient::findOrFail($id);
        return response()->json($patient);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'imagen' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $file = $request->file('imagen');

        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => config('services.cloudinary.cloud_name'),
                'api_key' => config('services.cloudinary.api_key'),
                'api_secret' => config('services.cloudinary.api_secret'),
            ],
            'url' => ['secure' => true],
        ]);

        $resultado = $cloudinary->uploadApi()->upload(
            $file->getRealPath(),
            [
                'folder' => 'students',
                'resource_type' => 'image',
            ]
        );

        $patient = Patient::create([
            'nombre' => $validated['nombre'],
            'apellidos' => $validated['apellidos'],
            'imagen_url' => $resultado['secure_url'],
            'imagen_public_id' => $resultado['public_id'],
        ]);

        return response()->json([
            'message' => 'Paciente creado correctamente',
            'data' => $patient,
        ], 201);
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $oldImagePublicId = $patient->imagen_public_id;
        $image = $request->file('imagen');
        unset($validated['imagen']);

        if ($image) {
            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => config('services.cloudinary.cloud_name'),
                    'api_key' => config('services.cloudinary.api_key'),
                    'api_secret' => config('services.cloudinary.api_secret'),
                ],
                'url' => ['secure' => true],
            ]);

            $result = $cloudinary->uploadApi()->upload(
                $image->getRealPath(),
                [
                    'folder' => 'students',
                    'resource_type' => 'image',
                ]
            );

            $validated['imagen_url'] = $result['secure_url'];
            $validated['imagen_public_id'] = $result['public_id'];
        }

        $patient->update($validated);

        if ($image && $oldImagePublicId) {
            $cloudinary->uploadApi()->destroy($oldImagePublicId);
        }

        return response()->json($patient);
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return response()->json($patient);
    }
}
