<x-adminlayout>
    @section('title', 'Créer un utilisateur')
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-7xl lg:py-16">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white border-b border-3 border-gray-600">
                    Ajouter un utilisateur
                </h2>
                <a href="{{ route('admin.users.index') }}"
                    class="flex gap-1 items-center justify-center uppercase text-white bg-primary hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                    <i class="fas fa-file-alt "></i> Liste des utilisateurs
                </a>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @include('admin.users.partials.form', ['created' => true])
            </form>
        </div>
    </section>
</x-adminlayout>
