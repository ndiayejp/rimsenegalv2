<x-mail::message>
    # Nouvelle demande de contact

    Vous avez reçu une nouvelle demande de contact pour un bien immobilier.

    Détails de l'utilisateur

    - Nom : {{ $data['name'] }}
    - Email : {{ $data['email'] }}
    - Message : {{ $data['message'] }}

    Détails du bien immobilier

    - Référence du bien : {{ $data['reference'] }}
    - Type de bien : {{ $data['category'] }}
    - Localisation : {{ $data['location'] }}
    - Prix : {{ $data['price'] }}

    Merci,
</x-mail::message>
