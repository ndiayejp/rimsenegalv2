<x-adminlayout>
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-7xl lg:py-16">

            <div class="flex items-center justify-between">
                <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">
                    @if ($category->exists)
                        Modifier une catégorie
                    @else
                        Ajouter une catégorie
                    @endif
                </h2>
                <a href="{{ route('admin.categories.index') }}"
                    class="flex gap-1 items-center justify-center uppercase text-white bg-primary hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                    <i class="fas fa-file-alt"></i> liste des catégories
                </a>
            </div>
            <form
                action="{{ route($category->exists ? 'admin.categories.update' : 'admin.categories.store', $category) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method($category->exists ? 'PUT' : 'POST')
                <div class="mt-6 sm:mt-8 gap-8 lg:flex lg:items-start lg:gap-5 xl:gap-8">
                    <div class="w-full space-y-8">
                        <div
                            class="space-y-4 rounded border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                                <div class="sm:col-span-2">
                                    @include('shared.input', [
                                        'label' => 'Titre',
                                        'name' => 'name',
                                        'class' => 'p-2.5',
                                        'value' => $category->name,
                                        'placeholder' => 'Titre',
                                    ])
                                    <div class="flex justify-end items-center">
                                        <button
                                            class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary hover:bg-gray-800 hover:text-white rounded focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                                            @if ($category->exists)
                                                Modifier
                                            @else
                                                Sauvegarder
                                            @endif
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </section>
</x-adminlayout>
