<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index() 
    {
        return view('auth.register');
    }

    public function store(Request $request) 
    {
        /* 
        @csrf del formulario es importante tenerlo para seguridad esta en register.blade.php linea 17

        dd($request); // Debugear de forma general
        dd($request->get('name')); // Debugear de forma individual 
        */

        // validacion de username
        $request->request->add(['username' => Str::slug($request->username)]);

        // Validacion
        $request->validate([
            'name' => 'required|max:60',
            'username' => 'required|unique:users|min:3|max:20',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => Str::lower($request->email),
            'password' => $request->password,
        ]);

        Auth::attempt($request->only('email','password'));

        // Redericcionar
        return redirect()->route('post.index');
    }
}
