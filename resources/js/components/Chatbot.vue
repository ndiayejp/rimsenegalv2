<template>
    <!-- Chatbot Flottant Amélioré -->
    <div class="chatbot-container">
        <!-- Badge de notification -->
        <div v-if="!isOpen && hasUnreadSuggestions" class="notification-badge">
            {{ unreadCount }}
        </div>

        <button
            class="chatbot-button pulse"
            :class="{ 'active': isOpen }"
            @click="toggleChat"
        >
            <font-awesome-icon icon="fa-solid fa-robot" class="text-gray-100 text-2xl" v-if="!isOpen" />
            <font-awesome-icon icon="fa-solid fa-times" class="text-gray-100 text-2xl" v-else />
        </button>

        <div class="chatbot-window" :class="{ 'active': isOpen }">
            <div class="chatbot-header">
                <div class="chatbot-title">
                    <div class="chatbot-avatar">
                        <font-awesome-icon icon="fa-solid fa-robot" class="text-gray-100 text-2xl" />
                        <div class="status-indicator"></div>
                    </div>
                    <div>
                        <div style="font-weight: bold;">Assistant Immobilier IA</div>
                        <div style="font-size: 12px; opacity: 0.9;">
                            {{ isProcessing ? 'Analyse en cours...' : 'En ligne • Prêt à vous aider' }}
                        </div>
                    </div>
                </div>
                <div class="chatbot-actions">
                    <button @click="toggleHistory" class="action-btn" title="Historique" v-if="conversationHistory.length > 0">
                        <font-awesome-icon icon="fa-solid fa-history" class="text-gray-100 text-lg" />
                    </button>
                    <button @click="restartConversation" class="action-btn" title="Nouvelle discussion">
                        <font-awesome-icon icon="fa-solid fa-redo" class="text-gray-100 text-lg" />
                    </button>
                </div>
            </div>

            <div class="chatbot-messages" ref="messagesContainer">
                <!-- Message de bienvenue amélioré -->
                <div class="message bot-message welcome-message">
                    <div class="welcome-header">👋 Bonjour ! Je suis votre assistant IA</div>
                    <div class="welcome-text">
                        Je vais vous aider à trouver le bien parfait. Vous pouvez me parler naturellement,
                        par exemple : <em>"Je cherche un appartement 3 chambres à Dakar pour 500 000 F CFA"</em>
                    </div>
                    <div class="welcome-features">
                        <div class="feature-item">
                            <font-awesome-icon icon="fa-solid fa-brain" />
                            <span>Compréhension naturelle</span>
                        </div>
                        <div class="feature-item">
                            <font-awesome-icon icon="fa-solid fa-bolt" />
                            <span>Suggestions instantanées</span>
                        </div>
                        <div class="feature-item">
                            <font-awesome-icon icon="fa-solid fa-heart" />
                            <span>Mémorisation des préférences</span>
                        </div>
                    </div>
                </div>

                <!-- Historique des messages -->
                <div
                    v-for="(message, index) in conversationHistory"
                    :key="index"
                    :class="['message', message.sender === 'user' ? 'user-message' : 'bot-message']"
                >
                    <!-- Message content avec timestamp -->
                    <div class="message-header" v-if="message.sender === 'bot'">
                        <font-awesome-icon icon="fa-solid fa-robot" class="message-icon" />
                        <span class="message-time">{{ formatTime(message.timestamp) }}</span>
                    </div>

                    <div class="message-content" v-html="formatMessageContent(message.content)"></div>

                    <!-- Critères extraits -->
                    <div v-if="message.extractedCriteria" class="extracted-criteria">
                        <div class="criteria-header">
                            <font-awesome-icon icon="fa-solid fa-check-circle" />
                            <span>Critères détectés :</span>
                        </div>
                        <div class="criteria-tags">
                            <span v-for="(value, key) in message.extractedCriteria" :key="key" class="criteria-tag">
                                <font-awesome-icon :icon="getCriteriaIcon(key)" />
                                {{ formatCriteria(key, value) }}
                                <button @click="removeCriteria(key)" class="remove-criteria">×</button>
                            </span>
                        </div>
                    </div>

                    <!-- Suggestions de propriétés améliorées -->
                    <div v-if="message.suggestions && message.suggestions.length > 0" class="properties-suggestions">
                        <div class="suggestion-header">
                            <span class="suggestion-count">
                                <font-awesome-icon icon="fa-solid fa-home" />
                                {{ message.suggestions.length }} bien{{ message.suggestions.length > 1 ? 's' : '' }} trouvé{{ message.suggestions.length > 1 ? 's' : '' }}
                            </span>
                            <button v-if="message.hasMore" @click="showAllResults" class="show-all-btn">
                                Voir tous les résultats ({{ totalResults }})
                            </button>
                        </div>

                        <div class="properties-grid">
                            <div
                                v-for="property in message.suggestions"
                                :key="property.id"
                                class="property-card"
                                @click="selectProperty(property)"
                            >
                                <div class="property-image-container">
                                    <img
                                        :src="property.thumb || '/images/noimage.jpg'"
                                        :alt="property.categorie"
                                        class="property-image"
                                        loading="lazy"
                                    />
                                    <div class="property-badge" :class="property.transaction.toLowerCase()">
                                        {{ property.transaction }}
                                    </div>
                                   <button
                                    @click.stop="toggleFavorite(property)"
                                    class="favorite-btn"
                                    :class="{ 'active': isFavorite(property.id) }"
                                    >
                                    <font-awesome-icon icon="fa-solid fa-heart" />
                                    </button>
                                </div>

                                <div class="property-details">
                                    <div class="property-price">{{ formatPrice(property.price) }}</div>
                                    <div class="property-title">{{ property.categorie }}</div>
                                    <div class="property-location">
                                        <font-awesome-icon icon="fa-solid fa-map-marker-alt" />
                                        {{ property.localisation.quartier }}, {{ property.localisation.ville }}
                                    </div>
                                    <div class="property-features">
                                        <span v-if="property.nbchambres">
                                            <font-awesome-icon icon="fa-solid fa-bed" /> {{ property.nbchambres }}
                                        </span>
                                        <span v-if="property.surface">
                                            <font-awesome-icon icon="fa-solid fa-ruler-combined" /> {{ property.surface }}m²
                                        </span>
                                        <span v-if="property.nbpieces">
                                            <font-awesome-icon icon="fa-solid fa-door-open" /> {{ property.nbpieces }}
                                        </span>
                                    </div>
                                    <div class="property-score" v-if="property.matchScore">
                                        <div class="score-bar">
                                            <div class="score-fill" :style="{ width: property.matchScore + '%' }"></div>
                                        </div>
                                        <span class="score-text">{{ property.matchScore }}% correspondance</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Message aucun bien trouvé amélioré -->
                    <div v-if="message.noResults" class="no-results-message">
                        <div class="no-results-icon">
                            <font-awesome-icon icon="fa-solid fa-search" class="text-gray-400 text-2xl" />
                        </div>
                        <div class="no-results-text">
                            Aucun bien ne correspond exactement à vos critères.
                        </div>
                        <div class="alternative-suggestions" v-if="message.alternatives && message.alternatives.length > 0">
                            <div class="alternatives-header">💡 Suggestions alternatives :</div>
                            <div class="alternatives-list">
                                <button
                                    v-for="alt in message.alternatives"
                                    :key="alt.id"
                                    @click="applyAlternative(alt)"
                                    class="alternative-btn"
                                >
                                    {{ alt.suggestion }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Actions après sélection -->
                    <div v-if="message.actions" class="action-buttons">
                        <button
                            v-for="action in message.actions"
                            :key="action.label"
                            :class="['action-button', action.type]"
                            @click="handleAction(action)"
                        >
                            <font-awesome-icon :icon="action.icon" /> {{ action.label }}
                        </button>
                    </div>
                </div>

                <!-- Indicateur de frappe amélioré -->
                <div v-if="isProcessing" class="typing-indicator">
                    <div class="typing-avatar">
                        <font-awesome-icon icon="fa-solid fa-robot" />
                    </div>
                    <div class="typing-content">
                        <div class="typing-text">{{ processingMessage }}</div>
                        <div class="typing-dots">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="chatbot-input-container">
                <!-- Chips de critères actifs -->
                <div class="active-criteria-chips" v-if="Object.keys(activeCriteria).length > 0 && !isProcessing">
                    <div class="chip-label">Filtres actifs :</div>
                    <div class="chips-container">
                        <span v-for="(value, key) in activeCriteria" :key="key" class="criteria-chip">
                            {{ formatCriteria(key, value) }}
                            <button @click="removeCriteria(key)" class="chip-remove">×</button>
                        </span>
                        <button @click="clearAllCriteria" class="clear-all-btn" v-if="Object.keys(activeCriteria).length > 1">
                            Tout effacer
                        </button>
                    </div>
                </div>

                <!-- Réponses rapides intelligentes -->
                <div class="quick-actions" v-if="currentQuickActions.length > 0 && !isProcessing">
                    <div
                        v-for="action in currentQuickActions"
                        :key="action.text"
                        class="quick-action"
                        @click="selectQuickAction(action)"
                    >
                        <font-awesome-icon :icon="action.icon" v-if="action.icon" />
                        {{ action.text }}
                    </div>
                </div>

                <!-- Champ de saisie avec autocomplétion -->
                <div class="chatbot-input">
                    <input
                        type="text"
                        v-model="userInput"
                        @keypress.enter="sendMessage"
                        @input="handleInputChange"
                        :placeholder="inputPlaceholder"
                        autocomplete="off"
                        :disabled="isProcessing"
                        ref="inputField"
                    />

                    <!-- Suggestions d'autocomplétion -->
                    <div v-if="autocompleteOptions.length > 0" class="autocomplete-dropdown">
                        <div
                            v-for="option in autocompleteOptions"
                            :key="option.value"
                            class="autocomplete-option"
                            @click="selectAutocomplete(option)"
                        >
                            <font-awesome-icon :icon="option.icon" />
                            {{ option.label }}
                        </div>
                    </div>

                    <button
                        class="chatbot-send"
                        @click="sendMessage"
                        :disabled="isProcessing || !userInput.trim()"
                        :class="{ 'processing': isProcessing }"
                    >
                        <font-awesome-icon icon="fa-solid fa-paper-plane" class="text-gray-100 text-sm" v-if="!isProcessing"/>
                        <div v-else class="send-spinner"></div>
                    </button>
                </div>

                <!-- Indicateur de caractères -->
                <div class="input-footer" v-if="userInput.length > 0">
                    <span class="char-count">{{ userInput.length }}/500</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, watch, nextTick, onMounted, onUnmounted } from 'vue';

