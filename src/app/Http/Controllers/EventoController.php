<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventoController extends Controller
{
    public function index()
    {
        return response()->json(Evento::all(), 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'ubicacion' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos',
                'errors' => $validator->errors(),
            ], 422);
        }

        $evento = Evento::create($validator->validated());
        return response()->json($evento, 201);
    }

    public function show(string $id)
    {
        $evento = Evento::find($id);
        if (!$evento) {
            return response()->json(['message' => 'Evento no encontrado'], 404);
        }
        return response()->json($evento, 200);
    }

    public function update(Request $request, string $id)
    {
        $evento = Evento::find($id);
        if (!$evento) {
            return response()->json(['message' => 'Evento no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'ubicacion' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos',
                'errors' => $validator->errors(),
            ], 422);
        }

        $evento->update($validator->validated());
        return response()->json($evento, 200);
    }

    public function destroy(string $id)
    {
        $evento = Evento::find($id);
        if (!$evento) {
            return response()->json(['message' => 'Evento no encontrado'], 404);
        }

        $evento->delete();
        return response()->json(['message' => 'Evento eliminado'], 200);
    }
}
