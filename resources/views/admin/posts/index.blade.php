<x-adminlayout>
    @section('title', 'Liste des articles')
    <!-- Start block -->
    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                @include('shared.flash')
                <div
                    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/2">
                        &nbsp;
                    </div>
                    <div
                        class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <a href="{{ route('admin.posts.create') }}"
                            class="flex gap-1 items-center justify-center uppercase text-white bg-primary hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                            <i class="fas fa-plus"></i> Ajouter un article
                        </a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-4">Article</th>
                                <th scope="col" class="px-4 py-3">Categorie</th>
                                <th scope="col" class="px-4 py-3">Date de publication</th>
                                <th scope="col" class="px-4 py-3">Statut</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr class="border-b dark:border-gray-700">
                                    <th scope="row"
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $post->name }}</th>
                                    <td class="px-4 py-3">{{ $post->category->name }}</td>
                                    <td class="px-4 py-3 max-w-[12rem] truncate">
                                        {{ $post->created_at->format('d-m-Y') }}</td>
                                    <td class="px-4 py-3">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" value="" class="sr-only peer" checked disabled>
                                            <div
                                                class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 {{ $post->status === 1 ? 'peer-checked:bg-green-600' : 'peer-checked:bg-gray-300' }}">
                                            </div>
                                        </label>
                                    </td>
                                    <td class="px-4 py-3 flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.posts.edit', $post) }}"
                                            class="flex gap-1 rounded border items-center py-2 px-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                            <i class="fas fa-pencil"></i>

                                        </a>
                                        <a href="#"
                                            onclick="event.preventDefault(); document.getElementById('del-post-{{ $post->id }}').submit()"
                                            class="rounded flex
                                                        gap-1 items-center py-2 px-2 hover:bg-red-800
                                                        dark:hover:bg-gray-600 bg-red-500 text-white dark:hover:text-red-400">
                                            <i class="fas fa-trash"></i>

                                            <form action="{{ route('admin.posts.destroy', $post) }}"
                                                style="display:none" method="POST" id="del-post-{{ $post->id }}">

                                                @csrf
                                                @method('delete')
                                            </form>
                                        </a>



                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                    aria-label="Table navigation">
                    <div>&nbsp;</div>
                    {{ $posts->links() }}
                </nav>
            </div>
        </div>
    </section>
    <!-- End block -->

</x-adminlayout>
