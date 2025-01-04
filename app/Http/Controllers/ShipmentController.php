<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    // Mostrar todos los envíos
    public function index()
    {
        $shipments = Shipment::with(['user', 'tribunal'])->get();

       // $shipments = Shipment::all(); // Solo devuelve las que no están "eliminadas"
        return response()->json($shipments);
    }

    // Crear un nuevo envío
    public function store(Request $request)
    {
        $request->validate([
            'usuario' => 'required|exists:users,id',
            'tribunal' => 'required|exists:tribunal,id',
            'fecha' => 'required|date',
            'destinatario' => 'required|string|max:100',
            'observacion' => 'nullable|string|max:255',
            'guiadeMov' => 'required|string|max:255',
            'nguiaMov' => 'required|string|max:50',
        ]);

        $shipment = Shipment::create($request->all());

        return response()->json($shipment, 201);
    }

    // Mostrar un envío específico
    public function show($id)
    {
        $shipment = Shipment::findOrFail($id);
        return response()->json($shipment);
    }

    // Actualizar un envío existente
    public function update(Request $request, $id)
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->update($request->all());

        return response()->json($shipment);
    }

    // Borrar un envío (borrado lógico)
    public function destroy($id)
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->delete(); // Esto realiza un borrado lógico

        return response()->json(null, 204); // Responde sin contenido
    }

    // Recuperar los envíos eliminados
    public function trashed()
    {
        $shipmentsEliminados = Shipment::onlyTrashed()->get(); // Devuelve los envíos eliminados
        return response()->json($shipmentsEliminados);
    }
}