// Props
const props = defineProps({
    properties: {
        type: Array,
        default: () => []
    }
});

// Émettre des événements
const emit = defineEmits(['propertySelected', 'updateFilters', 'scrollToProperty', 'openContactModal']);

// États réactifs
const isOpen = ref(false);
const userInput = ref('');
const isProcessing = ref(false);
const conversationHistory = ref([]);
const selectedProperty = ref(null);
const favorites = ref(new Set());
const hasUnreadSuggestions = ref(false);
const unreadCount = ref(0);
const autocompleteOptions = ref([]);
const processingMessage = ref('Analyse en cours...');

// Critères actifs de recherche
const activeCriteria = ref({});

// Références
const messagesContainer = ref(null);
const inputField = ref(null);

// Données dynamiques
const availableTypes = ref([]);
const availableTransactions = ref(['Location', 'Vente']);
const availableCities = ref([]);
const totalResults = ref(0);

// Messages de traitement variés
const processingMessages = [
    'Analyse de vos critères...',
    'Recherche dans la base de données...',
    'Calcul des meilleures correspondances...',
    'Préparation des suggestions...'
];

// Icônes
const criteriaIcons = {
    type: 'fa-solid fa-home',
    transaction: 'fa-solid fa-handshake',
    city: 'fa-solid fa-map-marker-alt',
    budget: 'fa-solid fa-money-bill-wave',
    bedrooms: 'fa-solid fa-bed',
    pieces: 'fa-solid fa-door-open',
    surface: 'fa-solid fa-ruler-combined'
};

