<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Laravel\Facades\Image;

class ImagenController extends Controller
{
    public function store(Request $request) 
    {
        if (!file_exists(public_path('uploads'))) {
            mkdir(public_path('uploads'), 0755, true);
        }

        $imagen = $request->file('file');

        $nombreImagen = Str::uuid() . "." . $imagen->extension();

        $imagenServidor = new ImageManager(Driver::class);
        $image = $imagenServidor->read($imagen);
        $image->cover(1000, 1000);

        $imagenPath = public_path('uploads') . '/' . $nombreImagen;
        $image->save($imagenPath);

        return response()->json(['imagen' => $nombreImagen]);
    }
}
