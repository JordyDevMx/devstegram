@extends('layouts.app')

@section('titulo')
    Editar Perfil: {{ auth()->user()->username }}
@endsection

@section('contenido')
    <div class="md:flex md:justify-center">
        <div class="bg-white shadow p-6 rounded-lg">
            <form action="{{route('perfil.store')}}" method="POST" enctype="multipart/form-data" class="mt-10 md:mt-0">
                @csrf
                <div class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-blue-500 font-bold">
                        Username
                    </label>
                    <input 
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Tu Nombre de usuario"
                        class="p-3 w-full rounded-lg shadow 
                        @error('username')
                            border-red-500
                        @enderror"
                        value="{{ auth()->user()->username }}"
                    >
                    @error('username')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label class="block">
                        <span class="sr-only">Foto de perfil</span>
                        <input type="file" 
                            id="imagen"
                            name="imagen"
                            accept=".jpg, .jpeg, .png"
                            class="block w-full text-sm cursor-pointer
                            text-gray-500 rounded-lg shadow p-3
                            file:me-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-500 file:text-white
                            hover:file:bg-blue-600
                            file:disabled:opacity-50 file:disabled:pointer-events-none
                            dark:text-neutral-500
                            dark:file:bg-blue-500
                            dark:hover:file:bg-blue-400
                        ">
                    </label>
                </div>
                
                <input type="submit" 
                    value="Guardar Cambios"
                    class="bg-blue-500 hover:bg-blue-600 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg"
                >
            </form>
        </div>
    </div>
@endsection