// Computed properties
const currentQuickActions = computed(() => {
    const actions = [];

    if (Object.keys(activeCriteria.value).length === 0) {
        // Suggestions initiales  basées sur les propriétés disponibles
        if (availableTypes.value.length > 0) {
            actions.push(...availableTypes.value.slice(0, 3).map(type => ({
                icon: 'fa-solid fa-home',
                text: type,
                value: type,
                type: 'type'
            })));
        }
    } else {
        // Suggestions contextuelles
        if (!activeCriteria.value.transaction) {
            actions.push(
                { icon: 'fa-solid fa-key', text: 'Location', value: 'Location', type: 'transaction' },
                { icon: 'fa-solid fa-tag', text: 'Vente', value: 'Vente', type: 'transaction' }
            );
        }

        if (!activeCriteria.value.city && availableCities.value.length > 0) {
            actions.push(...availableCities.value.slice(0, 3).map(city => ({
                icon: 'fa-solid fa-city',
                text: city,
                value: city,
                type: 'city'
            })));
        }
    }

    // Actions générales
    actions.push(
        { icon: 'fa-solid fa-search', text: 'Lancer la recherche', value: 'search', type: 'action' },
        { icon: 'fa-solid fa-heart', text: 'Mes favoris', value: 'favorites', type: 'action' }
    );

    return actions.slice(0, 6); // Limiter à 6 actions
});

const inputPlaceholder = computed(() => {
    if (Object.keys(activeCriteria.value).length === 0) {
        return "Ex: Appartement 3 chambres à Dakar, budget 500 000 F CFA";
    }
    return "Affinez votre recherche ou ajoutez des critères...";
});

// Méthodes principales
const toggleChat = () => {
    isOpen.value = !isOpen.value;
    if (isOpen.value) {
        hasUnreadSuggestions.value = false;
        unreadCount.value = 0;
        nextTick(() => {
            inputField.value?.focus();
            scrollToBottom();
        });
        loadSavedConversation();
    }
};

const extractDataFromProperties = () => {
    if (props.properties.length === 0) return;

    // Extraire types uniques
    const types = [...new Set(props.properties.map(p => p.categorie).filter(Boolean))];
    availableTypes.value = types;

    // Extraire villes uniques
    const cities = [...new Set(props.properties.map(p => p.localisation?.ville).filter(Boolean))];
    availableCities.value = cities;
};

// Traitement intelligent du langage naturel
const parseNaturalLanguage = (input) => {
    const criteria = {};
    const lowerInput = input.toLowerCase();

    // Détection du type de bien
    availableTypes.value.forEach(type => {
        if (lowerInput.includes(type.toLowerCase())) {
            criteria.type = type;
        }
    });

    // Détection de la transaction
    if (lowerInput.includes('location') || lowerInput.includes('louer') || lowerInput.includes('loyer')) {
        criteria.transaction = 'Location';
    } else if (lowerInput.includes('vente') || lowerInput.includes('acheter') || lowerInput.includes('achat')) {
        criteria.transaction = 'Vente';
    }

    // Détection de la ville
    availableCities.value.forEach(city => {
        if (lowerInput.includes(city.toLowerCase())) {
            criteria.city = city;
        }
    });

    // Détection du budget (plusieurs formats)
    const budgetPatterns = [
        /(\d+)\s*(?:000|k)\s*(?:f\s*cfa|fcfa|francs?)/i,
        /(\d+)\s*millions?/i,
        /budget.*?(\d+)/i,
        /(\d{3,})/
    ];

    for (const pattern of budgetPatterns) {
        const match = input.match(pattern);
        if (match) {
            let budget = parseInt(match[1]);
            if (input.toLowerCase().includes('million')) {
                budget *= 1000000;
            } else if (input.toLowerCase().includes('k')) {
                budget *= 1000;
            }
            criteria.budget = budget;
            break;
        }
    }

    // Détection du nombre de chambres
    const bedroomPatterns = [
        /(\d+)\s*chambres?/i,
        /(\d+)\s*ch\b/i,
        /(\d+)\s*bd/i
    ];

    for (const pattern of bedroomPatterns) {
        const match = input.match(pattern);
        if (match) {
            criteria.bedrooms = parseInt(match[1]);
            break;
        }
    }

    // Détection du nombre de pièces
    const piecesPatterns = [
        /(\d+)\s*pi[èe]ces?/i,
        /(\d+)\s*p\b/i
    ];

    for (const pattern of piecesPatterns) {
        const match = input.match(pattern);
        if (match) {
            criteria.pieces = parseInt(match[1]);
            break;
        }
    }

    return criteria;
};

// Mapper les critères du chatbot vers les filtres du composant parent
const mapCriteriaToFilters = (criteria) => {
    return {
        category: criteria.type || '',
        transaction: criteria.transaction || '',
        city: criteria.city || '',
        maxPrice: criteria.budget || null,
        nbPieces: criteria.pieces || criteria.bedrooms || null
    };
};

