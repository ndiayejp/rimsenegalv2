<x-adminlayout>
    @section('title', 'Mettre à jour un article')
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-7xl lg:py-16">

            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white border-b border-3 border-gray-600">
                    @if ($post->exists)
                        Modifier un article
                    @else
                        Ajouter un article
                    @endif
                </h2>
                <a href="{{ route('admin.posts.index') }}"
                    class="flex gap-1 items-center justify-center uppercase text-white bg-primary hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                    <i class="fas fa-file-alt"></i> liste des articles
                </a>
            </div>

            <form action="{{ route($post->exists ? 'admin.posts.update' : 'admin.posts.store', $post) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method($post->exists ? 'PUT' : 'POST')
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
                                        'value' => $post->name,
                                        'placeholder' => 'Titre de l\'article',
                                    ])
                                </div>
                                <div class="sm:col-span-2">
                                    @include('shared.input', [
                                        'label' => 'Categories',
                                        'name' => 'category_id',
                                        'type' => 'select',
                                        'value' => $selectedValue,
                                        'options' => $categories,
                                    ])
                                </div>

                                <div class="sm:col-span-2">
                                    @include('shared.input', [
                                        'label' => 'Description',
                                        'type' => 'textarea',
                                        'dataId' => $post->id,
                                        'dataType' => get_class($post),
                                        'dataUrl' => route('admin.attachments.store'),
                                        'name' => 'content',
                                        'value' => $post->content,
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 w-full  space-y-6 sm:mt-8 lg:mt-0 lg:max-w-xs xl:max-w-md">
                        <div class="sm:col-span-2">
                            @include('shared.input', [
                                'label' => 'Date de création',
                                'name' => 'created_at',
                                'class' => 'p-2.5',
                                'type' => 'date',
                                'value' => $formattedDate,
                            ])
                        </div>
                        <div
                            class="space-y-4 rounded border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                            @include('shared.input', [
                                'label' => 'Image a la une ( PNG, JPG)',
                                'name' => 'thumb',
                                'type' => 'file',
                            ])
                            @if ($post->getMedia()->count() > 0)
                                <div class="flex justify-center">
                                    <img src="{{ $post->getFirstMediaUrl('default', 'preview') }}"
                                        class="w-64 border p-1.5 rounded">
                                </div>
                            @endif
                            <div class="flex items-center mb-4 p-2 border border-gray-200 rounded">
                                @include('shared.checkbox', [
                                    'label' => 'Publier',
                                    'name' => 'status',
                                    'value' => $post->status,
                                ])
                            </div>
                            <div class="flex justify-end items-center">
                                <button
                                    class="inline-flex items-center w-full px-5 py-2.5 text-sm font-medium text-center text-white bg-primary hover:bg-gray-800 hover:text-white rounded focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                                    @if ($post->exists)
                                        Enregistrer
                                    @else
                                        Sauvegarder
                                    @endif
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    @if ($editor == 'trumbowyg')
        @section('script-css')
            <link rel="stylesheet" href="{{ asset('js/trumbowyg/ui/trumbowyg.min.css') }}">
        @endsection
        @section('script-js')
            <script src="{{ asset('js/jquery.min.js') }}"></script>
            <script src="{{ asset('js/trumbowyg/trumbowyg.min.js') }}"></script>
            <script src="{{ asset('js/trumbowyg/plugins/upload/trumbowyg.upload.min.js') }}"></script>
            <script src="{{ asset('js/editor.js') }}"></script>
        @endsection
    @endif
</x-adminlayout>
