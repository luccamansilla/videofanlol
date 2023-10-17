@extends('plantilla')
@section('title', 'Videos')
@section('content')
    <section class="bg-white ">
        <div class="container mx-auto mb-5">
            <div class="mt- mx-6 lg:flex lg:items-center">

                <video class="object-cover w-full lg:mx-6 lg:w-1/2 rounded-xl h-60 lg:h-80" id="video" autoplay controls>
                    <source src="{{ asset('videos') }}/{{ $video->path }}" type="video/mp4">
                </video>

                <div class="mt-6 lg:w-1/2 lg:mt-0 lg:mx-6 ">
                    <p class="text-sm text-black uppercase font-sans">{{ $video->created_at->format('d/m/Y') }}</p>

                    <p class="block mt-4 text-sm font-semibold text-black hover:underline md:text-3xl">
                        {{ $video->titulo }}
                    </p>

                    <div class="flex items-center ">
                        <div>
                            <h1
                                class="text-sm text-white bg-gray-500 inline-block px-2 py-1 rounded-full border-2 border-gray-500">
                                {{ $video->user->username }}
                            </h1>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-800 md:text-sm">
                        {{ $video->descripcion }}
                    </p>

                    <a href="#" onclick="openModal(true)" id="mostrarUbicacion"
                        class="mt-1 inline-block text-blue-500 underline hover:text-blue-400">Ubicación</a>

                    <div>
                        <p class="lg:mt-6 mt-1 text-sm text-gray-700"> {{ $video->visualizaciones($video->id) }}
                            Visualizaciones</p>
                    </div>
                </div>
            </div>
        </div>
        <span class="ml-10 text-lg">Videos relacionados</span>
        <div class="grid md:grid-cols-2 grid-cols-1 lg:grid-cols-3">
            {{-- VIDEOS RELACIONADOS --}}
            @foreach ($videos as $vid)
                <div
                    class="w-full bg-white px-6 pt-6 pb-2 rounded-xl shadow-lg transform hover:scale-105 transition duration-500">
                    <div class="relative">
                        <a href="{{ route('video.ver', $vid->id) }}"><video class=" rounded-xl w-full h-48" loop muted>
                                <source src="{{ asset('videos') }}/{{ $vid->path }}" type="video/mp4">
                            </video></a>
                        <p
                            class="absolute top-0 bg-yellow-300 text-gray-800 font-semibold py-1 px-3 rounded-br-lg rounded-tl-lg">
                            {{ $vid->visualizaciones($vid->id) }} Visualizaciones</p>
                        <p
                            class="absolute bottom-0 right-0 bg-yellow-300 text-gray-800 font-semibold py-1 px-3 rounded-br-lg rounded-tl-lg">
                            {{ $vid->duracion }}</p>
                    </div>
                    <a href="{{ route('video.ver', $vid->id) }}" class="hover:underline">
                        <h1 class="mt-4 text-gray-800 text-2xl font-bold cursor-pointer">{{ $vid->titulo }}
                        </h1>
                    </a>
                    <div class="my-2">
                        <div class="flex space-x-1 items-center">
                            <span>

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 mb-1.5"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle cx="12" cy="6" r="4" stroke="#1C274C"
                                        stroke-width="1.5" />
                                    <path
                                        d="M19.9975 18C20 17.8358 20 17.669 20 17.5C20 15.0147 16.4183 13 12 13C7.58172 13 4 15.0147 4 17.5C4 19.9853 4 22 12 22C14.231 22 15.8398 21.8433 17 21.5634"
                                        stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            </span>
                            <p>{{ $video->user->username }}</p><br>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </section>
    <div id="modal_overlay" class="hidden fixed inset-0 bg-black bg-opacity-30 justify-center items-center">

        {{-- modal --}}
        <div id="modal"
            class="opacity-0 transform -translate-y-full scale-150 relative w-10/12 md:w-1/2 bg-white rounded shadow-lg transition-opacity transition-transform duration-300">

            {{-- Cerrar esquina --}}
            <button type="button" onclick="openModal(false)"
                class="absolute -top-3 -right-3 bg-red-500 hover:bg-red-600 text-2xl w-10 h-10 rounded-full focus:outline-none text-white">
                &cross;
            </button>

            {{-- titulo del modal --}}
            <div class="px-4 py-3 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-600">Ubicación de la grabación</h2>
            </div>

            {{-- body --}}
            <div id="mapa" class="flex-grow w-full h-96"></div>

            {{-- Boton cerrar --}}
            <div class="px-4 py-3 border-t border-gray-200 w-full flex justify-end items-center gap-3">
                <x-classicbutton type="button" onclick="openModal(false)">Cerrar</x-classicbutton>
            </div>
        </div>
    </div>

    </div>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8CdN_k5mY0J1YUvPepRAN8euw8bTocww&libraries=places">
    </script>
    {{-- mapa --}}
    <script>
        // Obtén los valores de latitud y longitud desde el controlador de Laravel
        var latitud = {{ $video->ubicacion->latitud }};
        var longitud = {{ $video->ubicacion->longitud }};

        // Llama a la función initMap con los valores obtenidos
        document.addEventListener("DOMContentLoaded", function() {
            initMap(latitud, longitud);
        });
    </script>
    <script>
        var boton = document.getElementById('botonUbicacion');
        var mapa = document.getElementById('mapa');

        boton.addEventListener('click', function() {
            mapa.hidden = !mapa.hidden;
        });
    </script>
    <script>
        function initMap(latitud, longitud) {
            var mapa = new google.maps.Map(document.getElementById('mapa'), {
                center: {
                    lat: latitud,
                    lng: longitud
                },
                zoom: 7
            });
            var marcador = new google.maps.Marker({
                position: {
                    lat: latitud,
                    lng: longitud
                },
                map: mapa,
                draggable: true
            });
        }
    </script>
    {{-- modal --}}
    <script>
        const modal_overlay = document.querySelector('#modal_overlay');
        const modal = document.querySelector('#modal');

        function openModal(value) {
            const modalCl = modal.classList
            const overlayCl = modal_overlay

            if (value) {
                overlayCl.classList.remove('hidden');
                overlayCl.classList.add('flex');
                setTimeout(() => {
                    modalCl.remove('opacity-0')
                    modalCl.remove('-translate-y-full')
                    modalCl.remove('scale-150')
                }, 100);
            } else {
                modalCl.add('-translate-y-full')
                setTimeout(() => {
                    modalCl.add('opacity-0')
                    modalCl.add('scale-150')
                }, 100);
                setTimeout(() => overlayCl.classList.add('hidden'), 300);
            }
        }
    </script>

@endsection
