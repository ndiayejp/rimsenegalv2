<article class="overflow-hidden rounded-lg border transition hover:shadow-lg">
    @if ($post->getMedia()->count() > 0)
        <a href="{{ route('post.show', $post->getSlug()) }}" class="cursor-pointer">
            <img alt="" src="{{ $post->getFirstMediaUrl('default', 'preview') }}"
                class="h-56 w-full object-cover" />
        </a>
    @endif
    <div class="bg-white text-gray-600  p-4 sm:p-6">
        <time datetime="2022-10-10" class="block text-right text-xs ">
            {{ $post->created_at->diffForHumans() }} </time>

        <a href="{{ route('post.show', $post->getSlug()) }}" class="cursor-pointer text-gray-600">
            <h3 class="mt-0.5 text-lg font-bold">{{ Str::limit($post->name, 37) }}</h3>
        </a>

        <div class="mt-2   text-sm text-gray-600">
            {!! Str::limit($post->content, 65) !!}
        </div>
    </div>
</article>
