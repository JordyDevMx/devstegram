<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function store(User $user)
    {
        $user->followers()->attach( auth()->user()->id );
        // Se recomienda utilizar attach en vez de create por la razon de que estas utilizando una tabla relaciondo con los mismos usuarios de id 

        return back();
    }

    public function destroy(User $user)
    {
        $user->followers()->detach( auth()->user()->id );

        return back();
    }
}
