@extends('layouts.app')

@section('titulo')
    {{ $post->titulo }}
@endsection

@section('contenido')

    <div class="container mx-auto md:flex gap-4">
        <div class="md:w-1/2 mb-5 md:mb-0">
            <img src="{{ asset('uploads') . '/' . $post->imagen}}" class="rounded shadow-lg "  alt="Post de {{$post->titulo}}">

            <div class="p-3 flex items-center gap-2">
                @auth

                    <livewire:like-post :post="$post" />

                @endauth
            </div>

            <div>

                <p class="mb-3">
                    {{ $post->descripcion }}
                </p>

                <div class="grow mb-2">
                    <a href="{{ route('posts.index', $post->user) }}" class="font-bold mt-1 -ms-1 p-1 relative z-10 inline-flex items-center gap-x-2 text-md rounded-lg border border-transparent text-gray-700 hover:bg-white hover:shadow-2xs disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-800">
                        <img class="shrink-0 size-6 rounded-full" src="{{ $user->imagen ? asset('perfil') . '/' . $user->imagen : asset('img/usuario.svg') }}" alt="{{ $user->username }}">
                        {{ $post->user->username }}
                    </a>
                </div>
                
                <p class="text-sm text-gray-500">
                    Publicado {{ $post->created_at->diffForHumans() }}
                </p>
            </div>

            @auth
                @if ($post->user_id === auth()->user()->id)
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="form-eliminar">
                        @method('DELETE')
                        @csrf

                        <input 
                            type="submit"
                            class="bg-red-500 hover:bg-red-600 p-2 rounded text-white font-bold mt-4 cursor-pointer"
                            value="Eliminar Publicación"
                        />
                    </form>
                @endif
            @endauth
        </div>

        <div class="md:w-1/2">
            <div class="shadow bg-white p-5 mb-5 rounded">

                @auth
                    <p class="text-xl font-bold text-center mb-4">Agrega un nuevo comentario </p>

                    @if (session('mensaje'))
                        <div class="space-y-5">
                            <div class="bg-teal-50 border-t-2 border-teal-500 rounded-lg p-4 dark:bg-teal-800/30" role="alert" tabindex="-1" aria-labelledby="hs-bordered-success-style-label">
                                <div class="flex">
                                <div class="shrink-0">
                                    <!-- Icon -->
                                    <span class="inline-flex justify-center items-center size-8 rounded-full border-4 border-teal-100 bg-teal-200 text-teal-800 dark:border-teal-900 dark:bg-teal-800 dark:text-teal-400">
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg>
                                    </span>
                                    <!-- End Icon -->
                                </div>
                                <div class="ms-3">
                                    <h3 id="hs-bordered-success-style-label" class="text-gray-800 font-semibold dark:text-white">
                                    {{session('mensaje')}}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('comentarios.store', ['post' => $post, 'user' => $user]) }}" method="POST">
                        @csrf

                        <div class="mb-5">
                            <div class="flex flex-wrap justify-between items-center gap-2">
                                <label for="comentario" class="mb-2 block uppercase text-blue-500 font-bold">Añade un comentario</label>
                                <span class="block mb-2 text-sm uppercase text-gray-500 dark:text-neutral-500">Max: 225</span>
                            </div>
                            <textarea 
                                type="text"
                                id="comentario"
                                name="comentario"
                                placeholder="Agrega un comentario"
                                class="p-3 w-full rounded-lg shadow 
                                @error('comentario')
                                    border-red-500
                                @enderror"
                            ></textarea>
                            @error('comentario')
                                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                            @enderror
                        </div>

                        <input type="submit" 
                            value="Comentar"
                            class="bg-blue-500 hover:bg-blue-600 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg"
                        >
                    </form>
                @endauth

                <div class="shadow my-5 max-h-96 overflow-y-scroll p-5">
                    @if ($post->comentarios->count())
                        @foreach ($post->comentarios as $comentario)
                            <div>
                                <div class="ps-2 my-2 first:mt-0">
                                    <h3 class="text-xs font-medium uppercase text-gray-500 dark:text-neutral-400">
                                    {{ $comentario->created_at->diffForHumans() }}
                                    </h3>
                                </div>
                                <div class="flex gap-x-3 relative group rounded-lg hover:bg-gray-100 dark:hover:bg-white/10">
                                    <div class="relative last:after:hidden after:absolute after:top-0 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700 dark:group-hover:after:bg-neutral-600">
                                        <div class="relative z-10 size-7 flex justify-center items-center">
                                            <div class="size-2 rounded-full bg-white border-2 border-gray-300 group-hover:border-gray-600 dark:bg-neutral-800 dark:border-neutral-600 dark:group-hover:border-neutral-600"></div>
                                        </div>
                                    </div>

                                    <div class="grow p-2 pb-5">
                                        <p class="mt-1 text-sm text-gray-600 dark:text-neutral-400">
                                            {{ $comentario->comentario }}
                                        </p>
                                        <a href="{{ route('posts.index', $comentario->user) }}" class="font-bold mt-1 -ms-1 p-1 relative z-10 inline-flex items-center gap-x-2 text-sm rounded-lg border border-transparent text-gray-700 hover:bg-white hover:shadow-2xs disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-800">
                                            <img class="shrink-0 size-6 rounded-full" src="https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8auto=format&fit=facearea&facepad=3&w=320&h=320&q=80" alt="Avatar">
                                            {{ $comentario->user->username }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="mt-2 bg-gray-50 border border-gray-200 text-sm text-gray-600 rounded-lg p-4 dark:bg-white/10 dark:border-white/10 dark:text-neutral-400">
                            <span id="hs-soft-color-secondary-label" class="font-bold">Aún no hay comentarios</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const forms = document.querySelectorAll('.form-eliminar');

        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Esta acción no se puede deshacer",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>