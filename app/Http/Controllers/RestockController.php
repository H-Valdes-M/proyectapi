<?php

namespace App\Http\Controllers;

use App\Models\Restock;
use App\Models\Product;  
use App\Models\User;

use App\Http\Resources\ShipmentResource;

use Illuminate\Http\Request;

class RestockController extends Controller
{







    // Mostrar todas las reposiciones
    public function index()
    {
        $restocks = Restock::all(); // Solo devuelve las que no están "eliminadas"
        return response()->json($restocks);
    }

    // Crear una nueva reposición
    public function store(Request $request)
    {
        $request->validate([
            'producto' => 'required|exists:products,id',
            'usuario' => 'required|exists:users,id',
            'fecha' => 'required|date',
            'cant_unidades' => 'required|integer',
        ]);

        // Buscar el producto en la base de datos
        $product = Product::findOrFail($request->producto);

        // Actualizar las unidades disponibles del producto
        $product->unidades_disponible += $request->cant_unidades;
        $product->save();



        $restock = Restock::create($request->all());

        return response()->json([
            'message' => 'Reabastecimiento registrado exitosamente y unidades del producto actualizadas.',
            'restock' => $restock,
            'producto_actualizado' => $product,
        ], 201);
    }

    // Mostrar una reposición específica
    public function show($id)
    {
        $restock = Restock::findOrFail($id);
        return response()->json($restock);
    }

    // Actualizar una reposición existente
    public function update(Request $request, $id)
    {
        $restock = Restock::findOrFail($id);
        $restock->update($request->all());

        return response()->json($restock);
    }

    // Borrar una reposición (borrado lógico)
    public function destroy($id)
    {
        $restock = Restock::findOrFail($id);
        $restock->delete(); // Esto realiza un borrado lógico

        return response()->json(null, 204); // Responde sin contenido
    }

    // Recuperar las reposiciones eliminadas
    public function trashed()
    {
        $restocksEliminados = Restock::onlyTrashed()->get(); // Devuelve las reposiciones eliminadas
        return response()->json($restocksEliminados);
    }







}
