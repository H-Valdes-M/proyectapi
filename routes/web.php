<?php
use Illuminate\Support\Facades\Route;
// Define solo las rutas necesarias para tu API o lógica de negocio
Route::get('/', function () {
    return view('welcome');
});
