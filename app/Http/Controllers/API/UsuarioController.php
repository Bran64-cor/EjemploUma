<?php

namespace App\Http\Controllers\API;

use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    public function index()
    {
        return response()->json(Usuario::with('roles')->get(), 200);
    }

    public function store(Request $request)
    {
        // 1. Validar los datos antes de intentar insertar
        $validator = Validator::make($request->all(), [
            'nombre'   => 'required|string|max:255',
            'apaterno' => 'required|string|max:255',
            'email'    => 'required|email|unique:usuarios,email',
            'activo'   => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            // 2. Crear el usuario
            $usuario = Usuario::create($request->all());

            return response()->json([
                'message' => 'Usuario creado con éxito',
                'data' => $usuario
            ], 201);

        } catch (\Exception $e) {
            // 3. Capturar errores de base de datos o sistema
            return response()->json([
                'message' => 'Error al crear usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $usuario = Usuario::with('roles')->find($id);
        
        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json($usuario, 200);
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $usuario->update($request->all());

        return response()->json([
            'message' => 'Usuario actualizado',
            'data' => $usuario
        ], 200);
    }

    public function destroy($id)
    {
        $deleted = Usuario::destroy($id);

        if (!$deleted) {
            return response()->json(['message' => 'No se pudo eliminar o no existe'], 404);
        }

        return response()->json(['message' => 'Usuario eliminado'], 200);
    }
}