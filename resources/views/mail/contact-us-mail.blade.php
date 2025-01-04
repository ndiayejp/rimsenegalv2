<x-mail::message>
    # Nouveau message sujet: {{ $contactData['objet'] }}

    De: {{ $contactData['name'] }}

    Email: {{ $contactData['email'] }}

    Message: {{ $contactData['content'] }}


    Cordialement,
</x-mail::message>
