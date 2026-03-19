<?php

namespace App\Http\Controllers\API;

use App\Models\Rol;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RolController extends Controller
{
    public function index()
    {
        return response()->json(Rol::all(), 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:50|unique:roles,nombre',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $rol = Rol::create($request->all());
            return response()->json($rol, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $rol = Rol::find($id);
        if (!$rol) return response()->json(['message' => 'No encontrado'], 404);
        return response()->json($rol, 200);
    }

    public function update(Request $request, $id)
    {
        $rol = Rol::find($id);
        if (!$rol) return response()->json(['message' => 'No encontrado'], 404);

        $rol->update($request->all());
        return response()->json($rol, 200);
    }

    public function destroy($id)
    {
        Rol::destroy($id);
        return response()->json(['message' => 'Rol eliminado'], 200);
    }
}