<?php
namespace App\Http\Controllers;

use App\Models\ShipmentDetail;
use Illuminate\Http\Request;

use App\Models\Product;

class ShipmentDetailController extends Controller
{
    public function index()
    {
        return ShipmentDetail::with(['shipment', 'product'])->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_envio' => 'required|exists:shipments,id',
            'producto' => 'required|exists:products,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        // Buscar el producto en la base de datos
        $product = Product::findOrFail($request->producto);

          // Verificar si hay suficiente cantidad de producto
        if ($product->unidades_disponible < $request->cantidad) {
            return response()->json([
                'message' => 'No hay suficiente cantidad de producto en stock.'
            ], 400);  // Respuesta con código 400 si no hay suficiente stock
        }

        // Restar la cantidad de unidades disponibles
        $product->unidades_disponible -= $request->cantidad;
        $product->save();

        // Crear el detalle de envío
        $shipmentDetail = ShipmentDetail::create([
            'id_envio' => $request->id_envio,
            'producto' => $request->producto,
            'cantidad' => $request->cantidad
        ]);


        return response()->json([
            'message' => 'Detalle de envío registrado exitosamente.',
            'shipment_detail' => $shipmentDetail
        ], 201); 
    }

    public function show($id)
    {
        $shipmentDetail = ShipmentDetail::with(['shipment', 'product'])->findOrFail($id);
        return response()->json($shipmentDetail);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'id_envio' => 'sometimes|exists:shipments,id',
            'producto' => 'sometimes|exists:products,id',
            'cantidad' => 'sometimes|integer|min:1',
        ]);

        $shipmentDetail = ShipmentDetail::findOrFail($id);
        $shipmentDetail->update($data);

        return response()->json($shipmentDetail);
    }

    public function destroy($id)
    {
        $shipmentDetail = ShipmentDetail::findOrFail($id);
        $shipmentDetail->delete();

        return response()->json(['message' => 'Shipment detail deleted successfully']);
    }


    public function getProductsByShipment($idEnvio)
    {
        // Obtener todos los detalles de los productos asociados al envío
        $shipmentDetails = ShipmentDetail::with('product') // Usamos el nombre de la relación definida en el modelo ShipmentDetail
            ->where('id_envio', $idEnvio)
            ->get();

        // Devolver los productos asociados
        return response()->json($shipmentDetails);
    }





}
