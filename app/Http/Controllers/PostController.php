<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use DragonCode\Support\Facades\Filesystem\File;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use SweetAlert2\Laravel\Swal;

class PostController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            // Lo que puede ver el usuario sin autenticarse
            new Middleware('auth', except: ['show', 'index']),
        ];
    }

    public function index(User $user) 
    {
        // $posts = Post::where('user_id', $user->id)->get(); // get es como mandar a mostrar

        // Opcion para paginar la informacion
        $posts = Post::where('user_id', $user->id)->latest()->paginate(20);  // Paginar
        
        return view('dashboard', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }

    public function create() 
    {
        return view('posts.create');
    }

    public function store(Request $request) 
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required',
        ]);

        // Crear 
        // $post = new Post();
        // $post->titulo = $request->titulo;
        // $post->descripcion = $request->descripcion;
        // $post->imagen = $request->imagen;
        // $post->user_id = auth()->user()->id;

        // $post->save();

        // Otra forma para crear

        // Post::create([
        //     'titulo' => $request->titulo,
        //     'descripcion' => $request->descripcion,
        //     'imagen' => $request->imagen,
        //     'user_id' => auth()->user()->id,
        // ]);

        // Crear ya cuando tengamos las relaciones de cada *** Eso evitas tener un where
        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id,
        ]);

        Swal::success([
            'title' => 'Publicado',
            'text' => 'El post fue creado exitosamente'
        ]);

        return redirect()->route('posts.index', auth()->user()->username);
    }

    public function show(User $user, Post $post)  // User para mostrar el username
    {
        return view('posts.show', [
            'post' => $post,
            'user' => $user,
        ]);
    }

    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);
        $post->delete();

        // Eliminar la imagen
        $imagen_path = public_path('uploads/' . $post->imagen);

        if(File::exists($imagen_path)) {
            unlink($imagen_path);
        }

        Swal::fire([
            'title' => 'Eliminado',
            'text'  => 'El post fue eliminado correctamente',
            'icon'  => 'success',
            'confirmButtonText' => 'Aceptar'
        ]);

        return redirect()->route('posts.index', auth()->user()->username);
    }
}
