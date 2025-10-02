@extends('layouts.app')

@section('titulo')
    Registrate en DevStagram
@endsection

@section('contenido')
    <div class="md:flex md:justify-center my-12 md:gap-10 md:items-center">
        <div class="md:w-6/12 p-5">
            <div class="">
                <img src="{{ asset('img/registrar.jpg') }}" alt="Registro">
            </div>
        </div>

        <div class="md:w-4/12 bg-white shadow-xl rounded-lg p-6">
            <form action="{{ route('register') }}" method="POST" novalidate>
                @csrf
                <div class="mb-5">
                    <label for="name" class="mb-2 block uppercase text-blue-500 font-bold">
                        Nombre
                    </label>
                    <input 
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Tu nombre"
                        class="p-3 w-full rounded-lg shadow 
                        @error('name')
                            border-red-500
                        @enderror"
                        value="{{ old('name') }}"
                    >
                    @error('name')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-blue-500 font-bold">
                        Username
                    </label>
                    <input 
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Tu usuario"
                        class="p-3 w-full rounded-lg shadow 
                        @error('name')
                            border-red-500
                        @enderror"
                        value="{{ old('username') }}"
                    >
                    @error('username')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-blue-500 font-bold">
                        Correo Electrónico
                    </label>
                    <input 
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Tu correo electrónico"
                        class="p-3 w-full rounded-lg shadow 
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
                        class="p-3 w-full rounded-lg shadow 
                        @error('name')
                            border-red-500
                        @enderror"
                    >
                    @error('password')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="password_confirmation" class="mb-2 block uppercase text-blue-500 font-bold">
                        Repetir Contraseña
                    </label>
                    <input 
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Repite tu contraseña"
                        class="p-3 w-full rounded-lg shadow"
                    >
                </div>

                <input type="submit" 
                    value="Crear Cuenta"
                    class="bg-blue-500 hover:bg-blue-600 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg"
                >
            </form>
        </div>
    </div>
@endsection