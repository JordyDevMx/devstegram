@extends('layouts.app')

@section('titulo')
    {{$user->username}}
@endsection

@section('contenido')
    <div class="flex justify-center">
        <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row my-auto">
            <div class="w-7/12 lg:h-6/12 px-5">
                <img class="rounded-4xl" src="{{ $user->imagen ? asset('perfil') . '/' . $user->imagen : asset('img/usuario.svg') }}" alt="{{ $user->username }}">
            </div>
            <div class="md:w-8/12 lg:h-6/12 px-5 flex flex-col items-center md:justify-center md:items-start py-10 gap-2">
                <div class="flex items-center gap-2">                    
                    <p>{{ $user->name }}</p>

                    @auth
                        @if ($user->id === auth()->user()->id)
                            <a 
                                href="{{ route('perfil.index') }}" 
                                class="text-gray-500 hover:text-gray-600 cursor-pointer"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-icon lucide-pencil"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                            </a>
                        @endif
                    @endauth
                </div>

                <p class="text-gray-800 text-md md font-bold">
                    {{ $user->followers->count() }}
                    <span class="font-normal">@choice( 'Seguidor|Seguidores', $user->followers->count() )</span>
                </p>
                <p class="text-gray-800 text-md font-bold">
                    {{ $user->followings->count() }}
                    <span class="font-normal">Siguiendo</span>
                </p>
                <p class="text-gray-800 text-md font-bold">
                    {{ $posts->count() }}
                    <span class="font-normal">Posts</span>
                </p>

                @auth
                    @if ($user->id !== auth()->user()->id)
                        @if (!$user->siguiendo( auth()->user() ))
                            <form action="{{ route('users.follow', $user) }}" method="POST">
                                @csrf

                                <input 
                                    type="submit" 
                                    class="py-1 px-3 inline-flex items-center gap-x-2 text-xs cursor-pointer font-medium rounded-lg border border-transparent bg-blue-100 text-blue-800 hover:bg-blue-200 focus:outline-hidden focus:bg-blue-200 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-400 dark:hover:bg-blue-900 dark:focus:bg-blue-900"
                                    value="Seguir"
                                >
                            </form>
                        @else
                            <form action="{{ route('users.unfollow', $user) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <input 
                                    type="submit" 
                                    class="py-1 px-3 inline-flex items-center gap-x-2 text-xs cursor-pointer font-medium rounded-lg border border-transparent bg-gray-200 text-gray-800 hover:bg-gray-300 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:text-gray-400 dark:hover:bg-gray-900 dark:focus:bg-gray-900"
                                    value="Dejar de seguir"
                                >
                            </form> 
                        @endif                       
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <section class="container mx-auto mt-10">
        <h2 class="text-4xl text-center font-black my-10">Publicaciones</h2>

        <x-listar-post :posts="$posts" >
            <p class="p-4 text-center shadow shadow-blue-300">Upss Aún no tienes publicaciónes</p>
        </x-listar-post>

    </section>
@endsection