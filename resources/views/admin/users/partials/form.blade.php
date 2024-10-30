@csrf
<div class="mt-6 sm:mt-8 gap-8 lg:flex lg:items-start lg:gap-5 xl:gap-8">
    <div class="w-full space-y-8">
        <div
            class="space-y-4 rounded border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="sm:col-span-2">
                    @include('shared.input', [
                        'label' => 'Nom',
                        'name' => 'name',
                        'class' => 'p-2.5',
                        'value' => isset($user) ? $user->name : '',
                        'placeholder' => 'Nom',
                    ])
                    @include('shared.input', [
                        'label' => 'Email',
                        'name' => 'email',
                        'type' => 'email',
                        'class' => 'p-2.5',
                        'value' => isset($user) ? $user->email : '',
                        'placeholder' => 'Nom',
                    ])
                    @if ($created)
                        @include('shared.input', [
                            'label' => 'Mot de passe',
                            'name' => 'password',
                            'type' => 'password',
                            'class' => 'p-2.5',
                            'placeholder' => '**************',
                        ])
                        @include('shared.input', [
                            'label' => 'Confirmer mot de passe',
                            'name' => 'password_confirmation',
                            'type' => 'password',
                            'class' => 'p-2.5',
                            'placeholder' => '**************',
                        ])
                    @endif
                </div>

            </div>
            <div class="flex justify-end items-center">
                <button
                    class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary hover:bg-gray-800 hover:text-white rounded focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                    @if ($created)
                        Créer un utilisateur
                    @else
                        Modifier
                    @endif
                </button>
            </div>
        </div>
    </div>
</div>
