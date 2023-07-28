@extends('plantilla')
@section('title', 'VideoFanLOL')
@section('content')
    <div class="flex items-center justify-center">
        <div class="w-full rounded-lg bg-gray-200 p-1">
            <form method="GET" action="{{ route('video.inicio') }}" id="formuBuscar">
                <div class="flex">
                    <div
                        class="flex w-10 items-center justify-center rounded-tl-lg rounded-bl-lg border-r border-gray-200 bg-white p-5">
                        <svg viewBox="0 0 20 20" aria-hidden="true"
                            class="pointer-events-none absolute w-5 fill-gray-500 transition">
                            <path
                                d="M16.72 17.78a.75.75 0 1 0 1.06-1.06l-1.06 1.06ZM9 14.5A5.5 5.5 0 0 1 3.5 9H2a7 7 0 0 0 7 7v-1.5ZM3.5 9A5.5 5.5 0 0 1 9 3.5V2a7 7 0 0 0-7 7h1.5ZM9 3.5A5.5 5.5 0 0 1 14.5 9H16a7 7 0 0 0-7-7v1.5Zm3.89 10.45 3.83 3.83 1.06-1.06-3.83-3.83-1.06 1.06ZM14.5 9a5.48 5.48 0 0 1-1.61 3.89l1.06 1.06A6.98 6.98 0 0 0 16 9h-1.5Zm-1.61 3.89A5.48 5.48 0 0 1 9 14.5V16a6.98 6.98 0 0 0 4.95-2.05l-1.06-1.06Z">
                            </path>
                        </svg>
                    </div>
                    <x-input type="text" class=" px-1 w-full bg-white pl-2 text-base font-semibold outline-0"
                        placeholder="Busque por título, usuario, palabras claves o fecha de subida(AAAA-MM-DD)"
                        id="idBuscador" name="busqueda" value="{{ $busqueda }}" />
                    <input type="submit" value="Buscar"
                        class="bg-gray-900 p-2 rounded-tr-lg rounded-br-lg text-white font-semibold hover:bg-blue-800 transition-colors" />
                </div>
            </form>
        </div>
    </div>
    <div
        class="md:px-4 md:grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 sm:grid-cols-1 gap-5 place-content-center justify-center">
        @foreach ($videos as $video)
            <div
                class="max-w-sm bg-white px-6 pt-6 pb-2 rounded-xl shadow-lg transform hover:scale-105 transition duration-500">
                <div class="relative">
                    <a href="{{ route('video.ver', $video->id) }}"><video class=" rounded-xl w-full" loop muted>
                            <source src="{{ asset('videos') }}/{{ $video->path }}" type="video/mp4">
                        </video></a>
                    <p
                        class="absolute top-0 bg-yellow-300 text-gray-800 font-semibold py-1 px-3 rounded-br-lg rounded-tl-lg">
                        {{ $video->visualizaciones($video->id) }} Visualizaciones</p>
                </div>
                <a href="{{ route('video.ver', $video->id) }}" class="hover:underline">
                    <h1 class="mt-4 text-gray-800 text-2xl font-bold cursor-pointer">{{ $video->titulo }}
                    </h1>
                </a>
                <div class="my-2">
                    <div class="flex space-x-1 items-center">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg"class="h-6 w-6 text-indigo-600 mb-1.5"
                                viewBox="0 0 24 24" fill="none">
                                <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z"
                                        stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M12 6V12" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M16.24 16.24L12 12" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </g>

                            </svg>
                        </span>
                        <p>{{ $video->duracion }}</p>
                    </div>
                    <div class="flex space-x-1 items-center">
                        <span>

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 mb-1.5" fill="none"
                                viewBox="0 0 24 24">
                                <circle cx="12" cy="6" r="4" stroke="#1C274C" stroke-width="1.5" />
                                <path
                                    d="M19.9975 18C20 17.8358 20 17.669 20 17.5C20 15.0147 16.4183 13 12 13C7.58172 13 4 15.0147 4 17.5C4 19.9853 4 22 12 22C14.231 22 15.8398 21.8433 17 21.5634"
                                    stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                        </span>
                        <p>{{ $video->user->username }}</p><br>
                    </div>
                    <div class="flex space-x-1 items-center">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#1C274C" class="h-6 w-6 text-indigo-600 mb-1.5"
                                viewBox="0 0 24 24">
                                <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M21,2H3A1,1,0,0,0,2,3V21a1,1,0,0,0,1,1H21a1,1,0,0,0,1-1V3A1,1,0,0,0,21,2ZM4,4H20V6H4ZM20,20H4V8H20ZM6,12a1,1,0,0,1,1-1H17a1,1,0,0,1,0,2H7A1,1,0,0,1,6,12Zm0,4a1,1,0,0,1,1-1h5a1,1,0,0,1,0,2H7A1,1,0,0,1,6,16Z" />
                                </g>
                            </svg>
                        </span>
                        <p>{{ $video->descripcion }}</p><br>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="flex col-span-3 py-2">
        <div class="max-w-2xl mx-auto">
            <nav aria-label="Page navigation example">
                <ul class="inline-flex -space-x-px">
                    @if (!$videos->onFirstPage())
                        <li>
                            <a href="{{ $videos->previousPageUrl() }}"
                                class="bg-white border border-gray-300 text-gray-500 hover:bg-gray-100 hover:text-gray-700 ml-0 rounded-l-lg leading-tight py-2 px-3  dark:text-black dark:hover:bg-gray-900 dark:hover:text-white">Anterior</a>
                        </li>
                    @endif

                    @foreach ($videos->getUrlRange(1, $videos->lastPage()) as $page => $url)
                        @if ($page == $videos->currentPage())
                            <li>
                                <a
                                    class="rounded-lg bg-white border border-gray-300 text-gray-500 hover:bg-gray-100 hover:text-gray-700 leading-tight py-2 px-3  dark:text-black dark:hover:bg-gray-900 dark:hover:text-white">{{ $page }}</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                    class="rounded-md bg-white border border-gray-300 text-gray-500 hover:bg-gray-100 hover:text-gray-700 leading-tight py-2 px-3  dark:text-black dark:hover:bg-gray-900 dark:hover:text-white">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach

                    @if ($videos->hasMorePages())
                        <li>
                            <a href="{{ $videos->nextPageUrl() }}"
                                class="bg-white border border-gray-300 text-gray-500 hover:bg-gray-100 hover:text-gray-700 rounded-r-lg leading-tight py-2 px-3  dark:text-black dark:hover:bg-gray-900 dark:hover:text-white">Siguiente</a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>

@endsection