const sendMessage = async () => {
    if (!userInput.value.trim() || isProcessing.value) return;

    const userMessage = userInput.value.trim();
    userInput.value = '';
    autocompleteOptions.value = [];

    // Ajouter le message de l'utilisateur
    conversationHistory.value.push({
        sender: 'user',
        content: userMessage,
        timestamp: new Date()
    });

    isProcessing.value = true;
    rotateProcessingMessage();

    await nextTick();
    scrollToBottom();

    // Simuler un délai de traitement réaliste
    await new Promise(resolve => setTimeout(resolve, 800));

    // Parser le message avec NLP
    const extractedCriteria = parseNaturalLanguage(userMessage);

    // Mettre à jour les critères actifs
    Object.assign(activeCriteria.value, extractedCriteria);

    // Rechercher les propriétés correspondantes
    const matchingProperties = searchProperties(activeCriteria.value);

    // Calculer le score de correspondance
    const propertiesWithScore = matchingProperties.map(prop => ({
        ...prop,
        matchScore: calculateMatchScore(prop, activeCriteria.value)
    })).sort((a, b) => b.matchScore - a.matchScore);

    totalResults.value = propertiesWithScore.length;

    // Préparer la réponse
    let botResponse = '';
    const responseData = {
        sender: 'bot',
        timestamp: new Date()
    };

    if (Object.keys(extractedCriteria).length > 0) {
        botResponse = generateContextualResponse(extractedCriteria, propertiesWithScore.length);
        responseData.extractedCriteria = extractedCriteria;
    } else {
        botResponse = "Je n'ai pas bien compris vos critères. Pouvez-vous préciser ce que vous recherchez ?";
    }

    responseData.content = botResponse;

    if (propertiesWithScore.length > 0) {
        responseData.suggestions = propertiesWithScore.slice(0, 8);
        responseData.hasMore = propertiesWithScore.length > 8;

        if (!isOpen.value) {
            hasUnreadSuggestions.value = true;
            unreadCount.value = propertiesWithScore.length;
        }
    } else if (Object.keys(extractedCriteria).length > 0) {
        responseData.noResults = true;
        responseData.alternatives = generateAlternatives(activeCriteria.value);
    }

    conversationHistory.value.push(responseData);

    isProcessing.value = false;

    await nextTick();
    scrollToBottom();

    // Mettre à jour les filtres dans le composant parent
emit('updateFilters', mapCriteriaToFilters(activeCriteria.value));

    // Sauvegarder la conversation
    saveConversation();
};

const generateContextualResponse = (criteria, count) => {
    const parts = [];

    if (criteria.type) parts.push(`un <strong>${criteria.type}</strong>`);
    if (criteria.bedrooms) parts.push(`<strong>${criteria.bedrooms} chambre${criteria.bedrooms > 1 ? 's' : ''}</strong>`);
    if (criteria.city) parts.push(`à <strong>${criteria.city}</strong>`);
    if (criteria.transaction) parts.push(`en <strong>${criteria.transaction.toLowerCase()}</strong>`);
    if (criteria.budget) parts.push(`avec un budget de <strong>${formatPrice(criteria.budget + ' F CFA')}</strong>`);

    let response = '';
    if (parts.length > 0) {
        response = `Parfait ! Vous recherchez ${parts.join(', ')}. `;
    }

    if (count > 0) {
        response += `J'ai trouvé <strong>${count} bien${count > 1 ? 's' : ''}</strong> qui pourrai${count > 1 ? 'ent' : 't'} vous intéresser ! 🎉`;
    }

    return response;
};

const searchProperties = (criteria) => {
    let results = [...props.properties];

    if (criteria.type) {
        results = results.filter(p =>
            p.categorie?.toLowerCase() === criteria.type.toLowerCase()
        );
    }

    if (criteria.transaction) {
        results = results.filter(p =>
            p.transaction?.toLowerCase() === criteria.transaction.toLowerCase()
        );
    }

    if (criteria.city) {
        results = results.filter(p =>
            p.localisation?.ville?.toLowerCase().includes(criteria.city.toLowerCase()) ||
            p.localisation?.quartier?.toLowerCase().includes(criteria.city.toLowerCase())
        );
    }

    if (criteria.budget) {
        results = results.filter(p => {
            const price = parseInt(p.price.replace(/[^\d]/g, ''));
            return price <= criteria.budget;
        });
    }

    if (criteria.bedrooms) {
        results = results.filter(p =>
            parseInt(p.nbchambres) >= criteria.bedrooms
        );
    }

    if (criteria.pieces) {
        results = results.filter(p =>
            parseInt(p.nbpieces) >= criteria.pieces
        );
    }

    return results;
};

const calculateMatchScore = (property, criteria) => {
    let score = 0;
    let totalCriteria = 0;

    Object.keys(criteria).forEach(key => {
        totalCriteria++;

        switch(key) {
            case 'type':
                if (property.categorie?.toLowerCase() === criteria.type.toLowerCase()) score++;
                break;
            case 'transaction':
                if (property.transaction?.toLowerCase() === criteria.transaction.toLowerCase()) score++;
                break;
            case 'city':
                if (property.localisation?.ville?.toLowerCase().includes(criteria.city.toLowerCase())) score++;
                break;
            case 'budget':
                const price = parseInt(property.price.replace(/[^\d]/g, ''));
                if (price <= criteria.budget) score++;
                break;
            case 'bedrooms':
                if (parseInt(property.nbchambres) >= criteria.bedrooms) score++;
                break;
            case 'pieces':
                if (parseInt(property.nbpieces) >= criteria.pieces) score++;
                break;
        }
    });

    return totalCriteria > 0 ? Math.round((score / totalCriteria) * 100) : 0;
};

