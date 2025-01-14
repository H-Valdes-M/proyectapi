<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    // Mostrar todos los envíos
    public function index()
    {
        $shipments = Shipment::with(['usuario', 'tribunal'])->get();
        return response()->json($shipments->toArray());
    }

    // Crear un nuevo envío
    public function store(Request $request)
    {
        try {
            // Validar los datos de entrada
            $request->validate([
                'usuario' => 'required|exists:users,id',
                'tribunal' => 'required|exists:tribunal,id',
                'fecha' => 'required|date',
                'destinatario' => 'required|string|max:100',
                'observacion' => 'nullable|string|max:255',
            ]);
    
            // Crear el registro de Shipment
            $shipment = Shipment::create($request->all());
    
            // Respuesta exitosa
            return response()->json([
                'success' => true,
                'message' => 'Envío creado exitosamente.',
                'shipment' => $shipment
            ], 201);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Errores de validación
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación.',
                'errors' => $e->errors()
            ], 422);
    
        } catch (\Exception $e) {
            // Errores inesperados (como problemas de base de datos)
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al crear el envío.',
                'error' => $e->getMessage()
            ], 500);
        }
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


    public function getLastShipmentId()
    {
        // Obtener el último registro
        $lastShipment = Shipment::latest('id')->first();

        if ($lastShipment) {
            return response()->json(['id' => $lastShipment->id], 200);
        } else {
            return response()->json(['message' => 'No hay movimientos registrados.'], 404);
        }
    }
 
    
};















