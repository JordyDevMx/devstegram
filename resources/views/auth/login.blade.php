@extends('layouts.app')

@section('titulo')
    Inicia sesión en DevStagram
@endsection

@section('contenido')
    <div class="md:flex md:justify-center my-12 md:gap-10 md:items-center">
        <div class="md:w-6/12 p-5">
            <div class="">
                <img src="{{ asset('img/login.jpg') }}" alt="Login">
            </div>
        </div>

        <div class="md:w-4/12 bg-white shadow-xl rounded-lg p-6">
            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf

                @if (session('message'))
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ session('message') }}</p>
                @endif

                <div class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-blue-500 font-bold">
                        Correo Electrónico
                    </label>
                    <input 
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Tu correo electrónico"
                        class="border border-gray-500 p-3 w-full rounded-lg 
                        @error('name')
                            border-red-500
                        @enderror"
                        value="{{ old('email') }}"
                    >
                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="password" class="mb-2 block uppercase text-blue-500 font-bold">
                        Contraseña
                    </label>
                    <input 
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Tu contraseña"
                        class="border border-gray-500 p-3 w-full rounded-lg 
                        @error('name')
                            border-red-500
                        @enderror"
                    >
                    @error('password')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-2 mb-5">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember" class="text-blue-500 text-sm up">Mantener la sesión abierta</label>
                </div>

                <input type="submit" 
                    value="Iniciar Sesión"
                    class="bg-blue-500 hover:bg-blue-600 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg"
                >
            </form>
        </div>
    </div>
@endsection