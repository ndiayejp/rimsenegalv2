<x-adminlayout>
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-7xl lg:py-16">

            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white border-b border-3 border-gray-600">
                    @if ($page->exists)
                        Modifier une page
                    @else
                        Ajouter une page
                    @endif
                </h2>
                <a href="{{ route('admin.pages.index') }}"
                    class="flex gap-1 items-center justify-center text-white bg-primary hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                    <i class="fas fa-file-alt"></i> liste des pages
                </a>
            </div>
            <form action="{{ route($page->exists ? 'admin.pages.update' : 'admin.pages.store', $page) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method($page->exists ? 'PUT' : 'POST')
                <div class="mt-6 sm:mt-8 gap-8 lg:flex lg:items-start lg:gap-5 xl:gap-8">
                    <div class="w-full space-y-8">
                        <div
                            class="space-y-4 rounded border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                                <div class="sm:col-span-2">
                                    @include('shared.input', [
                                        'label' => 'Titre',
                                        'name' => 'title',
                                        'class' => 'p-2.5',
                                        'value' => $page->title,
                                        'placeholder' => 'Titre',
                                    ])
                                </div>
                                <div class="sm:col-span-2">
                                    @include('shared.input', [
                                        'label' => 'Description',
                                        'type' => 'textarea',
                                        'dataId' => $page->id,
                                        'dataType' => get_class($page),
                                        'dataUrl' => route('admin.attachments.store'),
                                        'name' => 'content',
                                        'value' => $page->content,
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 w-full  space-y-6 sm:mt-8 lg:mt-0 lg:max-w-xs xl:max-w-md">
                        <div
                            class="space-y-4 rounded border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">

                            <div class="flex items-center mb-4 p-2 border border-gray-200 rounded">
                                @include('shared.checkbox', [
                                    'label' => 'Publier',
                                    'name' => 'status',
                                    'value' => $page->status,
                                ])
                            </div>
                            <div class="flex justify-end items-center">
                                <button
                                    class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary hover:bg-gray-800 hover:text-white rounded focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                                    @if ($page->exists)
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
