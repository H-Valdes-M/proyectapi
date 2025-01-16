<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function store(Request $request)
{
    // Validar el archivo
    $request->validate([
        'file' => 'required|mimes:pdf,jpeg,png,jpg,docx|max:2048',
    ]);

    // Verificar si el archivo ha sido enviado
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        
        // Generar un nombre único para el archivo
        $fileName = time() . '_' . $file->getClientOriginalName();

        // Subir el archivo al disco público y obtener la ruta
        $path = $file->storeAs('uploads', $fileName, 'public');

        // Obtener el tamaño del archivo
        $fileSize = $file->getSize();

        // Guardar la ruta y el tamaño del archivo en la base de datos
        $document = Document::create([
            'url' => $path,
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $fileSize,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Documento cargado exitosamente',
            'document' => $document
        ]);
    }

    return response()->json(['message' => 'No se ha cargado el archivo'], 400);
}


    public function index()
    {
        // Obtener todos los documentos de la base de datos
        $documents = Document::all();

        return response()->json($documents);
    }


    public function getDocLastId()
    {
        // Obtener el último registro
        $documents = Document::latest('id')->first();

        if ($documents) {
            return response()->json(['id' => $documents->id], 200);
        } else {
            return response()->json(['message' => 'No hay movimientos registrados.'], 404);
        }
    }
 





}