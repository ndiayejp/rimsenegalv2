<x-adminlayout>
    @section('title', 'Mettre à jour une promotion')
    <section class="bg-white dark:bg-gray-900">
        @include('shared.flash')
        <div class="py-8 px-4 mx-auto max-w-7xl lg:py-16">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                    @if ($promotion->exists)
                        Modifier une promotion
                    @else
                        Ajouter une promotion
                    @endif
                </h2>
                <a href="{{ route('admin.promotions.index') }}"
                    class="flex gap-1 items-center justify-center uppercase text-white bg-primary hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                    <i class="fas fa-star"></i> Liste des promotions
                </a>
            </div>
            <form
                action="{{ route($promotion->exists ? 'admin.promotions.update' : 'admin.promotions.store', $promotion) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method($promotion->exists ? 'PUT' : 'POST')
                <div class="mt-6 sm:mt-8 gap-8 lg:flex lg:items-start lg:gap-5 xl:gap-8">
                    <div class="w-full space-y-8">
                        <div
                            class="space-y-4 rounded border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                                <div class="sm:col-span-2">
                                    <div class="mb-3">
                                        @include('shared.input', [
                                            'label' => 'Titre',
                                            'name' => 'title',
                                            'id' => 'title',
                                            'class' => 'p-2.5',
                                            'value' => $promotion->title,
                                            'placeholder' => 'Titre',
                                        ])
                                    </div>
                                    <div class="mb-3">
                                        @include('shared.input', [
                                            'label' => 'Description',
                                            'id' => 'content',
                                            'type' => 'textarea',
                                            'dataId' => $promotion->id,
                                            'dataType' => get_class($promotion),
                                            'dataUrl' => route('admin.attachments.store'),
                                            'name' => 'content',
                                            'value' => $promotion->content,
                                        ])
                                    </div>
                                    <div class="mb-3">
                                        @include('shared.input', [
                                            'label' => 'Spécificités',
                                            'name' => 'tags',
                                            'class' => 'p-2.5 ',
                                            'placeholder' => 'Entrez les spécificités...',
                                            'id' => 'input-tags',
                                            'value' => $tags,
                                        ])
                                    </div>
                                    <div class="mb-3">
                                        @include('shared.input', [
                                            'label' => 'Galerie d\'images ( PNG, JPG)',
                                            'name' => 'images[]',
                                            'type' => 'file',
                                            'multiple' => 'multiple',
                                            'id' => 'images',
                                        ])
                                    </div>
                                    @if (count($promotion->getMedia('galerie')) > 0)
                                        <div class="flex flex-wrap items-center gap-4 relative">
                                            @foreach ($promotion->getMedia('galerie') as $image)
                                                <div class="relative" id="media-container-{{ $image->id }}">
                                                    <img src="{{ $image->getUrl() }}" class="w-24 rounded-t">
                                                    <a href="#" data-id="{{ $image->id }}"
                                                        data-url="{{ route('admin.promotions.media.delete', [$promotion, $image->id]) }}"
                                                        onclick="deleteImage(event, {{ $image->id }})"
                                                        class="hover:text-white text-xs bg-red-500 hover:bg-gray-700 rounded-b text-white px-2 py-1.5 w-full block text-center dark:hover:text-white><i
                                                            class="fas
                                                        fa-trash"></i> Supprimer </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="mt-6 w-full  space-y-6 sm:mt-8 lg:mt-0 lg:max-w-xs xl:max-w-md">
                        <div
                            class="space-y-4 rounded border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                            <div class="mb-3">
                                @include('shared.input', [
                                    'label' => 'Image a la une ( PNG, JPG)',
                                    'name' => 'image',
                                    'type' => 'file',
                                    'id' => 'image',
                                ])
                            </div>
                            @if ($promotion->getMedia()->count() > 0)
                                <div class="flex justify-center">
                                    <img src="{{ $promotion->getFirstMediaUrl() }}" class="w-64 border p-1.5 rounded">
                                </div>
                            @endif
                            <div class="mb-3">
                                @include('shared.input', [
                                    'label' => 'Plan ( PDF)',
                                    'name' => 'plan',
                                    'type' => 'file',
                                    'id' => 'plan',
                                ])
                            </div>
                            @if ($promotion->hasMedia('pdfs'))
                                <a href="{{ $promotion->getFirstMediaUrl('pdfs') }}" target="_blank"
                                    class="text-gray-800 hover:bg-primary my-5 inline-block bg-gray-300  hover:text-white px-2 py-1.5 rounded"
                                    download><i class="fas fa-file-download"></i> Télécharger le
                                    plan</a>
                            @endif
                            <div class="flex items-center mb-4 p-2 border border-gray-200 rounded">
                                @include('shared.checkbox', [
                                    'label' => 'Publier',
                                    'name' => 'status',
                                    'id' => 'status',
                                    'value' => $promotion->status,
                                ])
                            </div>
                            <div class="flex justify-end items-center">
                                <button
                                    class="inline-flex w-full items-center px-5 py-2.5  text-sm font-medium text-center text-white bg-primary hover:bg-gray-800 hover:text-white rounded focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                                    @if ($promotion->exists)
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
            <script>
                function deleteImage(event, imageId) {
                    event.preventDefault();
                    if (!confirm('Voulez-vous vraiment supprimer cette image ?')) {
                        return;
                    }
                    var url = event.target.getAttribute('data-url');
                    var container = document.getElementById('media-container-' + imageId);
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}' // Inclure le token CSRF
                        },
                        success: function(response) {
                            // Suppression réussie, on enlève l'élément de l'interface
                            container.remove();
                            alert('Image supprimée avec succès !');
                        },
                        error: function(xhr) {
                            // En cas d'erreur
                            alert('Erreur lors de la suppression de l\'image.');
                        }
                    })
                }
            </script>
        @endsection
    @endif
</x-adminlayout>