const generateAlternatives = (criteria) => {
    const alternatives = [];

    if (criteria.budget) {
        alternatives.push({
            id: 'budget',
            suggestion: `Augmenter le budget de 20%`,
            action: () => {
                activeCriteria.value.budget = Math.round(criteria.budget * 1.2);
                sendMessage();
            }
        });
    }

    if (criteria.bedrooms && criteria.bedrooms > 1) {
        alternatives.push({
            id: 'bedrooms',
            suggestion: `${criteria.bedrooms - 1} chambre${criteria.bedrooms - 1 > 1 ? 's' : ''}`,
            action: () => {
                activeCriteria.value.bedrooms = criteria.bedrooms - 1;
                sendMessage();
            }
        });
    }

    if (criteria.city) {
        alternatives.push({
            id: 'city',
            suggestion: `Rechercher dans d'autres quartiers`,
            action: () => {
                delete activeCriteria.value.city;
                sendMessage();
            }
        });
    }

    return alternatives.slice(0, 3);
};

const handleInputChange = () => {
    // Debouncing pour l'autocomplétion
    clearTimeout(window.autocompleteTimeout);

    if (userInput.value.length < 2) {
        autocompleteOptions.value = [];
        return;
    }

    window.autocompleteTimeout = setTimeout(() => {
        generateAutocomplete();
    }, 300);
};

const generateAutocomplete = () => {
    const input = userInput.value.toLowerCase();
    const options = [];

    // Suggestions de villes
    availableCities.value.forEach(city => {
        if (city.toLowerCase().includes(input)) {
            options.push({
                icon: 'fa-solid fa-map-marker-alt',
                label: city,
                value: city,
                type: 'city'
            });
        }
    });

    // Suggestions de types
    availableTypes.value.forEach(type => {
        if (type.toLowerCase().includes(input)) {
            options.push({
                icon: 'fa-solid fa-home',
                label: type,
                value: type,
                type: 'type'
            });
        }
    });

    autocompleteOptions.value = options.slice(0, 5);
};

const selectAutocomplete = (option) => {
    userInput.value = option.label;
    autocompleteOptions.value = [];
    inputField.value?.focus();
};

const selectQuickAction = (action) => {
    if (action.type === 'action') {
        if (action.value === 'search') {
            userInput.value = 'Lancer la recherche';
            sendMessage();
        } else if (action.value === 'favorites') {
            showFavorites();
        }
    } else {
        activeCriteria.value[action.type] = action.value;
        userInput.value = `${action.text}`;
        sendMessage();
    }
};

const selectProperty = (property) => {
    emit('propertySelected', property);
    emit('scrollToProperty', property.id);

    conversationHistory.value.push({
        sender: 'bot',
        content: `Excellent choix ! Souhaitez-vous obtenir plus d'informations sur ce ${property.categorie} ?`,
        timestamp: new Date(),
        actions: [
            {
                icon: 'fa-solid fa-phone',
                label: 'Contacter un conseiller',
                type: 'primary',
                action: () => emit('openContactModal', property)
            },
            {
                icon: 'fa-solid fa-heart',
                label: 'Ajouter aux favoris',
                type: 'secondary',
                action: () => toggleFavorite(property)
            },
            {
                icon: 'fa-solid fa-search',
                label: 'Voir des biens similaires',
                type: 'secondary',
                action: () => findSimilarProperties(property)
            }
        ]
    });

    scrollToBottom();
};

const handleAction = (action) => {
    if (action.action) {
        action.action();
    }
};

const toggleFavorite = (property) => {
    if (favorites.value.has(property.id)) {
        favorites.value.delete(property.id);
    } else {
        favorites.value.add(property.id);
    }
    saveFavorites();
};

const isFavorite = (propertyId) => {
    return favorites.value.has(propertyId);
};

const showFavorites = () => {
    const favoriteProperties = props.properties.filter(p => favorites.value.has(p.id));

    if (favoriteProperties.length === 0) {
        conversationHistory.value.push({
            sender: 'bot',
            content: "Vous n'avez pas encore de favoris. Ajoutez des biens à vos favoris en cliquant sur le cœur ! ❤️",
            timestamp: new Date()
        });
    } else {
        conversationHistory.value.push({
            sender: 'bot',
            content: `Voici vos ${favoriteProperties.length} bien${favoriteProperties.length > 1 ? 's' : ''} favori${favoriteProperties.length > 1 ? 's' : ''} :`,
            timestamp: new Date(),
            suggestions: favoriteProperties
        });
    }

    scrollToBottom();
};

const findSimilarProperties = (property) => {
    const similar = props.properties.filter(p =>
        p.id !== property.id &&
        p.categorie === property.categorie &&
        p.localisation?.ville === property.localisation?.ville
    ).slice(0, 5);

    conversationHistory.value.push({
        sender: 'bot',
        content: `Voici des biens similaires dans la même zone :`,
        timestamp: new Date(),
        suggestions: similar
    });

    scrollToBottom();
};

const removeCriteria = (key) => {
    delete activeCriteria.value[key];
    emit('updateFilters', mapCriteriaToFilters(activeCriteria.value));

    // Relancer la recherche
    userInput.value = 'Mettre à jour les résultats';
    sendMessage();
};

const clearAllCriteria = () => {
    activeCriteria.value = {};
    emit('updateFilters', {
        category: '',
        transaction: '',
        city: '',
        maxPrice: null,
        nbPieces: null
    });
    conversationHistory.value = [];
};

const applyAlternative = (alternative) => {
    alternative.action();
};

