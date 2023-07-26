@extends('plantilla')
@section('title', 'Videos')
@section('content')
    @if ($videos->count())
        <div class=" mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
            <header class="px-5 py-4 border-b border-gray-100 grid grid-cols-2">
                <h2 class="font-semibold text-gray-800 text-left col-span-1">Mis videos</h2>
                <a class="col-span-1 text-right justify-end" href="{{ route('video.subir', Auth::user()->id) }}">
                    <x-classicbutton>
                        Subir video
                    </x-classicbutton>
                </a>
            </header>
            @if (session('success'))
                <div class="font-regular regular block w-full rounded-lg bg-green-400 p-2 text-base leading-5 text-black opacity-100"
                    data-dismissible="alert">
                    <div class="mr-12">{{ session('success') }}</div>
                    <div class="absolute top-2.5 right-3 w-max rounded-lg transition-all hover:bg-white hover:bg-opacity-20"
                        data-dismissible-target="alert"><button role="button" class="w-max rounded-lg p-1"><svg
                                xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                            </svg></button></div>
                </div>
            @endif
            <div class="p-3">
                <div class="overflow-x-auto">
                    <table class="table-auto w-full h-full">
                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                            <tr>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Titulo</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Descripción</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Duración</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Visualizaciones</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Palabras claves</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Acciones</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            @foreach ($videos as $video)
                                <tr>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 flex-shrink-0 mr-2 sm:mr-3"><video class="rounded-full"
                                                    src="{{ $video->path }}" width="40" height="40" muted pause>
                                            </div>
                                            <div class="font-medium text-gray-800">{{ $video->titulo }}</div>
                                        </div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center">{{ $video->descripcion }}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center font-medium">{{ $video->duracion }}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-lg text-center">{{ $video->visualizaciones($video->id) }}</div>
                                    </td>
                                    <td>
                                        <div>
                                            <x-classicbutton type="button" onclick="openModal(true, {{ $video->id }})">
                                                Ver palabras</x-classicbutton>
                                            <div id="modal_overlay_{{ $video->id }}"
                                                class="hidden absolute inset-0 bg-black bg-opacity-30 h-screen w-full justify-center items-start md:items-center pt-10 md:pt-0">
                                                {{-- modal --}}
                                                <div id="modal_{{ $video->id }}"
                                                    class="opacity-0 transform -translate-y-full scale-150  relative w-10/12 md:w-1/2 h-1/2 md:h-3/4 bg-white rounded shadow-lg transition-opacity transition-transform duration-300">
                                                    {{-- Cerrar esquina --}}
                                                    <button type="button" onclick="openModal(false, {{ $video->id }})"
                                                        class="absolute -top-3 -right-3 bg-red-500 hover:bg-red-600 text-2xl w-10 h-10 rounded-full focus:outline-none text-white">
                                                        &cross;
                                                    </button>
                                                    {{-- titulo --}}
                                                    <div class="px-4 py-3 border-b border-gray-200">
                                                        <h2 class="text-xl font-semibold text-gray-600">Palabras Claves</h2>
                                                    </div>
                                                    {{-- body --}}
                                                    <div class="w-full p-3 grid grid-cols-3">
                                                        @foreach ($video->palabrasVideo($video->id) as $palabra)
                                                            <span class="col-span-3 text-lg flex justify-center">
                                                                -{{ $palabra->palabra }}</span>
                                                        @endforeach
                                                    </div>

                                                    {{-- Boton cerrar --}}
                                                    <div
                                                        class="absolute bottom-0 left-0 px-4 py-3 border-t border-gray-200 w-full flex justify-end items-center gap-3">
                                                        <x-classicbutton type="button"
                                                            onclick="openModal(false, {{ $video->id }})">Cerrar
                                                        </x-classicbutton>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-lg text-center">

                                            <div class="flex justify-center gap-4">
                                                <span title="Eliminar video">
                                                    <a onclick="borrar({{ $video->id }})" type="button"
                                                        style="cursor: pointer;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="h-6 w-6" x-tooltip="tooltip">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                        </svg>
                                                    </a>
                                                </span>
                                                <span title="Editar video">
                                                    <a href="{{ route('video.editar', $video->id) }}"
                                                        style="cursor: pointer;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="h-6 w-6" x-tooltip="tooltip">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                        </svg>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="mx-auto bg-white shadow-lg rounded-sm border border-gray-200 w-full h-full">
            <div class="place-items-center justify-center text-center">
                <a href="{{ route('video.subir', Auth::user()->id) }}">
                    <x-classicbutton>
                        Subir mi primer video
                    </x-classicbutton>
                </a>
            </div>
            <h1 class="place-items-center justify-center text-center">No se han registrado videos por el momento. Suba su
                primer video presionan el boton
                Subir
                Video.</h1>
        </div>
    @endif
    {{-- MODAL PALABRAS CLAVES --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"> --}}
    <script>
        function openModal(value, id) {
            const modalId = `#modal_${id}`;
            const overlayId = `#modal_overlay_${id}`;

            const modal = document.querySelector(modalId);
            const modal_overlay = document.querySelector(overlayId);

            const modalCl = modal.classList;
            const overlayCl = modal_overlay.classList;

            if (value) {
                overlayCl.remove('hidden');
                overlayCl.add('flex');
                setTimeout(() => {
                    modalCl.remove('opacity-0');
                    modalCl.remove('-translate-y-full');
                    modalCl.remove('scale-150');
                }, 100);
            } else {
                modalCl.add('-translate-y-full');
                setTimeout(() => {
                    modalCl.add('opacity-0');
                    modalCl.add('scale-150');
                }, 100);
                setTimeout(() => overlayCl.add('hidden'), 300);
            }
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- BORRAR VIDEO --}}
    <script>
        function borrar(idVideo) {
            Swal.fire({
                title: '¿Seguro que lo desea eliminar?',
                text: "No podrá volver a ver el video!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // creo formulario
                    var form = document.createElement("form");
                    form.action = "{{ route('videos.eliminar') }}";
                    form.method = "POST";
                    form.style.display = "none";

                    //Creo el token que necesita laravel
                    var csrfToken = document.createElement("input");
                    csrfToken.type = "hidden";
                    csrfToken.name = "_token";
                    csrfToken.value = "{{ csrf_token() }}";

                    //inserto el input
                    var method = document.createElement("input");
                    method.type = "hidden";
                    method.name = "_method";
                    // method.value = "POST";

                    //le asigno el idVideo que esta como parametro al input
                    var inputId = document.createElement("input");
                    inputId.type = "hidden";
                    inputId.name = "id";
                    inputId.value = idVideo;

                    form.appendChild(csrfToken);
                    form.appendChild(method);
                    form.appendChild(inputId);

                    document.body.appendChild(form);

                    // submit del formulario creado
                    form.submit();
                }
            });
        }
    </script>
@endsection
