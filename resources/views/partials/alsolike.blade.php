<h3 class="text-xl font-bold mb-5 text-gray-700">{{ __('Des articles qui pourraient vous intéresser') }}</h3>
<ul class="border border-gray-200 bg-white rounded-lg px-3 py-1.5 w-full">
    @foreach ($mightAlsoLike as $post)
        <li class="py-1.5">
            <a class="text-gray-600 text-sm font-semibold hover:text-primary truncate text-ellipsis block"
                href="{{ route('post.show', $post->getSlug()) }}">
                {{ $post->name }}
            </a>
        </li>
    @endforeach
</ul>