const showAllResults = () => {
     emit('updateFilters', mapCriteriaToFilters(activeCriteria.value));
    isOpen.value = false;
};

const restartConversation = () => {
    if (confirm('Voulez-vous vraiment recommencer ? La conversation actuelle sera perdue.')) {
        conversationHistory.value = [];
        activeCriteria.value = {};
        favorites.value = new Set();
        localStorage.removeItem('chatbot_conversation');
       emit('updateFilters', {
            category: '',
            transaction: '',
            city: '',
            maxPrice: null,
            nbPieces: null
        });
    }
};

const toggleHistory = () => {
    // Fonctionnalité pour afficher l'historique complet
    console.log('Toggle history');
};

// Utilitaires
const formatMessageContent = (content) => {
    return content;
};

const formatPrice = (price) => {
    if (typeof price === 'string') {
        return price;
    }
    return new Intl.NumberFormat('fr-FR').format(price) + ' F CFA';
};

const formatCriteria = (key, value) => {
    const labels = {
        type: 'Type',
        transaction: 'Transaction',
        city: 'Ville',
        budget: 'Budget',
        bedrooms: 'Chambres',
        pieces: 'Pièces',
        surface: 'Surface'
    };

    let formattedValue = value;
    if (key === 'budget') {
        formattedValue = formatPrice(value);
    } else if (key === 'bedrooms' || key === 'pieces') {
        formattedValue = `${value} ${key === 'bedrooms' ? 'ch.' : 'p.'}`;
    }

    return `${labels[key]}: ${formattedValue}`;
};

const getCriteriaIcon = (key) => {
    return criteriaIcons[key] || 'fa-solid fa-filter';
};

const formatTime = (timestamp) => {
    return new Date(timestamp).toLocaleTimeString('fr-FR', {
        hour: '2-digit',
        minute: '2-digit'
    });
};

const scrollToBottom = () => {
    nextTick(() => {
        if (messagesContainer.value) {
            messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
        }
    });
};

const rotateProcessingMessage = () => {
    let index = 0;
    const interval = setInterval(() => {
        if (!isProcessing.value) {
            clearInterval(interval);
            return;
        }
        processingMessage.value = processingMessages[index];
        index = (index + 1) % processingMessages.length;
    }, 1500);
};

// Persistance
const saveConversation = () => {
    const data = {
        history: conversationHistory.value,
        criteria: activeCriteria.value,
        timestamp: new Date().toISOString()
    };
    localStorage.setItem('chatbot_conversation', JSON.stringify(data));
};

const loadSavedConversation = () => {
    try {
        const saved = localStorage.getItem('chatbot_conversation');
        if (saved) {
            const data = JSON.parse(saved);
            // Charger uniquement si la conversation a moins de 24h
            const savedTime = new Date(data.timestamp);
            const now = new Date();
            const hoursDiff = (now - savedTime) / (1000 * 60 * 60);

            if (hoursDiff < 24) {
                conversationHistory.value = data.history || [];
                activeCriteria.value = data.criteria || {};
            }
        }
    } catch (error) {
        console.error('Error loading conversation:', error);
    }
};

const saveFavorites = () => {
    localStorage.setItem('chatbot_favorites', JSON.stringify([...favorites.value]));
};

const loadFavorites = () => {
    try {
        const saved = localStorage.getItem('chatbot_favorites');
        if (saved) {
            favorites.value = new Set(JSON.parse(saved));
        }
    } catch (error) {
        console.error('Error loading favorites:', error);
    }
};

// Lifecycle hooks
onMounted(() => {
    extractDataFromProperties();
    loadFavorites();

    // Charger la conversation uniquement si l'utilisateur ouvre le chat
    if (isOpen.value) {
        loadSavedConversation();
    }
});

onUnmounted(() => {
    saveConversation();
    clearTimeout(window.autocompleteTimeout);
});

// Watchers
watch(() => props.properties, () => {
    extractDataFromProperties();
}, { deep: true });

watch(conversationHistory, () => {
    if (conversationHistory.value.length > 50) {
        // Limiter l'historique à 50 messages pour la performance
        conversationHistory.value = conversationHistory.value.slice(-50);
    }
}, { deep: true });
</script>

<style scoped>
/* Base styles */
.chatbot-container {
    position: fixed;
    bottom: 15px;
    right: 36px;
    z-index: 9999;
}

.notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: bold;
    box-shadow: 0 2px 8px rgba(231, 76, 60, 0.4);
    animation: pulse 2s infinite;
}

.chatbot-button {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #008dcf, #007bb8);
    border: none;
    box-shadow: 0 4px 20px rgba(0, 141, 207, 0.3);
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.chatbot-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 30px rgba(0, 141, 207, 0.4);
}

.chatbot-button.active {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
}

.chatbot-button.pulse {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        box-shadow: 0 4px 20px rgba(0, 141, 207, 0.3);
    }
    50% {
        box-shadow: 0 4px 30px rgba(0, 141, 207, 0.6);
    }
}

