<x-panel>
    <div class="flex justify-between items-center mb-5 text-gray-500 ">
        <span
            class="bg-primary text-white text-xs font-medium inline-flex justify-center gap-2 items-center p-1.5 rounded dark:bg-primary-200 dark:text-primary-800">
            {{ $post->category->name }}
        </span>
        <span class="text-sm">Publié : {{ $post->created_at->diffForHumans() }}</span>
    </div>
    <div class="grid grid-rows-subgrid ">
        <h2
            class="mb-2 text-xl font-bold group-hover:text-primary transition-colors duration-1000  text-gray-700 dark:text-white">
            <a href="{{ route('post.show', $post->getSlug()) }}">{{ Str::limit($post->name, 45) }}</a>
        </h2>
        <div class="mb-5 text-gray-500 dark:text-gray-400 grid grid-rows-[auto] subgrid">{!! Str::limit($post->content, 125) !!}</div>
        <div class="flex justify-end items-center">
            <a href="{{ route('post.show', $post->getSlug()) }}"
                class="inline-flex gap-2   group-hover:bg-secondary group-hover:border-primary border-primary rounded px-2 py-1.5 items-center font-medium text-primary dark:text-primary-500">
                Lire la suite
                <i class="fas fa-arrow-right-long"></i>
            </a>
        </div>
    </div>

</x-panel>
