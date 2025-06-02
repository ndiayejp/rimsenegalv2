<section class="relative isolate overflow-hidden">
    <div class="absolute inset-0 -z-10">
        <img src="../images/featured.jpg" alt="Luxury real estate"
            class="h-full w-full object-cover object-center bg-gray-700" loading="eager">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/80 to-black/40"></div>
    </div>
    <!-- Contenu principal -->
    <div class="px-6 mx-auto max-w-7xl text-center py-32 lg:py-44 relative">
        <!-- Marquage prestige -->
        <div class="absolute top-8 left-1/2 -translate-x-1/2">
            <span class="text-xs tracking-[0.3em] text-white/70 font-light">RÉGIE IMMOBILIÈRE MUGNIER</span>
            <div class="w-16 h-px bg-secondary mx-auto mt-2"></div>
        </div>

        <h1
            class="text-5xl/none font-medium tracking-tight text-white sm:text-6xl/none lg:text-7xl/none font-serif animate-fade-in-up">
            Excellence immobilière <span class="text-secondary">depuis 1956</span>
        </h1>

        <p class="mt-8 max-w-2xl mx-auto text-lg leading-8 text-white/90 font-light animate-fade-in-up delay-100">
            Plus d'un demi-siècle d'expertise au service d'une clientèle exigeante.
        </p>

        <div class="mt-12 flex flex-col sm:flex-row justify-center gap-6 animate-fade-in-up delay-200">
            <a href="/pages/qui-sommes-nous"
                class="group relative overflow-hidden px-8 py-4 font-medium text-white border border-white/20 rounded-full hover:border-secondary/50 transition-all duration-500 hover:bg-secondary/10">
                <span class="relative z-10 flex items-center gap-2">
                    Notre histoire
                    <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </span>
            </a>

            <a href="/nos-biens"
                class="group relative overflow-hidden px-8 py-4 font-medium text-white hover:text-gray-900 bg-primary rounded-full hover:bg-secondary/90 transition-all duration-500">
                <span class="relative z-10 flex items-center gap-2">
                    Nos biens
                    <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </span>
            </a>
        </div>
    </div>

    <!-- Section statistiques -->
    <div class="relative bg-gradient-to-b from-transparent to-black/80 pb-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div
                class="grid grid-cols-1 gap-px bg-white/5 sm:grid-cols-2 lg:grid-cols-4 rounded-2xl overflow-hidden border border-white/10 backdrop-blur-md">
                <!-- Stat 1 -->
                <div
                    class="bg-gradient-to-b from-white/5 to-transparent p-8 sm:p-10 group hover:bg-white/5 transition-all duration-300">
                    <div class="flex flex-col items-center text-center">
                        <dt class="text-5xl font-serif font-medium text-secondary animate-count-up" data-target="800"
                            data-symbol="+">0</dt>
                        <dd class="mt-4 text-lg font-light text-white/90 tracking-wide">Locataires accompagnés</dd>
                    </div>
                </div>

                <!-- Stat 2 -->
                <div
                    class="bg-gradient-to-b from-white/5 to-transparent p-8 sm:p-10 group hover:bg-white/5 transition-all duration-300">
                    <div class="flex flex-col items-center text-center">
                        <dt class="text-5xl font-serif font-medium text-secondary animate-count-up" data-target="200"
                            data-symbol="+">0</dt>
                        <dd class="mt-4 text-lg font-light text-white/90 tracking-wide">Propriétaires fidèles</dd>
                    </div>
                </div>

                <!-- Stat 3 -->
                <div
                    class="bg-gradient-to-b from-white/5 to-transparent p-8 sm:p-10 group hover:bg-white/5 transition-all duration-300">
                    <div class="flex flex-col items-center text-center">
                        <dt class="text-5xl font-serif font-medium text-secondary animate-count-up" data-target="1000"
                            data-symbol="+">0</dt>
                        <dd class="mt-4 text-lg font-light text-white/90 tracking-wide">Lots gérés</dd>
                    </div>
                </div>

                <!-- Stat 4 -->
                <div
                    class="bg-gradient-to-b from-white/5 to-transparent p-8 sm:p-10 group hover:bg-white/5 transition-all duration-300">
                    <div class="flex flex-col items-center text-center">
                        <dt class="text-5xl font-serif font-medium text-secondary animate-count-up" data-target="20"
                            data-symbol="+">0</dt>
                        <dd class="mt-4 text-lg font-light text-white/90 tracking-wide">Copropriétés</dd>
                    </div>
                </div>
            </div>

            <div class="mt-16 text-center">
                <p class="text-3xl font-light text-white/90 tracking-wide">
                    <span class="text-secondary font-medium">18 experts</span> à votre service
                </p>
            </div>
        </div>
    </div>
</section>

@section('styles')
    <style>
        @keyframes fade-in-up {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes count-up {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 1s ease-out forwards;
        }

        .animate-fade-in-up.delay-100 {
            animation-delay: 0.1s;
        }

        .animate-count-up {
            animation: count-up 1s ease-out forwards;
        }
    </style>
@endsection
@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const counters = document.querySelectorAll('.animate-count-up');

            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                const symbol = counter.getAttribute('data-symbol') || '';
                const duration = 2000;
                const increment = target / (duration / 16);

                let current = 0;

                const updateCounter = () => {
                    current += increment;
                    if (current < target) {
                        counter.textContent = Math.ceil(current) + symbol;

                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target + symbol;
                    }
                };

                updateCounter();
            });
        });
    </script>
@endsection
