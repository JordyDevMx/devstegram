@extends('layouts.app')

@section('titulo')
    Página principal
@endsection

@section('contenido')
    
    <x-listar-post :posts="$posts" >
        <p class="p-4 text-center shadow shadow-blue-300">Explora y sigue cuentas para llenar tu inicio con lo mejor de sus publicaciones.</p>
    </x-listar-post>
@endsection