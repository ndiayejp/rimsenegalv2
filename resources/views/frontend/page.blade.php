<x-layout>
    <section class=" dark:bg-gray-900">
        <h1
            class="bg-primary text-center text-4xl font-extrabold tracking-tight leading-none text-white py-12 md:text-5xl lg:text-6xl dark:text-white">
            {{ $page->title }}</h1>
        <div class="py-8 px-4 mx-auto max-w-screen-xl text-justify  lg:py-12 lg:px-12 text-gray-600">
            <div class="bg-white border rounded-lg p-5 text-gray-600">
                <p class="mb-8 text-lg font-normal  lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">
                    {!! $page->content !!}</p>
            </div>
        </div>

    </section>
    @section('styles')
        <style>
            .align-to-left {
                float: left;
            }
        </style>
    @endsection
</x-layout>
