<x-adminlayout>
    <!-- Start block -->
    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                @include('shared.flash')
                <div
                    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/2 ">
                        <h3 class="text-gray-600 font-bold"> Liste des promotions</h3>
                    </div>
                    <div
                        class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <a href="{{ route('admin.promotions.create') }}"
                            class="flex gap-1 items-center justify-center text-white bg-primary hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                            <i class="fas fa-plus"></i> Ajouter une promotion
                        </a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Titre</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse  ($promotions as $promotion)
                                <tr class="border-b dark:border-gray-700">
                                    <th scope="row"
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $promotion->title }}</th>
                                    <td class="px-4 py-3 flex items-center justify-end">
                                        <button id="promotion-{{ $promotion->id }}-dropdown-button"
                                            data-dropdown-toggle="promotion-{{ $promotion->id }}-dropdown"
                                            class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                                            type="button">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                        <div id="promotion-{{ $promotion->id }}-dropdown"
                                            class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                            <ul class="py-1 text-sm">
                                                <li>
                                                    <a href="{{ route('admin.promotions.edit', $promotion) }}"
                                                        class="flex gap-1 w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                                        <i class="fas fa-pencil"></i>
                                                        Editer
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        onclick="event.preventDefault(); document.getElementById('del-promotion-{{ $promotion->id }}').submit()"
                                                        class="flex
                                                        gap-1 w-full items-center py-2 px-4 hover:bg-gray-100
                                                        dark:hover:bg-gray-600 text-red-500 dark:hover:text-red-400">
                                                        <i class="fas fa-trash"></i>
                                                        Supprimer
                                                        <form
                                                            action="{{ route('admin.promotions.destroy', $promotion) }}"
                                                            style="display:none" method="POST"
                                                            id="del-promotion-{{ $promotion->id }}">
                                                            @csrf
                                                            @method('delete')
                                                        </form>
                                                    </a>

                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3 flex items-center justify-center">
                                        <p>Pas de données disponibles</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                    aria-label="Table navigation">
                    <div>&nbsp;</div>
                    {{ $promotions->links() }}
                </nav>
            </div>
        </div>
    </section>
    <!-- End block -->

</x-adminlayout>
