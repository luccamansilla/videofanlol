<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .active {
            color: red;
            font-weight: bold;
        }
    </style>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    @vite('resources/css/app.css')
</head>
{{-- Esta plantilla es utilizada por todas las vistas --}}

<body>
    {{-- Muestro la barra de navegación --}}
    <x-barra-navegacion></x-barra-navegacion>
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {{-- Aqui es donde cada vista llama y muestra el contenido de cada una --}}
                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>
