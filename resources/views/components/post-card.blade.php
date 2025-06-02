<article
    class="group relative overflow-hidden rounded-xl bg-white shadow-sm transition-all duration-500 hover:shadow-lg hover:-translate-y-1.5">
    <!-- Conteneur image avec effet de zoom et overlay coloré -->
    @if ($post->getMedia()->count() > 0)
        <a href="{{ route('post.show', $post->getSlug()) }}" class="relative block overflow-hidden">
            <div class="relative aspect-w-16 aspect-h-9">
                <img alt="{{ $post->name }}" src="{{ $post->getFirstMediaUrl('default', 'preview') }}"
                    class="h-64 w-full object-cover transition-transform duration-700 group-hover:scale-110"
                    style="aspect-ratio: 16/9" />
                <div
                    class="absolute inset-0 bg-gradient-to-t from-primary/80 via-primary/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                </div>
                <div
                    class="absolute bottom-2 left-0 p-4 translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                    @if ($post->category)
                        <span
                            class="inline-block px-2 py-1 bg-gray-900 text-white text-xs font-medium rounded-full opacity-90">
                            {{ $post->category->name }}
                        </span>
                    @endif
                </div>
            </div>
        </a>
    @endif

    <!-- Contenu texte -->
    <div class="p-6 relative">
        <!-- Date avec icône intégrée -->
        <div class="flex items-center gap-2 text-xs font-medium text-gray-500 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                <line x1="16" y1="2" x2="16" y2="6" />
                <line x1="8" y1="2" x2="8" y2="6" />
                <line x1="3" y1="10" x2="21" y2="10" />
            </svg>
            <time datetime="{{ $post->created_at->toISOString() }}">
                {{ $post->created_at->diffForHumans() }}
            </time>
        </div>


        <a href="{{ route('post.show', $post->getSlug()) }}" class="block mb-3">
            <h3
                class="text-xl font-bold text-gray-900 transition-colors duration-300 group-hover:text-primary line-clamp-2">
                {{ $post->name }}
            </h3>
        </a>

        <!-- Extrait (optionnel) -->
        @if ($post->excerpt)
            <p class="text-gray-600 mb-4 line-clamp-2">
                {{ $post->excerpt }}
            </p>
        @endif


        <div class="mt-4">
            <a href="{{ route('post.show', $post->getSlug()) }}"
                class="inline-flex items-center text-primary font-semibold group-hover:text-secondary transition-colors duration-300">
                <span class="border-b border-transparent group-hover:border-secondary transition-all duration-300">Lire
                    la suite</span>
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-300"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </a>
        </div>



    </div>


    <div
        class="absolute inset-0 border-2 border-transparent group-hover:border-primary/30 transition-all duration-500 pointer-events-none rounded-xl">
    </div>
</article>
