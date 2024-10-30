<div>
    <form wire:submit.prevent="send">
        <div class="grid gap-4">
            <!-- Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @include('shared.input', [
                    'label' => 'Nom',
                    'name' => 'name',
                    'class' => 'p-2.5',
                    'placeholder' => 'Nom',
                    'wire:model' => 'name',
                ])

                @include('shared.input', [
                    'label' => 'Email',
                    'name' => 'email',
                    'type' => 'email',
                    'class' => 'p-2.5',
                    'placeholder' => 'Email',
                    'wire:model' => 'email',
                ])
            </div>
            <!-- End Grid -->
            @include('shared.input', [
                'label' => 'Objet de la demande',
                'name' => 'objet',
                'class' => 'p-2.5',
                'placeholder' => 'objet de la demande',
                'wire:model' => 'objet',
            ])

            @include('shared.input', [
                'label' => 'Contenu',
                'name' => 'content',
                'wire:model' => 'content',
                'type' => 'textarea',
                'class' => 'p-2.5',
                'placeholder' => 'contenu du message',
            ])
        </div>
        <!-- End Grid -->
        <div class="mt-4 grid">
            <button type="submit"
                class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded border border-transparent bg-primary text-white hover:bg-secondary hover:text-gray-600 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">Envoyer
                votre message</button>
        </div>
        <div class="mt-3 text-center">
            <p class="text-sm text-gray-500 dark:text-neutral-500">
                Vous avez des questions, nos commerciaux vous répondrons dans les plus brefs délais
            </p>
        </div>
    </form>
</div>
