<?php

namespace App\Http\Controllers;

use App\Models\Tribunal;
use Illuminate\Http\Request;

class TribunalController extends Controller
{
    // Método para listar todos los tribunales
    public function index()
    {
        return response()->json(Tribunal::all(), 200);
    }


    public function getTribunal()
    {
        $tribunal = Tribunal::select('id', 'nombre_Tribunal')->orderBy('nombre_Tribunal')->get();
        return response()->json($tribunal, 200);
    }
    


    // Método para crear un tribunal
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_Tribunal' => 'required|string|max:100',
            'jurisdiccion' => 'required|string|max:100',
        ]);

        $tribunal = Tribunal::create($validated);

        return response()->json($tribunal, 201);
    }

    // Método para mostrar un tribunal específico
    public function show($id)
    {
        $tribunal = Tribunal::find($id);

        if (!$tribunal) {
            return response()->json(['error' => 'Tribunal no encontrado'], 404);
        }

        return response()->json($tribunal, 200);
    }

    // Método para actualizar un tribunal
    public function update(Request $request, $id)
    {
        $tribunal = Tribunal::find($id);

        if (!$tribunal) {
            return response()->json(['error' => 'Tribunal no encontrado'], 404);
        }

        $validated = $request->validate([
            'nombre_Tribunal' => 'string|max:100',
            'jurisdiccion' => 'string|max:100',
        ]);

        $tribunal->update($validated);

        return response()->json($tribunal, 200);
    }

    // Método para eliminar un tribunal
    public function destroy($id)
    {
        $tribunal = Tribunal::find($id);

        if (!$tribunal) {
            return response()->json(['error' => 'Tribunal no encontrado'], 404);
        }

        $tribunal->delete();

        return response()->json(['message' => 'Tribunal eliminado'], 200);
    }











}
