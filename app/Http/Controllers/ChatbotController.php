<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'conversation_id' => 'nullable|string'
        ]);

        $userMessage = $request->input('message');
        $conversationId = $request->input('conversation_id', uniqid());

        // Récupérer l'historique de conversation
        $history = Cache::get("chat_history_{$conversationId}", []);

        // Récupérer les propriétés depuis l'API
        $properties = $this->getProperties();

        // Construire le contexte système
        $systemContext = $this->buildSystemContext($properties);

        // Ajouter le message utilisateur à l'historique
        $history[] = ['role' => 'user', 'content' => $userMessage];

        try {
            // Appel à l'API OpenAI
            $response = OpenAI::chat()->create([
                'model' => 'gpt-4',
                'messages' => array_merge(
                    [['role' => 'system', 'content' => $systemContext]],
                    $history
                ),
                'temperature' => 0.7,
                'max_tokens' => 1000,
            ]);

            $assistantMessage = $response->choices[0]->message->content;

            // Ajouter la réponse à l'historique
            $history[] = ['role' => 'assistant', 'content' => $assistantMessage];

            // Sauvegarder l'historique (expire après 1 heure)
            Cache::put("chat_history_{$conversationId}", $history, 3600);

            // Extraire les critères et trouver les biens correspondants
            $matchedProperties = $this->matchProperties($userMessage, $properties);

            return response()->json([
                'success' => true,
                'message' => $assistantMessage,
                'conversation_id' => $conversationId,
                'properties' => $matchedProperties,
                'has_properties' => count($matchedProperties) > 0
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Désolé, une erreur est survenue. Veuillez réessayer.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function getProperties()
    {
        try {
            $response = Http::get('https://www3.pagesimmo.net/chercher_Annonces.ashx', [
                'C1' => 'AN5C3D7Z7HEL',
                'C_Rest' => 'Avec_Fichiers|!|true&Avec_Donnees_Complementaires|!|true&Avec_Donnees_Confidentielles|!|true',
            ]);

            // Parser le XML et le convertir en tableau
            $xml = simplexml_load_string($response->body());
            $properties = [];

            foreach ($xml->DESTINATAIRE->AGENCE->BIEN as $bien) {
                $properties[] = [
                    'id' => (string)$bien->REFERENCE,
                    'reference' => (string)$bien->REFERENCE,
                    'categorie' => $this->extractCategory($bien),
                    'ville' => (string)$bien->LOCALISATION->VILLE,
                    'quartier' => (string)$bien->LOCALISATION->QUARTIER,
                    'prix' => (string)($bien->LOCATION->LOYER_MENSUEL_TTC ?? $bien->VENTE->PRIX),
                    'transaction' => isset($bien->LOCATION) ? 'Location' : 'Vente',
                    'nbchambres' => $this->extractRooms($bien, 'NB_CHAMBRES'),
                    'nbpieces' => $this->extractRooms($bien, 'NB_PIECES'),
                    'surface' => $this->extractSurface($bien),
                    'description' => $this->extractDescription($bien),
                ];
            }

            return $properties;
        } catch (\Exception $e) {
            return [];
        }
    }

    private function buildSystemContext($properties)
    {
        $propertiesJson = json_encode($properties, JSON_UNESCAPED_UNICODE);

        return "Tu es un conseiller immobilier expert et sympathique pour une agence immobilière.

Voici la liste complète de nos biens disponibles : {$propertiesJson}

INSTRUCTIONS IMPORTANTES :
1. Analyse les besoins du client avec attention (budget, localisation, type de bien, nombre de pièces, transaction)
2. Recommande TOUJOURS les biens les plus pertinents basés sur les critères mentionnés
3. Sois conversationnel et chaleureux, pose des questions pour mieux comprendre les besoins
4. Mentionne les références des biens recommandés
5. Si le client donne des critères précis, cite 2-3 biens qui correspondent le mieux
6. Utilise des emojis pour rendre la conversation plus agréable 🏠
7. Si aucun bien ne correspond parfaitement, propose les alternatives les plus proches
8. Encourage le client à prendre contact pour une visite

Réponds en français de façon naturelle et professionnelle.";
    }

    private function matchProperties($userMessage, $properties)
    {
        $matched = [];
        $message = strtolower($userMessage);

        // Extraction des critères basiques
        $criteria = [
            'transaction' => null,
            'maxPrice' => null,
            'minRooms' => null,
            'ville' => null,
            'category' => null
        ];

        // Détecter le type de transaction
        if (preg_match('/\b(louer|location|locatif)\b/i', $message)) {
            $criteria['transaction'] = 'Location';
        } elseif (preg_match('/\b(acheter|achat|vente|achète)\b/i', $message)) {
            $criteria['transaction'] = 'Vente';
        }

        // Détecter le budget (en chiffres)
        if (preg_match('/(\d+)\s*(millions?|fcfa|f\s*cfa|francs?)/i', $message, $matches)) {
            $criteria['maxPrice'] = (int)$matches[1];
            if (stripos($matches[2], 'million') !== false) {
                $criteria['maxPrice'] *= 1000000;
            }
        }

        // Détecter le nombre de pièces/chambres
        if (preg_match('/(\d+)\s*(pièces?|chambres?|ch|p)/i', $message, $matches)) {
            $criteria['minRooms'] = (int)$matches[1];
        }

        // Filtrer les propriétés
        foreach ($properties as $property) {
            $score = 0;

            if ($criteria['transaction'] && $property['transaction'] === $criteria['transaction']) {
                $score += 3;
            }

            if ($criteria['maxPrice']) {
                $price = (int)preg_replace('/[^0-9]/', '', $property['prix']);
                if ($price <= $criteria['maxPrice']) {
                    $score += 2;
                }
            }

            if ($criteria['minRooms']) {
                $rooms = max((int)$property['nbchambres'], (int)$property['nbpieces']);
                if ($rooms >= $criteria['minRooms']) {
                    $score += 2;
                }
            }

            if ($score > 0) {
                $matched[] = array_merge($property, ['score' => $score]);
            }
        }

        // Trier par score et retourner les 3 meilleurs
        usort($matched, fn($a, $b) => $b['score'] - $a['score']);
        return array_slice($matched, 0, 3);
    }

    // Méthodes helper pour extraire les données du XML
    private function extractCategory($bien)
    {
        // Logique d'extraction de la catégorie
        $categories = ['APPARTEMENT', 'MAISON', 'VILLA', 'TERRAIN', 'BUREAU', 'COMMERCE'];
        foreach ($categories as $cat) {
            if (isset($bien->$cat)) {
                return $cat;
            }
        }
        return 'AUTRE';
    }

    private function extractRooms($bien, $field)
    {
        $category = $this->extractCategory($bien);
        return (string)($bien->$category->$field ?? '');
    }

    private function extractSurface($bien)
    {
        $category = $this->extractCategory($bien);
        return (string)($bien->$category->SURFACE_HABITABLE ?? '');
    }

    private function extractDescription($bien)
    {
        return (string)($bien->LOCATION->TEXTES->DESCRIPTION_FR ??
                       $bien->VENTE->TEXTES->DESCRIPTION_FR ?? '');
    }
}
