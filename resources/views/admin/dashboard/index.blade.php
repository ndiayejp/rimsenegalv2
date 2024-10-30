<x-adminlayout>
    @section('title', 'Tableau de bord')
    <div class="mx-auto  px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <dl class="mt-6 grid grid-cols-1 gap-4 sm:mt-8 sm:grid-cols-2 lg:grid-cols-4">
            <div class="flex flex-col rounded-lg bg-white border border-gray-100 px-4 py-8 text-center">
                <dt class="order-last text-lg font-medium text-gray-500">Articles</dt>

                <dd class="text-4xl font-extrabold text-blue-600 md:text-5xl">{{ $posts }}</dd>
            </div>

            <div class="flex flex-col rounded-lg border bg-white border-gray-100 px-4 py-8 text-center">
                <dt class="order-last text-lg font-medium text-gray-500">Promotions</dt>
                <dd class="text-4xl font-extrabold text-blue-600 md:text-5xl">{{ $promotions }}</dd>
            </div>

            <div class="flex flex-col rounded-lg border bg-white border-gray-100 px-4 py-8 text-center">
                <dt class="order-last text-lg font-medium text-gray-500">Utilisateurs</dt>

                <dd class="text-4xl font-extrabold text-blue-600 md:text-5xl">{{ $users }}</dd>
            </div>

            <div class="flex flex-col rounded-lg border bg-white border-gray-100 px-4 py-8 text-center">
                <dt class="order-last text-lg font-medium text-gray-500">Agences</dt>

                <dd class="text-4xl font-extrabold text-blue-600 md:text-5xl">{{ $agencies }}</dd>
            </div>
        </dl>
    </div>
</x-adminlayout>
