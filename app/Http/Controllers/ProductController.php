<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    // Lista todos los productos
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

       /* $products = Product::whereNull('estado_producto')->get();
        return response()->json(['success' => true, 'products' => $products]);*/
    // Crea un nuevo producto
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'tipo_Equipo' => 'required|string|max:100',
                'subequipo' => 'nullable|string|max:100',
                'marca' => 'required|string|max:100',
                'modelo' => 'required|string|max:100',
                'unidades_disponible' => 'required|integer|min:0',
                'stock_critico' => 'required|integer|min:0',
            ]);

            // Establecer estado_producto como null (activo) por defecto
            $validatedData['estado_producto'] = null;

            $product = Product::create($validatedData);

            return response()->json(['success' => true, 'product' => $product], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error creating product: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error interno del servidor'], 500);
        }
    }
    
    // Muestra un producto específico
    public function show($id)
    {
        $product = Product::whereNull('estado_producto')->findOrFail($id);
        return response()->json(['success' => true, 'product' => $product]);
    }

    // Actualiza un producto
    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $validatedData = $request->validate([
                'tipo_Equipo' => 'sometimes|required|string|max:100',
                'subequipo' => 'sometimes|nullable|string|max:100',
                'marca' => 'sometimes|required|string|max:100',
                'modelo' => 'sometimes|required|string|max:100',
                'unidades_disponible' => 'sometimes|required|integer|min:0',
                'stock_critico' => 'sometimes|required|integer|min:0',
            ]);

            $product->update($validatedData);

            return response()->json(['success' => true, 'product' => $product]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error updating product: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error interno del servidor'], 500);
        }
    }


    // Elimina un producto
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->estado_producto = 'Inactivo';
            $product->save();

            return response()->json(['success' => true, 'message' => 'Producto marcado como inactivo']);
        } catch (\Exception $e) {
            Log::error('Error marking product as inactive: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error interno del servidor'], 500);
        }
    }

    public function restore($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->estado_producto = null;
            $product->save();

            return response()->json(['success' => true, 'message' => 'Producto restaurado']);
        } catch (\Exception $e) {
            Log::error('Error restoring product: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error interno del servidor'], 500);
        }
    }


    public function getTipoEquipos()
    {
        $tipoEquipos = Product::select('tipo_Equipo')->distinct()->orderBy('tipo_Equipo')->get();
        return response()->json($tipoEquipos);
    }
    

    public function getMarcasByTipoEquipo($tipoEquipo)
    {
        $marcas = Product::where('tipo_Equipo', $tipoEquipo)
                         ->select('marca')
                         ->distinct()
                         ->orderBy('marca')
                         ->get();
        return response()->json($marcas);
    }

    public function getModelosByTipoEquipoAndMarca($tipoEquipo, $marca)
    {
        $modelos = Product::where('tipo_Equipo', $tipoEquipo)
                          ->where('marca', $marca)
                          ->select('modelo')
                          ->distinct()
                          ->orderBy('modelo')
                          ->get();
        return response()->json($modelos);
    }


    public function getProductIdByDetails($tipoEquipo, $marca, $modelo)
{
    $product = Product::where('tipo_Equipo', $tipoEquipo)
                      ->where('marca', $marca)
                      ->where('modelo', $modelo)
                      ->first(['id']); // Solo obtenemos la ID

    if ($product) {
        return response()->json(['id' => $product->id]);
    } else {
        return response()->json(['error' => 'Producto no encontrado'], 404);
    }
}






}