<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-screen-2xl lg:py-16 lg:px-6">
        <x-section-heading>
            <x-slot:title>Actualités</x-slot:title>
            Les dernières nouvelles du monde immobilier
        </x-section-heading>
        <div class="grid gap-8 lg:grid-cols-4 md:grid-cols-2">
            @forelse ($posts as $post)
                <x-post-card :post="$post"></x-post-card>
            @empty
                <div class="flex items-center justify-center text-gray-600">Aucune donnée disponible </div>
            @endforelse
        </div>
        <div class="flex justify-end pt-4">
            <a href="{{ route('blog.index') }}"
                class="group bg-secondary hover:bg-primary hover:text-white flex items-center gap-2 text-gray-800 rounded-lg px-3 py-2.5 font-semibold">Voir
                tous nos articles <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg></a>
        </div>
    </div>
</section>
