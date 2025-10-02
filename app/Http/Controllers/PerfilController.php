<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class PerfilController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            // Solo puede entrar los que estan autenticados
            new Middleware('auth')
        ];
    }

    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {
        
        $request->request->add(['username' => Str::slug($request->username)]);

        $request->validate([
            'username' => [
                'required', 
                'unique:users,username,'.auth()->user()->id, 
                'min:3', 
                'max:20', 
                'not_in:editar-perfil'
            ]
        ]);

        if($request->imagen) {
            if (!file_exists(public_path('perfil'))) {
                mkdir(public_path('perfil'), 0755, true);
            }

            $imagen = $request->file('imagen');

            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            $imagenServidor = new ImageManager(Driver::class);
            $image = $imagenServidor->read($imagen);
            $image->cover(1000, 1000);

            $imagenPath = public_path('perfil') . '/' . $nombreImagen;
            $image->save($imagenPath);
        }

        $usuario = User::find(auth()->user()->id);

        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save();

        
        return redirect()->route('posts.index', $usuario->username);
    }
}
