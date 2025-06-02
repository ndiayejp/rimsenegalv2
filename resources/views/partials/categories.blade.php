<h3 class="text-xl font-bold mb-5 text-gray-700">{{ __('Catégories') }}</h3>
<ul class="border border-gray-200 bg-white rounded-xl px-3 py-1.5 w-full">
    @foreach ($categories as $cat)
        @if ($cat->posts()->count() > 0)
            <li class="py-1.5">
                <a class="text-gray-600 text-sm font-semibold hover:text-primary"
                    href="{{ route('blog.index', ['category' => $cat->slug]) }}">
                    {{ $cat->name }}
                    <span>({{ $cat->posts()->count() }})</span>
                </a>
            </li>
        @endif
    @endforeach
</ul>
