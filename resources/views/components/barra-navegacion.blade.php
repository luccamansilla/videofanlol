<nav class="flex justify-between bg-gray-900 text-white ">
    <div class="px-5 xl:px-12 py-2 flex w-full items-center">
        <a class="text-3xl font-bold font-heading lg:pl-28 pl-0" href="{{ route('video.inicio') }}">
            <img class="h-20" src="{{ asset('assets/image/Logo2.png') }}" alt="VideoFanLOL">
        </a>
        <!-- Nav Links -->
        <ul class="hidden md:flex px-4 mx-auto font-semibold font-heading space-x-12">
            <li><a class="hover:text-gray-500" href="{{ route('video.inicio') }}">Inicio</a></li>
            @auth
                <li><a class="hover:text-gray-500" href="{{ route('video.misvideos', Auth::user()->username) }}">Mis
                        videos</a></li>
                <li><a class="hover:text-gray-500" href="{{ route('profile.show') }}"
                        data-dropdown-toggle="dropdown">{{ Auth::user()->username }}</a></li>
            @else
                <li><a class="hover:text-gray-500" href=" {{ route('login') }}">Iniciar Sesión</a></li>
                <li><a class="hover:text-gray-500" href="{{ route('register') }}">Registrarse</a></li>

            @endauth
        </ul>

        <div class="hidden xl:flex items-center space-x-5 items-center">
            <!--   DROPDOWN   -->
            @auth
                <div class="relative">
                    <button id="dropdownInformationButton" data-dropdown-toggle="dropdownInformation"
                        class="text-white  hover:text-gray-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center"
                        type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hover:text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div id="dropdownInformation"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600 absolute right-0 mt-2">
                        <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                            <div>{{ Auth::user()->username }}</div>
                            <div class="font-medium truncate">{{ Auth::user()->email }}</div>
                        </div>
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownInformationButton">
                            <li>
                                <a href="{{ route('video.inicio') }}"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Inicio</a>
                            </li>
                            <li>
                                <a href="{{ route('profile.show') }}"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Perfil</a>
                            </li>
                        </ul>
                        <div class="py-2">
                            <a href="{{ route('cerrarSesion') }}"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Cerrar
                                Sesión</a>
                        </div>
                    </div>
                </div>
            @else
                <a class="text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center"
                    href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hover:text-gray-200" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </a>
            @endauth
        </div>
    </div>
    <!-- Responsive navbar -->
    <button type="button" data-dropdown-toggle="dropdownResponsive" class="navbar-burger self-center mr-12 xl:hidden"
        id="dropdownInformationResponsive">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hover:text-gray-200" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
    <div id="dropdownResponsive"
        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600 absolute right-0 mt-16">
        <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
            @auth
                <div>{{ Auth::user()->username }}</div>
                <div class="font-medium truncate">{{ Auth::user()->email }}</div>
            @else
                <a href="{{ route('login') }}" class="hover:underline">
                    <div>Iniciar Sesion</div>
                </a>
            @endauth
        </div>
        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownInformationResponsive">

            <li>
                <a href="{{ route('video.inicio') }}"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Inicio</a>
            </li>
            @auth
                <li>
                    <a href="{{ route('profile.show') }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Perfil</a>
                </li>
                <li>
                    <a href="{{ route('video.misvideos', Auth::user()->username) }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mis
                        videos</a>
                </li>
            @endauth
        </ul>
        <div class="py-2">
            @auth

                <a href="{{ route('cerrarSesion') }}"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Cerrar
                    Sesión</a>
            @else
                <a href="{{ route('register') }}"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white hover:underline">Registrarse</a>
            @endauth

        </div>
    </div>
</nav>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Mostrar el menú desplegable al hacer clic en el botón
        $("#dropdownInformationButton").on("click", function() {
            $("#dropdownInformation").toggleClass("hidden");
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Mostrar el menú desplegable al hacer clic en el botón
        $("#dropdownInformationResponsive").on("click", function() {
            $("#dropdownResponsive").toggleClass("hidden");
        });
    });
</script>
