<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        // es del checkbox para dejar la sesion abierta
        // dd($request->remember); // en la base de datos user - remember_token

        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($validated, $request->remember)) {
            $request->session()->regenerate();
 
            return redirect()->route('posts.index', Auth::user()->username);
        }

        return back()->withErrors([
            'message' => 'Credenciales Incorrectas',
        ])->onlyInput('message');
    }
}
