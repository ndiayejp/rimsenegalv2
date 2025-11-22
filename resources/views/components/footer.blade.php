<footer class="bg-gray-900 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5" style="background-image: url('{{ asset('images/pattern-img.png') }}');"></div>

    <div class="relative z-10">
        <!-- Section principale -->
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">

                <!-- Colonne 1: Logo et Description -->
                <div class="lg:col-span-1">
                    <a href="/" class="inline-block mb-6">
                        <img src="{{ asset('images/logo.png') }}" class="h-16 w-auto" alt="RIM Sénégal" />
                    </a>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6">
                        Votre partenaire de confiance pour tous vos projets immobiliers au Sénégal depuis plus de 20 ans.
                    </p>

                    <!-- Certification ISO -->
                    <div class="inline-block">
                        <img src="{{ asset('images/veritas.jpg') }}"
                             class="h-16 w-auto opacity-80 hover:opacity-100 transition-opacity"
                             alt="Certification ISO 9001" />
                    </div>
                </div>

                <!-- Colonne 2: Navigation -->
                <div>
                    <h3 class="text-white font-bold text-base mb-4 uppercase tracking-wide">Navigation</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="/" class="text-gray-400 hover:text-primary transition-colors duration-200 text-sm flex items-center group">
                                <span class="mr-2 opacity-0 group-hover:opacity-100 transition-opacity">›</span>
                                Accueil
                            </a>
                        </li>
                        <li>
                            <a href="/biens" class="text-gray-400 hover:text-primary transition-colors duration-200 text-sm flex items-center group">
                                <span class="mr-2 opacity-0 group-hover:opacity-100 transition-opacity">›</span>
                                Nos biens
                            </a>
                        </li>
                        <li>
                            <a href="/pages/qui-sommes-nous" class="text-gray-400 hover:text-primary transition-colors duration-200 text-sm flex items-center group">
                                <span class="mr-2 opacity-0 group-hover:opacity-100 transition-opacity">›</span>
                                Qui sommes-nous
                            </a>
                        </li>
                        <li>
                            <a href="/blog" class="text-gray-400 hover:text-primary transition-colors duration-200 text-sm flex items-center group">
                                <span class="mr-2 opacity-0 group-hover:opacity-100 transition-opacity">›</span>
                                Actualités
                            </a>
                        </li>
                        <li>
                            <a href="/contact" class="text-gray-400 hover:text-primary transition-colors duration-200 text-sm flex items-center group">
                                <span class="mr-2 opacity-0 group-hover:opacity-100 transition-opacity">›</span>
                                Contact
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Colonne 3: Services -->
                <div>
                    <h3 class="text-white font-bold text-base mb-4 uppercase tracking-wide">Nos Services</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="/pages/nos-services" class="text-gray-400 hover:text-primary transition-colors duration-200 text-sm flex items-center group">
                                <span class="mr-2 opacity-0 group-hover:opacity-100 transition-opacity">›</span>
                                Vente immobilière
                            </a>
                        </li>
                        <li>
                            <a href="/pages/nos-services" class="text-gray-400 hover:text-primary transition-colors duration-200 text-sm flex items-center group">
                                <span class="mr-2 opacity-0 group-hover:opacity-100 transition-opacity">›</span>
                                Location
                            </a>
                        </li>
                        <li>
                            <a href="/pages/nos-services" class="text-gray-400 hover:text-primary transition-colors duration-200 text-sm flex items-center group">
                                <span class="mr-2 opacity-0 group-hover:opacity-100 transition-opacity">›</span>
                                Gestion locative
                            </a>
                        </li>
                        <li>
                            <a href="/pages/nos-services" class="text-gray-400 hover:text-primary transition-colors duration-200 text-sm flex items-center group">
                                <span class="mr-2 opacity-0 group-hover:opacity-100 transition-opacity">›</span>
                                Estimation gratuite
                            </a>
                        </li>
                        <li>
                            <a href="/pages/nous-rejoindre" class="text-gray-400 hover:text-primary transition-colors duration-200 text-sm flex items-center group">
                                <span class="mr-2 opacity-0 group-hover:opacity-100 transition-opacity">›</span>
                                Carrières
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Colonne 4: Contact & Réseaux sociaux -->
                <div>
                    <h3 class="text-white font-bold text-base mb-4 uppercase tracking-wide">Nous Contacter</h3>
                    <ul class="space-y-3 mb-6">
                        <li class="text-gray-400 text-sm flex items-start">
                            <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Dakar, Sénégal</span>
                        </li>

                        <li class="text-gray-400 text-sm flex items-start">
                            <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <a href="tel:+221..." class="hover:text-primary transition-colors">+221776548731 / +221783724807</a>
                        </li>
                    </ul>

                    <!-- Réseaux sociaux -->
                    <div>
                        <h4 class="text-white font-semibold text-sm mb-3">Suivez-nous</h4>
                        <div class="flex space-x-3">
                            <a href="https://www.facebook.com/rim.immo/?locale=fr_FR"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white transition-all duration-300 transform hover:scale-110">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="https://www.instagram.com/rim.immo/"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white transition-all duration-300 transform hover:scale-110">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barre de séparation -->
        <div class="border-t border-gray-800"></div>

        <!-- Section inférieure -->
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="md:flex md:items-center md:justify-between">
                <div class="text-center md:text-left mb-4 md:mb-0">
                    <p class="text-gray-400 text-sm">
                        © 2024 <a href="/" class="text-primary hover:text-secondary transition-colors font-semibold">RIM Sénégal</a>.
                        Tous droits réservés.
                    </p>
                </div>
                <div class="flex flex-wrap justify-center md:justify-end gap-4 text-sm">
                    <a href="/pages/informations-legales" class="text-gray-400 hover:text-primary transition-colors">
                        Mentions légales
                    </a>
                    <span class="text-gray-600">•</span>
                    <a href="/pages/politique-de-protection-des-donnees" class="text-gray-400 hover:text-primary transition-colors">
                        Politique de confidentialité
                    </a>
                    <span class="text-gray-600">•</span>
                    <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                        Cookies
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bouton retour en haut -->
    <button id="to-top-button"
            onclick="goToTop()"
            title="Retour en haut"
            class="hidden fixed z-50 bottom-8 right-8 p-3 w-12 h-12 rounded-full shadow-xl bg-primary hover:bg-secondary text-white transition-all duration-300 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
        <span class="sr-only">Retour en haut</span>
    </button>
</footer>
