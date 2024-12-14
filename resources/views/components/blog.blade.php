<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-7xl lg:py-16 lg:px-6">
        <x-section-heading>
            <x-slot:title>Actualités</x-slot:title>
            Actualités & évènements
        </x-section-heading>
        <div class="grid gap-8 lg:grid-cols-4">
            @forelse ($posts as $post)
                <x-post-card :post="$post"></x-post-card>
            @empty
                <div class="flex items-center justify-center text-gray-600">Aucune donnée disponible </div>
            @endforelse
        </div>
        <div class="flex justify-end pt-8">
            <a href="/articles"
                class="bg-secondary hover:bg-primary hover:text-white flex items-center gap-2 text-gray-800 rounded px-3 py-2.5 font-semibold">Voir
                tous nos articles <i class="fas fa-arrow-right-long"></i></a>
        </div>
    </div>
</section>
