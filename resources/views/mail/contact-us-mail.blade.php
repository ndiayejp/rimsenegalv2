<x-mail::message>
    # Nouveau message sujet: {{ $contactData['objet'] }}

    ## De: {{ $contactData['name'] }}

    ## Email: {{ $contactData['email'] }}

    ## Message
    {{ $contactData['message'] }}

    <x-mail::button :url="''">
        Button Text
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
