<x-adminlayout>
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-7xl lg:py-16">

            <div class="flex items-center justify-between">
                <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">
                    @if ($agency->exists)
                        Modifier une agence
                    @else
                        Ajouter une agence
                    @endif
                </h2>
                <a href="{{ route('admin.agencies.index') }}"
                    class="flex gap-1 items-center justify-center uppercase text-white bg-primary hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                    <i class="fas fa-file-alt"></i> liste des agences
                </a>
            </div>
            <form action="{{ route($agency->exists ? 'admin.agencies.update' : 'admin.agencies.store', $agency) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method($agency->exists ? 'PUT' : 'POST')
                <div class="mt-6 sm:mt-8 gap-8 lg:flex lg:items-start lg:gap-5 xl:gap-8">
                    <div class="w-full space-y-8">
                        <div
                            class="space-y-4 rounded border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                                <div class="sm:col-span-2">
                                    <div class="mb-3">
                                        @include('shared.input', [
                                            'label' => 'Titre',
                                            'name' => 'name',
                                            'class' => 'p-2.5',
                                            'value' => $agency->name,
                                            'placeholder' => 'Nom',
                                        ])
                                    </div>
                                    <div class="mb-3">
                                        @include('shared.input', [
                                            'label' => 'Adresse',
                                            'name' => 'address',
                                            'class' => 'p-2.5',
                                            'value' => $agency->address,
                                            'placeholder' => 'Ex: Point E - Dakar...',
                                        ])
                                    </div>
                                    <div class="mb-3">
                                        @include('shared.input', [
                                            'label' => 'Téléphone',
                                            'name' => 'phone',
                                            'class' => 'p-2.5',
                                            'value' => $agency->phone,
                                            'placeholder' => 'Ex: +221 33 856 47 15',
                                        ])
                                    </div>
                                    <div class="flex justify-end items-center">
                                        <button
                                            class="inline-flex items-center px-5 py-2.5  sm:mt-6 text-sm font-medium text-center text-white bg-primary hover:bg-gray-800 hover:text-white rounded focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                                            @if ($agency->exists)
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
