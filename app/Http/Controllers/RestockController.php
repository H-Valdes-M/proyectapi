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
    // Validar los datos de entrada
    $request->validate([
        'producto' => 'required|exists:products,id', //FK
        'usuario' => 'required|exists:users,id', //FK
        'fecha' => 'required|date',
        'cant_unidades' => 'required|integer',
        'coment' => 'nullable|string',
        'doc' => 'nullable|exists:documents,id', //FK
        'accion' => 'required|integer',
    ]);


    try {
        // Buscar el producto en la base de datos
        $product = Product::findOrFail($request->producto);

        // Comprobar que no se restan más unidades de las disponibles
        if ($request->accion == 0 && $product->unidades_disponible < $request->cant_unidades) {
            return response()->json([
                'success' => false,
                'message' => 'No hay suficientes unidades disponibles para restar.',
                'error' => 'Cantidad insuficiente',
            ], 400);
        }

        // Actualizar las unidades disponibles del producto
        if ($request->accion == 0) {
            $product->unidades_disponible -= $request->cant_unidades; // Restar unidades
        } else {
            $product->unidades_disponible += $request->cant_unidades; // Sumar unidades
        }

        $product->save();

        // Crear el registro de reabastecimiento
        $restock = Restock::create([
            'producto' => $request->producto,
            'usuario' => $request->usuario,
            'fecha' => $request->fecha,
            'cant_unidades' => $request->cant_unidades,
            'coment' => $request->coment,
            'doc' => $request->doc, // Almacenar el ID del documento
            'accion' => $request->accion,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reabastecimiento registrado exitosamente y unidades del producto actualizadas.',
            'restock' => $restock,
            'producto_actualizado' => $product,
        ], 201);
    } catch (\Exception $e) {
        // Manejo de errores generales
        return response()->json([
            'success' => false,
            'message' => 'Ocurrió un error al registrar el reabastecimiento.',
            'error' => $e->getMessage(),
        ], 500);
    }
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



    public function getRestockFormat()
{
    $restocks = Restock::with('producto', 'usuario', 'document')->get();
   return response()->json($restocks->toArray());
}


}