.chatbot-window {
    position: absolute;
    bottom: 75px;
    right: 0;
    width: 420px;
    max-width: calc(100vw - 40px);
    height: 650px;
    max-height: calc(100vh - 100px);
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 50px rgba(0, 0, 0, 0.15);
    display: flex;
    flex-direction: column;
    opacity: 0;
    transform: translateY(20px) scale(0.95);
    pointer-events: none;
    transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.chatbot-window.active {
    opacity: 1;
    transform: translateY(0) scale(1);
    pointer-events: all;
}

.chatbot-header {
    padding: 20px;
    background: linear-gradient(135deg, #008dcf, #007bb8);
    color: white;
    border-radius: 20px 20px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chatbot-title {
    display: flex;
    align-items: center;
    gap: 12px;
}

.chatbot-avatar {
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.status-indicator {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 12px;
    height: 12px;
    background: #2ecc71;
    border: 2px solid white;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

.chatbot-actions {
    display: flex;
    gap: 8px;
}

.action-btn {
    width: 35px;
    height: 35px;
    background: rgba(255, 255, 255, 0.2);
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
}

.action-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: rotate(180deg);
}

.chatbot-messages {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    background: #f8f9fa;
    scroll-behavior: smooth;
}

.chatbot-messages::-webkit-scrollbar {
    width: 6px;
}

.chatbot-messages::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 3px;
}

.message {
    margin-bottom: 16px;
    animation: fadeInUp 0.3s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.bot-message {
    text-align: left;
}

.user-message {
    text-align: right;
}

.message-header {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 6px;
    font-size: 11px;
    color: #6c757d;
}

.message-icon {
    font-size: 14px;
    color: #008dcf;
}

.message-time {
    font-size: 10px;
    opacity: 0.7;
}

.message-content {
    display: inline-block;
    padding: 12px 16px;
    border-radius: 15px;
    max-width: 80%;
    word-wrap: break-word;
    line-height: 1.5;
}

.bot-message .message-content {
    background: white;
    color: #2d3748;
    border: 1px solid #e2e8f0;
    border-radius: 15px 15px 15px 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

.user-message .message-content {
    background: linear-gradient(135deg, #008dcf, #007bb8);
    color: white;
    border-radius: 15px 15px 5px 15px;
    text-align: left;
}

.welcome-message {
    background: linear-gradient(135deg, #007bb8 0%, #008dcf 100%);
    color: white;
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 20px;
}

.welcome-header {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 12px;
}

.welcome-text {
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 15px;
    opacity: 0.95;
}

.welcome-text em {
    font-style: italic;
    opacity: 0.8;
}

.welcome-features {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 15px;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    background: rgba(255, 255, 255, 0.1);
    padding: 8px 12px;
    border-radius: 8px;
}

.extracted-criteria {
    margin-top: 12px;
    padding: 12px;
    background: #e8f5e9;
    border-radius: 10px;
    border: 1px solid #c8e6c9;
}

.criteria-header {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    font-weight: 600;
    color: #2e7d32;
    margin-bottom: 8px;
}

.criteria-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}

.criteria-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 10px;
    background: white;
    border: 1px solid #a5d6a7;
    border-radius: 15px;
    font-size: 11px;
    color: #2e7d32;
    font-weight: 500;
}

.remove-criteria {
    background: transparent;
    border: none;
    color: #e74c3c;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    padding: 0;
    margin-left: 4px;
    transition: transform 0.2s;
}

.remove-criteria:hover {
    transform: scale(1.2);
}

.properties-suggestions {
    margin-top: 15px;
}

.suggestion-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 2px solid #e2e8f0;
}

.suggestion-count {
    font-weight: 600;
    color: #2d3748;
    display: flex;
    align-items: center;
    gap: 8px;
}

.show-all-btn {
    background: transparent;
    border: 1px solid #008dcf;
    color: #008dcf;
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 11px;
    cursor: pointer;
    transition: all 0.3s;
}

.show-all-btn:hover {
    background: #008dcf;
    color: white;
}

.properties-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 12px;
}

.property-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s;
    border: 2px solid transparent;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.property-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    border-color: #008dcf;
}

.property-image-container {
    position: relative;
    padding-top: 60%;
    overflow: hidden;
}

.property-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.property-card:hover .property-image {
    transform: scale(1.1);
}

.property-badge {
    position: absolute;
    top: 8px;
    left: 8px;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: bold;
    color: white;
    backdrop-filter: blur(10px);
}

.property-badge.location {
    background: rgba(0, 141, 207, 0.9);
}

.property-badge.vente {
    background: rgba(231, 76, 60, 0.9);
}

.favorite-btn {
    position: absolute;
    top: 8px;
    right: 8px;
    width: 32px;
    height: 32px;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    color: #333;
}

.favorite-btn:hover {
    transform: scale(1.1);
    background: white;
}

.favorite-btn.active {
    color: #e74c3c !important;
}

.property-details {
    padding: 12px;
}

.property-price {
    font-weight: bold;
    color: #e74c3c;
    font-size: 14px;
    margin-bottom: 4px;
}

.property-title {
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 4px;
    color: #2d3748;
}

.property-location {
    font-size: 11px;
    color: #718096;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 4px;
}

.property-features {
    display: flex;
    gap: 8px;
    font-size: 10px;
    color: #a0aec0;
    flex-wrap: wrap;
}

.property-features span {
    display: flex;
    align-items: center;
    gap: 3px;
}

.property-score {
    margin-top: 8px;
    padding-top: 8px;
    border-top: 1px solid #e2e8f0;
}

.score-bar {
    height: 4px;
    background: #e2e8f0;
    border-radius: 2px;
    overflow: hidden;
    margin-bottom: 4px;
}

.score-fill {
    height: 100%;
    background: linear-gradient(90deg, #008dcf 0%, #036593 100%);
    transition: width 0.5s ease;
}

.score-text {
    font-size: 10px;
    color: #008dcf;
    font-weight: 600;
}

.no-results-message {
    background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
    border: 2px dashed #cbd5e0;
    border-radius: 12px;
    padding: 24px;
    text-align: center;
    margin-top: 12px;
}

.no-results-icon {
    font-size: 2.5rem;
    color: #cbd5e0;
    margin-bottom: 12px;
}

.no-results-text {
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 16px;
    font-size: 15px;
}

.alternative-suggestions {
    margin-top: 15px;
    text-align: left;
}

.alternatives-header {
    font-size: 13px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 10px;
}

.alternatives-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.alternative-btn {
    padding: 10px 14px;
    background: white;
    border: 1px solid #cbd5e0;
    border-radius: 10px;
    text-align: left;
    cursor: pointer;
    transition: all 0.3s;
    font-size: 13px;
    color: #2d3748;
}

.alternative-btn:hover {
    background: #008dcf;
    color: white;
    border-color: #008dcf;
    transform: translateX(4px);
}

.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-top: 12px;
}

.action-button {
    padding: 12px 16px;
    border: none;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: left;
    display: flex;
    align-items: center;
    gap: 10px;
}

.action-button.primary {
    background: linear-gradient(135deg, #008dcf, #007bb8);
    color: white;
    box-shadow: 0 4px 10px rgba(0, 141, 207, 0.3);
}

.action-button.secondary {
    background: white;
    color: #008dcf;
    border: 1px solid #cbd5e0;
}

.action-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
}

.typing-indicator {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    background: white;
    border-radius: 15px 15px 15px 5px;
    width: fit-content;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    animation: fadeInUp 0.3s ease;
}

.typing-avatar {
    width: 35px;
    height: 35px;
    background: linear-gradient(135deg, #008dcf, #007bb8);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.typing-content {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.typing-text {
    font-size: 11px;
    color: #718096;
    font-weight: 500;
}

.typing-dots {
    display: flex;
    gap: 4px;
}

.typing-dots span {
    width: 6px;
    height: 6px;
    background: #cbd5e0;
    border-radius: 50%;
    animation: typingDot 1.4s infinite;
}

.typing-dots span:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-dots span:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes typingDot {
    0%, 60%, 100% {
        transform: translateY(0);
        background: #cbd5e0;
    }
    30% {
        transform: translateY(-8px);
        background: #008dcf;
    }
}

.chatbot-input-container {
    border-top: 1px solid #e2e8f0;
    background: white;
    border-radius: 0 0 20px 20px;
}

.active-criteria-chips {
    padding: 12px 15px 0 15px;
}

.chip-label {
    font-size: 11px;
    color: #718096;
    margin-bottom: 8px;
    font-weight: 600;
}

.chips-container {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    align-items: center;
}

.criteria-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 10px;
    background: linear-gradient(135deg, #e3f2fd, #bbdefb);
    border: 1px solid #90caf9;
    border-radius: 15px;
    font-size: 11px;
    color: #1976d2;
    font-weight: 500;
}

.chip-remove {
    background: transparent;
    border: none;
    color: #e74c3c;
    cursor: pointer;
    font-size: 14px;
    font-weight: bold;
    padding: 0;
    margin-left: 2px;
    transition: transform 0.2s;
}

.chip-remove:hover {
    transform: scale(1.3);
}

.clear-all-btn {
    padding: 6px 10px;
    background: transparent;
    border: 1px solid #e74c3c;
    color: #e74c3c;
    border-radius: 15px;
    font-size: 10px;
    cursor: pointer;
    transition: all 0.3s;
}

.clear-all-btn:hover {
    background: #e74c3c;
    color: white;
}

.quick-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    padding: 15px 15px 0 15px;
}

.quick-action {
    padding: 8px 12px;
    background: white;
    border: 1px solid #cbd5e0;
    border-radius: 15px;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.3s;
    color: #008dcf;
    display: flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
}

.quick-action:hover {
    background: #008dcf;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 141, 207, 0.3);
}

.chatbot-input {
    padding: 15px;
    display: flex;
    gap: 10px;
    align-items: center;
    position: relative;
}

.chatbot-input input {
    flex: 1;
    padding: 12px 15px;
    border: 1px solid #cbd5e0;
    border-radius: 25px;
    outline: none;
    font-size: 14px;
    transition: all 0.3s;
}

.chatbot-input input:focus {
    border-color: #008dcf;
    box-shadow: 0 0 0 3px rgba(0, 141, 207, 0.1);
}

.chatbot-input input:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.autocomplete-dropdown {
    position: absolute;
    bottom: 100%;
    left: 15px;
    right: 65px;
    background: white;
    border: 1px solid #cbd5e0;
    border-radius: 12px;
    box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
    margin-bottom: 8px;
    max-height: 200px;
    overflow-y: auto;
    z-index: 10;
}

.autocomplete-option {
    padding: 10px 15px;
    cursor: pointer;
    transition: background 0.2s;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    color: #666;
}

.autocomplete-option:hover {
    background: #f8f9fa;
}

.autocomplete-option:not(:last-child) {
    border-bottom: 1px solid #e2e8f0;
}

.chatbot-send {
    background: linear-gradient(135deg, #008dcf, #007bb8);
    border: none;
    border-radius: 50%;
    width: 42px;
    height: 42px;
    min-width: 42px;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    box-shadow: 0 4px 10px rgba(0, 141, 207, 0.3);
}

.chatbot-send:hover:not(:disabled) {
    transform: scale(1.1);
    box-shadow: 0 6px 15px rgba(0, 141, 207, 0.4);
}

.chatbot-send:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.chatbot-send.processing {
    background: #94a3b8;
}

.send-spinner {
    width: 16px;
    height: 16px;
    border: 2px solid transparent;
    border-top: 2px solid white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.input-footer {
    padding: 0 15px 10px 15px;
    text-align: right;
}

.char-count {
    font-size: 10px;
    color: #a0aec0;
}

/* Responsive */
@media (max-width: 768px) {
    .chatbot-window {
        width: 360px;
        height: 600px;
    }

    .properties-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .chatbot-window {
        width: calc(100vw - 40px);
        height: calc(100vh - 100px);
        right: 0;
    }

    .quick-actions {
        flex-direction: column;
    }

    .quick-action {
        width: 100%;
        justify-content: center;
    }
}
</style>
