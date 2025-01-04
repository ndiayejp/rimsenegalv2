<article
    class="group relative overflow-hidden rounded-xl bg-white shadow transition-all duration-300 hover:shadow-xl transform hover:-translate-y-1">
    @if ($post->getMedia()->count() > 0)
        <a href="{{ route('post.show', $post->getSlug()) }}" class="relative block overflow-hidden">
            <div
                class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 transition-opacity group-hover:opacity-100">
            </div>
            <img alt="" src="{{ $post->getFirstMediaUrl('default', 'preview') }}"
                class="h-64 w-full object-cover transition-transform duration-300 group-hover:scale-105"
                style="aspect-ratio: 16/9" />
            <div
                class="absolute bottom-4 right-4 flex h-10 w-10 items-center justify-center rounded-full bg-white/90 opacity-0 shadow-lg transition-opacity group-hover:opacity-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </div>
        </a>
    @endif

    <div class="relative p-6">
        <div class="flex items-center gap-2 text-xs text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
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

        <a href="{{ route('post.show', $post->getSlug()) }}" class="mt-4 block">
            <h3
                class="text-xl font-bold tracking-tight text-gray-900 decoration-primary decoration-2 group-hover:underline">
                {{ Str::limit($post->name, 28) }}
            </h3>
            <div class="mt-3 line-clamp-3 text-sm leading-relaxed text-gray-600">
                {!! Str::limit($post->content, 150) !!}
            </div>
        </a>

        <div class="mt-4 flex items-center justify-end">
            <a href="{{ route('post.show', $post->getSlug()) }}"
                class="text-sm font-medium text-primary transition-colors hover:text-primary/80">
                Lire la suite
            </a>
        </div>
    </div>
</article>
