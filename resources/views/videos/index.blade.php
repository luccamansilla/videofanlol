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
                        class="bg-blue-500 p-2 rounded-tr-lg rounded-br-lg text-white font-semibold hover:bg-blue-800 transition-colors" />
                </div>
            </form>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="contenidoVideos">
        @foreach ($videos as $video)
            <div class="each mb-10 m-2 shadow-lg border-gray-800 bg-gray-100 relative">
                <a href="{{ route('video.ver', $video->id) }}">
                    <video class="clip w-96 h-72  rounded-lg " loop muted>
                        <source src="{{ asset('videos') }}/{{ $video->path }}" type="video/mp4">
                    </video>
                </a>
                <div class="badge absolute top-0 left-0 bg-indigo-500 m-1 text-gray-200 p-1 px-2 text-xs font-bold rounded">
                    {{ $video->visualizaciones($video->id) }} Visualizaciones</div>

                <div class="badge absolute top-0 right-0 bg-gray-500 m-1 text-gray-200 p-1 px-2 text-xs font-bold rounded">
                    {{ $video->duracion }}</div>
                <div class="desc p-4 text-gray-800">
                    <a href="{{ route('video.ver', $video->id) }}"><span
                            class="title font-bold block cursor-pointer hover:underline text-xl">{{ $video->titulo }}</span></a>
                    <span
                        class="badge bg-indigo-500 text-blue-100 rounded px-1 text-xs font-bold cursor-pointer">{{ $video->user->username }}</span>
                    <span class="description text-xs block py-2 border-gray-400 mb-2">{{ $video->descripcion }}</span>
                </div>
            </div>
        @endforeach
    </div>
@endsection
