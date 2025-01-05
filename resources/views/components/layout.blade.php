<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Bienvenue sur le site de la régie Immobiliere Mugnier')</title>
    <link type="text/css" rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Google+Sans_old:400,500,700|Google+Sans+Text_old:400,500,700&amp;lang=fr">
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.css" />

    {{-- <link href="{{ asset('build/assets/app-73662a70.css') }}" rel="stylesheet">
    <link href="{{ asset('build/assets/app-279b99f9.css') }}" rel="stylesheet">
    <script src="{{ asset('build/assets/app-4514722f.js') }}"></script> --}}
    {{-- @php
        $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
    @endphp
    @if (isset($manifest['resources/js/app.js']))
        <script type="module" src="/build/{{ $manifest['resources/js/app.js']['file'] }}"></script>
        @if (isset($manifest['resources/css/app.css']['file']))
            <link rel="stylesheet" href="/build/{{ $manifest['resources/css/app.css']['file'] }}">
        @endif
        @if (isset($manifest['resources/js/app.js']['css'][0]))
            <link rel="stylesheet" href="/build/{{ $manifest['resources/js/app.js']['css'][0] }}">
        @endif
    @endif --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('styles')
</head>

<body class="bg-gray-50 text-white font-hanken-grotest">
    <header class="bg-secondary text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('images/logo.png') }}" class="w-16" />
                <span
                    class="hidden xl:block self-center pt-2 text-xl font-bold whitespace-nowrap text-gray-800 dark:text-white font-hanken-grotest">Régie
                    Immobilière Mugnier</span>
            </a>
            <nav
                class="text-white hidden md:flex border-gray-200 dark:bg-gray-900 dark:border-gray-700 px-5 sticky top-0 z-50">
                <div class="hidden w-full md:block md:w-auto" id="navbar-multi-level">
                    <ul
                        class="flex flex-col text-sm lg:text-lg md:text-md font-medium md:space-x-2 rtl:space-x-reverse md:flex-row dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">

                        <?php $menus = \App\Models\Menu::with('children')->topLevel()->get(); ?>

                        @foreach ($menus as $menu)
                            <li>
                                @if ($menu->children->count() > 0)
                                    <!-- Menu avec sous-menus -->
                                    <button id="dropdownNavbarLink{{ $menu->id }}"
                                        data-dropdown-toggle="dropdownHover" data-dropdown-trigger="hover"
                                        class="flex items-center justify-between w-full py-2 px-3 font-bold text-gray-800 hover:text-primary md:hover:bg-transparent md:border-0 md:hover:text-primary  dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:hover:bg-gray-700 md:dark:hover:bg-transparent">
                                        {{ $menu->name }}
                                        <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 4 4 4-4" />
                                        </svg>
                                    </button>

                                    <!-- Dropdown menu -->
                                    <div id="dropdownHover"
                                        class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                            aria-labelledby="dropdownLargeButton{{ $menu->id }}">
                                            @foreach ($menu->children as $submenu)
                                                <li>
                                                    <a href="{{ $submenu->page ? route('page.show', $submenu->page->slug) : $submenu->url }}"
                                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                        {{ $submenu->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <!-- Menu sans sous-menus -->
                                    <a href="{{ $menu->page ? route('page.show', $menu->page->slug) : $menu->url }}"
                                        class="block py-2 px-3 font-bold text-gray-800 hover:text-primary md:hover:bg-transparent md:border-0 md:hover:text-blue-700   dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                                        {{ $menu->name }}
                                    </a>
                                @endif
                            </li>
                        @endforeach
                        <li>
                            <a href="{{ route('properties.index') }}"
                                class="block py-2 px-3  rounded font-bold text-gray-800 hover:text-primary md:hover:bg-transparent md:border-0 md:hover:text-blue-700  dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Louer/Acheter</a>
                        </li>
                        <li>
                            <a href="{{ route('promotions.index') }}"
                                class="block py-2 px-3  rounded font-bold text-gray-800 hover:text-primary md:hover:bg-transparent md:border-0 md:hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Promotions
                                immobilières</a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}"
                                class="block py-2 px-3  rounded font-bold text-gray-800 hover:text-primary md:hover:bg-transparent md:border-0 md:hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Contact</a>
                        </li>
                        <li>
                            <a href="https://regie-immobiliere-mugnier.crypto-extranet.com/connexion/" target="_blank"
                                class="bg-primary text-white inline-block py-2 px-3 rounded font-bold hover:text-white hover:bg-gray-700 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Extranet</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <button id="hamburger" data-collapse-toggle="navbar-multi-level" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded md:hidden hover:text-primary focus:outline-none focus:ring-0 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-multi-level" aria-expanded="false">
                <i class="fa fa-bars text-2xl"></i>
            </button>

        </div>
        <!-- Mobile Menu -->
        <nav id="mobile-menu" class="hidden md:hidden bg-secondary text-white mt-5 pb-4 space-y-2">
            @foreach ($menus as $menu)
                <li class="list-none">
                    @if ($menu->children->count() > 0)
                        <!-- Menu avec sous-menus -->
                        <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar{{ $menu->id }}"
                            class="flex items-center justify-between w-full py-2  font-bold text-gray-800 hover:text-primary md:hover:bg-transparent md:border-0 md:hover:text-primary  dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:hover:bg-gray-700 md:dark:hover:bg-transparent">
                            {{ $menu->name }}
                        </button>

                        <!-- Dropdown menu -->
                        <div id="sub-menu" class="hidden w-full dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-2  text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownLargeButton{{ $menu->id }}">
                                @foreach ($menu->children as $submenu)
                                    <li class="list-none">
                                        <a href="{{ $submenu->page ? route('page.show', $submenu->page->slug) : $submenu->url }}"
                                            class="block py-2 hover:text-primary dark:hover:bg-gray-600 dark:hover:text-white">
                                            {{ $submenu->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <!-- Menu sans sous-menus -->
                        <a href="{{ $menu->page ? route('page.show', $menu->page->slug) : $menu->url }}"
                            class="block py-2 font-bold text-gray-800 hover:text-primary md:hover:bg-transparent md:border-0 md:hover:text-blue-700   dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                            {{ $menu->name }}
                        </a>
                    @endif
                </li>
            @endforeach
            <li class="list-none">
                <a href="{{ route('properties.index') }}"
                    class="block text-gray-800 font-bold py-2 hover:text-primary">Louer/Acheter</a>
            </li>
            <li class="list-none">
                <a href="{{ route('promotions.index') }}"
                    class="block py-2 font-bold text-gray-800 hover:text-primary md:hover:bg-transparent md:border-0 md:hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Promotions
                    immobilières</a>
            </li>
            <li class="list-none">
                <a href="{{ route('contact') }}"
                    class="block py-2    font-bold text-gray-800 hover:text-primary md:hover:bg-transparent md:border-0 md:hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Contact</a>
            </li>
            <li class="list-none">
                <a href="https://regie-immobiliere-mugnier.crypto-extranet.com/connexion/" target="_blank"
                    class="bg-primary text-white inline-block py-2 px-3 rounded font-bold hover:text-white hover:bg-gray-700 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Extranet</a>
            </li>
        </nav>
    </header>
    <main class="mx-auto min-h-96" id="app">
        {{ $slot }}
    </main>

    <x-footer></x-footer>

    <script>
        //Hamburger menu
        document.querySelector('#hamburger').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
        //Mobile menu drompdown
        document.querySelector('#dropdownNavbarLink').addEventListener('click', function() {
            const submenu = document.getElementById('sub-menu');
            submenu.classList.toggle('hidden')
        })
        //button scroll to top
        var toTopButton = document.getElementById("to-top-button");
        if (toTopButton) {
            window.onscroll = function() {
                if (document.body.scrollTop > 500 || document.documentElement.scrollTop > 500) {
                    toTopButton.classList.remove("hidden");
                } else {
                    toTopButton.classList.add("hidden");
                }
            };
            window.goToTop = function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            };
        }
    </script>
    @yield('scripts')
</body>

</html>
