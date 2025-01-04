<footer class="p-4   sm:p-6 dark:bg-gray-800 relative bg-gray-800">
    <div class="absolute bg-center bg-no-repeat top-0 left-0  h-72 w-full z-0"
        style="background-image: url('{{ asset('images/pattern-img.png') }}');opacity:0.06"></div>
    <div class="mx-auto max-w-screen-2xl relative z-10 py-8 px-4 lg:py-3 lg:px-6">
        <div class="md:flex md:justify-between">
            <div class="mb-6 md:mb-0">
                <a href="#" class="flex items-center justify-center md:justify-start lg:justify-center">
                    <img src="{{ asset('images/logo.png') }}" class="w-20" />
                </a>
                <h3 class="my-4 font-bold text-xl">Nous suivre sur les réseaux sociaux</h3>
                <div class="flex space-x-6 justify-center">
                    <a href="#" class="text-gray-200 hover:text-secondary dark:hover:text-white">
                        <i class="fa-brands fa-square-facebook fa-2x"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-secondary dark:hover:text-white">
                        <i class="fa-brands fa-instagram fa-2x"></i>
                    </a>

                </div>
            </div>
            <div class="grid grid-cols-2 gap-8 sm:gap-8 sm:grid-cols-3">
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-primary uppercase dark:text-white">A découvrir</h2>
                    <ul class="text-gray-200 dark:text-gray-400">
                        <li class="mb-4">
                            <a href="#" class="hover:underline hover:text-secondary">Nos conseils</a>
                        </li>
                        <li>
                            <a href="{{ route('blog.index') }}" class="hover:underline hover:text-secondary">Nos
                                actualités</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-primary uppercase dark:text-gray-600">À propos de la RIM
                    </h2>
                    <ul class="text-gray-200 dark:text-gray-400">
                        <li class="mb-4">
                            <a href="{{ route('contact') }}" class="hover:underline hover:text-secondary">Nos
                                agences</a>
                        </li>
                        <li class="mb-4">
                            <a href="/pages/qui-sommes-nous" class="hover:underline hover:text-secondary">Qui
                                sommes-nous</a>
                        </li>
                        <li class="mb-4">
                            <a href="/pages/nous-rejoindre" class="hover:underline hover:text-secondary">Offres
                                d’emploi</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-primary uppercase dark:text-white">Confidentialité</h2>
                    <ul class="text-gray-200 dark:text-gray-400">
                        <li class="mb-4">
                            <a href="/pages/informations-legales"
                                class="hover:underline hover:text-secondary">Informations légales</a>
                        </li>
                        <li>
                            <a href="/pages/politique-de-protection-des-donnees"
                                class="hover:underline hover:text-secondary">Politique de protection des
                                données</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
        <hr class="my-6 border-gray-700 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <div class="sm:flex sm:items-center sm:justify-center">
            <span class="text-sm text-gray-200 sm:text-center dark:text-gray-400">© 2024 <a href="/"
                    class="hover:underline">Rimsénégal</a>. Tous droits réservés.
            </span>

        </div>
    </div>
    <!-- Back to top button -->
    <button id="to-top-button" onclick="goToTop()" title="Go To Top"
        class="hidden fixed z-50 bottom-10 right-10 p-4 border-0 w-14 h-14 rounded shadow-md bg-primary hover:bg-secondary text-white hover:text-primary text-lg font-semibold transition-colors duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
            <path d="M12 4l8 8h-6v8h-4v-8H4l8-8z" />
        </svg>
        <span class="sr-only">Go to top</span>
    </button>
</footer>
