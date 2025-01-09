<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
class FileUploadController extends Controller
{
    public function loadView(){
        $file = [];

        return view('files',['file'=>$file]);
    }

    public function storeFile(Request $request){
        //Storage::disk('public')->put("text.txt", "hola");
        if($request->isMethod('POST')){
            $file = $request->file('file');
            $name = $request->file('name');
            $file->storeAs('',$name.".".$file->getClientOriginalExtension(), 'public');
        }
        return $this->loadView();
    }

    public function downloadFile($name){

}
}