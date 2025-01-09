<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\TribunalController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RestockController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\ShipmentDetailController;
use App\Http\Controllers\FileUploadController;



use Illuminate\Support\Facades\Route;


//rutas user
Route::get('/user', [UserController::class, 'index'])->name('user.index'); // Lista todos los usuarios
Route::get('/user/getuser', [UserController::class, 'getUsers'])->name('user.getUser');
Route::post('/user', [UserController::class, 'store'])->name('user.store'); // Crea un usuario
Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show'); // Muestra un usuario específico
Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update'); // Actualiza un usuario
Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy'); // Elimina un usuario
Route::patch('/user/{id}/activate', [UserController::class, 'activate'])->name('user.activate'); // Activa un usuario
Route::patch('/user/{id}/deactivate', [UserController::class, 'deactivate'])->name('user.deactivate'); // Desactiva un usuario
Route::post('/user/log-in', [UserController::class, 'login'])->name('user.login'); 






//rutas tribunales
Route::get('/tribunal', [TribunalController::class, 'index'])->name('tribunal.index');
Route::get('/tribunal/gettribunal', [TribunalController::class, 'getTribunal'])->name('tribunal.getTribunal');
Route::post('/tribunal', [TribunalController::class, 'store'])->name('tribunal.store');
Route::get('/tribunal/{id}', [TribunalController::class, 'show'])->name('tribunal.show');
Route::put('/tribunal/{id}', [TribunalController::class, 'update'])->name('tribunal.update');
Route::delete('/tribunal/{id}', [TribunalController::class, 'destroy'])->name('tribunal.destroy');



// Rutas para productos
Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::post('/product', [ProductController::class, 'store'])->name('product.store');
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
Route::get('/productos/{tipoEquipo}/{marca}/{modelo}/id', [ProductController::class, 'getProductIdByDetails']);
Route::get('/product/types', [ProductController::class, 'getProductTypes'])->name('product.getProductTypes');
Route::get('/productos/tipo-equipos', [ProductController::class, 'getTipoEquipos']);
Route::get('/productos/{tipoEquipo}/marcas', [ProductController::class, 'getMarcasByTipoEquipo']);
Route::get('/productos/{tipoEquipo}/{marca}/modelos', [ProductController::class, 'getModelosByTipoEquipoAndMarca']);


// Rutas para restock 
Route::get('/restock', [RestockController::class, 'getRestockFormat']);
Route::post('/restock', [RestockController::class, 'store']);
Route::get('/restock/{id}', [RestockController::class, 'show']);
Route::put('/restock/{id}', [RestockController::class, 'update']); //medio descartable
Route::delete('/restock/{id}', [RestockController::class, 'destroy']); //borrado logico
Route::get('/restock/trashed', [RestockController::class, 'trashed']); //recuperacion




// Rutas para la guia de envio
Route::get('/shipments', [ShipmentController::class, 'index'])->name('shipments.index');
Route::post('/shipments', [ShipmentController::class, 'store'])->name('shipments.store');
Route::get('/shipments/{id}', [ShipmentController::class, 'show'])->name('shipments.show');
Route::put('/shipments/{id}', [ShipmentController::class, 'update'])->name('shipments.update');
Route::delete('/shipments/{id}', [ShipmentController::class, 'destroy'])->name('shipments.destroy');
Route::get('/shipments/trashed', [ShipmentController::class, 'trashed'])->name('shipments.trashed'); // Para recuperar los envíos eliminados

// Rutas para los productos asociados a la guia de envio
Route::get('/shipment-details', [ShipmentDetailController::class, 'index'])->name('shipmentDetails.index');
Route::post('/shipment-details', [ShipmentDetailController::class, 'store'])->name('shipmentDetails.store');
Route::get('/shipment-details/{id}', [ShipmentDetailController::class, 'show'])->name('shipmentDetails.show');
Route::put('/shipment-details/{id}', [ShipmentDetailController::class, 'update'])->name('shipmentDetails.update');
Route::delete('/shipment-details/{id}', [ShipmentDetailController::class, 'destroy'])->name('shipmentDetails.destroy');




//Route::get('/upload', [FileUploadController::class, 'index']); 
//Route::post('/upload', [FileController::class, 'store']);