<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class HomeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            // Solo puede entrar los que estan autenticados
            new Middleware('auth')
        ];
    }

    public function __invoke()
    {
        // Obtener a quienes seguimos
        $ids = auth()->user()->followings->pluck('id')->toArray();  // pluck -> que campos solo quieres traer
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20);  // latest muestr el registro mas reciente

        return view('home', [
            'posts' => $posts,
        ]);
    }
}
