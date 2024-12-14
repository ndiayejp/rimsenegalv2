<x-mail::message>
    # Nouveau message sujet: {{ $contactData['objet'] }}

    ## De: {{ $contactData['name'] }}

    ## Email: {{ $contactData['email'] }}

    ## Message
    {{ $contactData['message'] }}


    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
