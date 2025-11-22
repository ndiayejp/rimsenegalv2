<section class="relative overflow-hidden bg-white dark:bg-gray-900">
    <!-- Fond dynamique -->
    <div class="absolute inset-0 z-0">
        <!-- Animation fluide de vague colorée -->
        <div
            class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-primary/20 via-white/90 to-white dark:from-primary/30 dark:via-gray-900/90 dark:to-gray-900">
        </div>

        <!-- Éléments décoratifs dynamiques -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden">
            <div class="absolute w-80 h-80 rounded-full bg-secondary/10 -top-40 -left-40 animate-float-slow"></div>
            <div class="absolute w-64 h-64 rounded-full bg-primary/10 bottom-20 -right-32 animate-float-slow delay-1000">
            </div>
            <div
                class="absolute w-96 h-96 rounded-lg bg-secondary/5 -bottom-60 -left-60 rotate-45 animate-float-vertical">
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="relative z-10 max-w-screen-2xl mx-auto px-6  py-24 lg:py-32">
        <div class="flex flex-col lg:flex-row items-center gap-12">
            <!-- Partie texte -->
            <div class="lg:w-1/2">
                <div class="mb-8">
                    <span
                        class="inline-block px-4 py-1 bg-primary/10 text-primary rounded-full text-sm font-medium mb-4 animate-fade-in">
                        Carrières
                    </span>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                        <span class="relative">

                            Transformez
                            <br>
                            votre passion en carrière
                            <span class="absolute bottom-0 left-0 w-24 h-1 bg-secondary"></span>
                        </span>

                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
                        Rejoignez une équipe dynamique qui redéfinit l'excellence immobilière à Dakar depuis 1956.
                    </p>
                </div>

                <div class="space-y-6">
                    <!-- CTA principal -->
                    <div class="group">
                        <a href="{{ route('contact') }}"
                            class="inline-flex items-center justify-center gap-3 bg-gradient-to-r from-primary to-primary-dark hover:from-primary-dark hover:to-primary text-white font-semibold rounded-full px-8 py-4 transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                            <span>Postuler maintenant</span>
                            <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>

                    <!-- Points forts -->
                    <div class="flex flex-wrap gap-4">
                        <div
                            class="flex items-center bg-white dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-full px-4 py-2 shadow-xs">
                            <div class="w-6 h-6 rounded-full bg-secondary/10 flex items-center justify-center mr-2">
                                <svg class="w-3 h-3 text-secondary" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Formation continue</span>
                        </div>
                        <div
                            class="flex items-center bg-white dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-full px-4 py-2 shadow-xs">
                            <div class="w-6 h-6 rounded-full bg-secondary/10 flex items-center justify-center mr-2">
                                <svg class="w-3 h-3 text-secondary" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Équipe soudée</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Illustration moderne -->
            <div class="lg:w-1/2 relative">
                <div class="relative">
                    <!-- Cadre photo avec effet 3D -->
                    <div
                        class="relative z-10 w-full h-full rounded-2xl overflow-hidden shadow-2xl border-8 border-white dark:border-gray-800 rotate-3">
                        <img src="{{ url('images/work.jpeg') }}"
                            alt="Équipe immobilière"
                            class="w-full h-auto object-cover transition-transform duration-500 hover:scale-105">
                    </div>

                    <!-- Élément décoratif -->
                    <div
                        class="absolute -bottom-6 -right-6 w-32 h-32 bg-secondary rounded-lg rotate-12 animate-float-slow">
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>
@section('styles')
    <!-- Custom CSS for Animations -->
    <style>
        @keyframes float-slow {

            0%,
            100% {
                transform: translateY(0) translateX(0);
            }

            50% {
                transform: translateY(-20px) translateX(10px);
            }
        }

        @keyframes float-vertical {

            0%,
            100% {
                transform: translateY(0) rotate(45deg);
            }

            50% {
                transform: translateY(-30px) rotate(45deg);
            }
        }

        .animate-float-slow {
            animation: float-slow 8s ease-in-out infinite;
        }

        .animate-float-vertical {
            animation: float-vertical 6s ease-in-out infinite;
        }
    </style>
@endsection
