@extends('plantilla')
@section('title', 'Videos')
@section('content')
    <style>
        .progress {
            position: relative;
            width: 100%;
        }

        .bar {
            background-color: #2dab27;
            width: 0%;
            height: 20px;
        }

        .percent {
            position: absolute;
            display: inline-block;
            left: 50%;
            color: #040608;
        }
    </style>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    {{-- Mensaje del beneficio --}}
    <div class="progress" style="display: none;" id="progressBar">
        <div class="bar"></div>
        <div class="percent">0%</div>
    </div>
    @if ($user->beneficio)
        <div class=" bg-gray-50 flex flex-col justify-center relative overflow-hidden">
            <div class="py-2">
                <div class="relative group">
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-gray-600 rounded-lg blur opacity-25 group-hover:opacity-100 transition duration-1000 group-hover:duration-200">
                    </div>
                    <div
                        class="relative px-7 py-6 bg-white ring-1 ring-gray-900/5 rounded-lg leading-none flex items-top justify-start space-x-6">
                        <span class="material-symbols-outlined w-8 h-8 text-purple-600" fill="none" viewBox="0 0 24 24"
                            style="font-size: 2rem;">
                            celebration
                        </span>
                        <div class="space-y-2">
                            <p class="text-slate-800"><strong>Acualmente tiene un beneficio!</strong><br>Debido a que supero
                                mas
                                de 100
                                visualizaciones diarias durante 5 dias, ahora podrá subir videos de hasta ¡1 GB!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <form method="POST" action="{{ route('video.update', $video) }}" enctype="multipart/form-data" id="idFormulario">
        @csrf
        {{-- Formulario para la subida del video --}}
        <div class="bg-gray-50 flex flex-col justify-center relative overflow-hidden">
            <div class=" bg-white rounded shadow-lg p-4 ">
                <div class="grid  text-sm grid-cols-1 lg:grid-cols-2">
                    <div class="text-gray-600 col-span-2">
                        <p class="font-medium text-lg">Ingrese los datos del video.</p>
                        <p>Todos los campos son necesarios.</p>
                    </div>
                    <div class="lg:col-span-2">
                        <div class="grid gap-2 gap-y-1 text-sm grid-cols-1 md:grid-cols-5">

                            <div class="md:col-span-5">
                                <x-input id="idUser" value="{{ route('video.misvideos', Auth::user()->username) }}"
                                    hidden></x-input>
                                <x-label for="titulo">Título</x-label>
                                <x-input type="text" name="titulo" id="titulo"
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                    placeholder="Ingrese el título del video" value="{{ $video->titulo }}" />
                                <span id="error-titulo" class="text-red-500"></span>
                            </div>


                            <div class="md:col-span-3 md:row-span-3">
                                <x-label for="descripcion">Descripción</x-label>
                                <textarea name="descripcion" id="descripcion" class="h-32 border mt-1 rounded px-4 w-full bg-gray-50"
                                    placeholder="Ingrese la descripción del video">{{ $video->descripcion }}</textarea>
                                <span id="error-descripcion" class="text-red-500"></span>

                            </div>
                            <div class="md:col-span-2 md:row-span-3 justify-center place-items-center">
                                <x-label for="archivo">Archivo del video</x-label>
                                @if ($video->path)
                                    {{-- <p>{{ $video->path }}</p> --}}
                                    <video class="object-cover w-80  rounded-xl h-44 lg:h-44" controls pause>
                                        <source src="{{ asset('videos') }}/{{ $video->path }}">
                                    </video>
                                @endif
                            </div>

                            <div class="md:col-span-2">
                                <x-label for="grabacion">Fecha de la grabación</x-label>
                                <x-input type="date" name="grabacion" id="grabacion"
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                    value="{{ $video->fecha_grabacion }}" />
                                <span id="error-grabacion" class="text-red-500"></span>
                            </div>

                            <div class="md:col-span-3 md:row-span-2 justify-end">
                                <x-label for="mapa">Ubicación de la grabación del video</x-label>
                                <div id="mapa" class="w-full h-52"></div>
                                <input type="hidden" name="latitud" id="latitud"
                                    value="{{ $video->ubicacion->latitud }}">
                                <input type="hidden" name="longitud" id="longitud"
                                    value="{{ $video->ubicacion->longitud }}">
                                <span id="error-latitud" class="text-red-500"></span>
                                <span id="error-longitud" class="text-red-500" hidden></span>
                            </div>

                            <div class="md:col-span-2">
                                <x-label for="botonModal">Ingrese aqui las palabras claves</x-label>
                                <x-classicbutton type="button" onclick="openModal(true)" id="botonModal">Palabras claves
                                </x-classicbutton>
                                <span name="error-palabrasClaves"></span>
                                <span id="error-palabrasClaves" class="text-red-500"></span>
                            </div>

                            <div class="md:col-span-5 text-right">
                                <div class="inline-flex items-end">
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Subir
                                        video</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        {{-- MODAL --}}
        <div id="modal_overlay"
            class="hidden absolute inset-0 bg-black bg-opacity-30 h-screen w-full justify-center items-start md:items-center pt-10 md:pt-0">
            {{-- modal --}}
            <div id="modal"
                class="opacity-0 transform -translate-y-full scale-150  relative w-10/12 md:w-1/2 h-1/2 md:h-3/4 bg-white rounded shadow-lg transition-opacity transition-transform duration-300">

                {{-- Cerrar esquina --}}
                <button type="button" onclick="openModal(false)"
                    class="absolute -top-3 -right-3 bg-red-500 hover:bg-red-600 text-2xl w-10 h-10 rounded-full focus:outline-none text-white">
                    &cross;
                </button>
                {{-- titulo --}}
                <div class="px-4 py-3 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-600">Palabras Claves</h2>
                </div>
                {{-- body --}}
                <div class="w-full p-3 grid grid-cols-3">
                    <p class="col-span-3 px-2"> Ingrese las palabras claves del video.</p>
                    <x-input class="col-span-2 px-2" type="text" name="palabra" id="idPalabra" value="">
                    </x-input>
                    <x-classicbutton type="button" onclick="guardarPalabra()" id="botonGuardarPalabra">Guardar
                        palabra
                    </x-classicbutton>
                    <p class="col-span-3 px-2 text-red-500 text-center justify-center"> Tenga en cuenta que para eliminar
                        una palabra clave debe
                        clickear sobre ella.</p>
                    {{-- col span 3 --}}
                    <x-input type="text" name="palabrasClaves" id="idPalabrasClaves" hidden></x-input>
                    <div class="col-span-3" id="muestroPalabras">
                    </div>
                </div>

                {{-- Boton cerrar --}}
                <div
                    class="absolute bottom-0 left-0 px-4 py-3 border-t border-gray-200 w-full flex justify-end items-center gap-3">
                    <x-classicbutton type="button" onclick="openModal(false)">Cerrar</x-classicbutton>
                </div>
            </div>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- MODAL PALABRAS CLAVES --}}
    <script>
        const modal_overlay = document.querySelector('#modal_overlay');
        const modal = document.querySelector('#modal');

        function openModal(value) {
            $('html, body').animate({
                scrollTop: $('#progressBar').offset().top
            }, 500);
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
    {{-- MAPA MARCADO --}}
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8CdN_k5mY0J1YUvPepRAN8euw8bTocww&libraries=places">
    </script>
    <script>
        var latitud = {{ $video->ubicacion->latitud }};
        var longitud = {{ $video->ubicacion->longitud }};

        // Llama a la función initMap con los valores obtenidos
        document.addEventListener("DOMContentLoaded", function() {
            initMap(latitud, longitud);
        });

        function initMap(latitud, longitud) {
            var mapa = new google.maps.Map(document.getElementById('mapa'), {
                center: {
                    lat: latitud,
                    lng: longitud
                },
                zoom: 6
            });
            var marcador = new google.maps.Marker({
                position: {
                    lat: latitud,
                    lng: longitud
                },
                map: mapa,
                draggable: true
            });

            // Agregar un evento de clic en el mapa
            mapa.addListener('click', function(event) {
                // Eliminar cualquier marcador existente
                if (marcador) {
                    marcador.setMap(null);
                }

                // Crear un nuevo marcador en la ubicación del clic
                marcador = new google.maps.Marker({
                    position: event.latLng,
                    map: mapa,
                    draggable: true
                });

                // Obtener la latitud y longitud del marcador
                var latitud = event.latLng.lat();
                var longitud = event.latLng.lng();

                console.log(latitud);
                console.log(longitud);

                // Actualizar los campos ocultos
                document.getElementById('latitud').value = latitud;
                document.getElementById('longitud').value = longitud;
            });
        };
    </script>
    {{-- SCRIPTS PARA BARRA DE CARGA --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"> --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
    </script>
    {{-- BARRA DE CARGA --}}
    <script>
        $(document).ready(function() {
            var bar = $('.bar');
            var percent = $('.percent');
            $('form').submit(function(event) {
                event.preventDefault(); // paro el envio del formulario
                //envio la posicion de la página a la barra de carga
                $('html, body').animate({
                    scrollTop: $('#progressBar').offset().top
                }, 500);
                var form = $(this);
                var formData = new FormData(form[0]);

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $(".progress").show(); // muestro la barra de carga
                        var percentVal = '0%';
                        bar.width(percentVal);
                        percent.html(percentVal);
                    },
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = (evt.loaded / evt.total) * 100;
                                var percentVal = Math.floor(percentComplete) +
                                    '%'; // solo obtengo los numeros enteros del porcentaje
                                bar.width(percentVal);
                                percent.html(percentVal);
                            }
                        }, false);
                        return xhr;
                    },
                    complete: function(xhr) {
                        // console.log("STATUS " + xhr.status);
                        $(".progress")
                            .hide(); // Ocultar la barra de carga una vez completado (exitosamente o con error)

                        if (xhr.status !== 422) {
                            // La solicitud fue exitosa, muestra la alerta y redirige
                            Swal.fire({
                                icon: 'success',
                                title: '¡El video se subió exitosamente!',
                                text: 'Serás redirigido al inicio.',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(function() {
                                var direccion = document.getElementById('idUser').value;
                                window.location.href = direccion;
                            }, 1500);
                        } else {
                            console.log(xhr);
                            if (xhr.status === 422) {
                                var response = JSON.parse(xhr.responseText);
                                var errors = response.errors;
                                // console.log(errors);
                                $('.error-message').remove();
                                for (var key in errors) {
                                    // console.log(key);
                                    if (key == 'palabrasClaves') {
                                        var errorMessage = errors[key][0];
                                        var inputField = $(
                                            'span[name="error-palabrasClaves"]'
                                        ); // para mostrar el mensaje de error abajo del boton de palabras claves, sino lo muestra dentro del modal y no es intuitivo
                                        var errorMessageElement = $(
                                            '<p class="text-red-500 error-message">' +
                                            errorMessage +
                                            '</p>');
                                        inputField.after(errorMessageElement);
                                    } else {
                                        var errorMessage = errors[key][0];
                                        var inputField = $('input[name="' + key + '"]');
                                        var errorMessageElement = $(
                                            '<p class="text-red-500 error-message">' +
                                            errorMessage +
                                            '</p>');

                                        var errorLabel = $('label[for="' + key + '"]');
                                        if (errorLabel.length) {
                                            errorLabel.after(errorMessageElement);
                                        } else {
                                            inputField.after(errorMessageElement);
                                        }
                                    }
                                }
                            }
                            $(".progress").hide();
                        }
                    }
                });
            });
        });
    </script>
    {{-- Palabras claves --}}
    <script>
        //Cargo en el modal las palabras claves que tiene el video
        $(document).ready(function() {
            actualizarPalabras();
        })
    </script>
    <script>
        var palabras = @json($palabras); // en el array palabras obtengo todas las palabras claves que ya tiene
        var muestro = document.getElementById('muestroPalabras');

        function guardarPalabra() {
            var palabraInput = document.getElementById('idPalabra');
            var palabra = palabraInput.value;
            if (palabra) {
                if (palabras.length < 10) {
                    palabras.push(palabra);
                    actualizarPalabras();
                    palabraInput.value = '';
                } else {
                    Swal.fire('Alcanzó al máximo de palabras claves por video (10).')
                }
            } else {
                Swal.fire('Debe ingresar una palabra.')
            }
        }

        function actualizarPalabras() {
            var palabrasClaves = document.getElementById('idPalabrasClaves');
            var palabrasSeparadas = palabras.join('-');
            palabrasClaves.value = palabrasSeparadas;
            console.log(palabrasClaves.value);

            var muestroPalabras = document.getElementById('muestroPalabras');
            muestroPalabras.innerHTML = ''; // Limpiar el contenido previo
            var contador = 1;
            palabras.forEach(function(palabra) {
                var span = document.createElement('span');
                var salto = document.createElement('br');
                span.classList.add('palabra-clickeable');
                span.classList.add('text-lg');
                span.classList.add('text-center');
                span.classList.add('justify-center');
                span.classList.add('col-span-3');
                span.style.cursor = "pointer";
                span.textContent = contador + " - " + palabra;

                span.addEventListener('click', function() {
                    var indice = palabras.indexOf(palabra);
                    if (indice !== -1) {
                        palabras.splice(indice, 1);
                        actualizarPalabras();
                    }
                });

                muestroPalabras.appendChild(span);
                muestroPalabras.appendChild(salto);
                contador++;
            });
        }
    </script>
@endsection
