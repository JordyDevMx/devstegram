<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @stack('styles')
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <title>DevStagram - @yield('titulo')</title>

        @livewireStyles
    </head>
    <body class="bg-gray-100 min-h-screen flex flex-col">
        @include('sweetalert2::index')
        
        <header class="p-5 bg-white shadow">
            <div class="max-w-11/12 mx-auto flex flex-col md:flex-row justify-center gap-6 md:justify-between items-center">
                <a href="{{route('home')}}" class="text-3xl font-black">
                    DevStagram
                    @if (auth()->user())
                        <span class="text-blue-500">{{'/' . auth()->user()->username }}</span>
                    @endif
                </a>

                @auth
                    <nav class="flex gap-4 items-center">
                        <a href="{{ route('posts.create' )}}" class="flex items-center gap-2 bg-white border p-2 text-gray-600 rounded text-sm uppercase font-bold cursor-pointer transition delay-150 duration-300 ease-in-out hover:-translate-y-1 hover:scale-110 hover:bg-blue-500 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                            </svg>

                            Crear
                        </a>

                        <a class="font-bold text-2xl text-gray-600" href="{{ route('posts.index', auth()->user()->username ) }}">
                            Hola: 
                            <span class="font-normal">
                                {{ auth()->user()->username }}
                            </span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" novalidate>
                            @csrf
                            <button type="submit" class="font-bold text-white py-2 px-4 bg-red-500 rounded-lg cursor-pointer hover:bg-red-700">
                                Cerrar Sesión
                            </button>
                        </form>
                        
                    </nav>
                @endauth

                @guest
                    <nav class="flex gap-2 items-center">
                        <a class="font-bold uppercase text-blue-500 text-sm" href="{{ route('login') }}">Login</a>
                        <a class="font-bold uppercase text-blue-500 text-sm" href="{{ route('register') }}">
                            Crear Cuenta
                        </a>
                    </nav>
                @endguest
            </div>
        </header>

        <main class="container max-w-11/12 mx-auto mt-10 flex-grow">
            <h2 class="font-black text-center text-3xl mb-10">
                @yield('titulo')
            </h2>

            @yield('contenido')
        </main>

        <footer class="flex justify-around items-center mt-10 p-6 shadow-2xl">
            <div class="flex flex-col md:flex-row md:justify-between gap-4 md:gap-8 items-center">
                <p class="uppercase text-gray-500 text-center md:text-left">DevStagram - Todos los derechos reservados {{ now()->year }}</p>
                <p class="text-gray-700 uppercase font-bold">Proyecto de prueba</p>
                <p class="text-blue-500">Desarrollado por: <a class="font-bold" href="https://jordydev.website/" target="_blank" rel="noopener noreferrer">JordyDev</a></p>
            </div>
        </footer>

        @stack('scripts')
        @livewireScripts
    </body>
</html>
