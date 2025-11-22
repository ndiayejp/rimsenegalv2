<template>
    <div class="share-property">
        <!-- Bouton de partage principal -->
        <button
            @click="toggleShareMenu"
            class="share-btn bg-gradient-to-r from-primary to-[#006a9a] text-white px-4 py-4 rounded-xl font-medium hover:shadow-lg transition-all duration-300 flex items-center gap-2 text-lg hover:-translate-y-1"
        >
            <font-awesome-icon icon="fa-solid fa-share-alt" class="text-gray-100"/>
            <span>Partager</span>
        </button>

        <!-- Overlay et menu de partage -->
        <div v-if="isShareMenuOpen" class="share-overlay" @click="closeShareMenu">
            <div class="share-menu" @click.stop>
                <div class="share-header flex justify-between">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                        Partager cette annonce
                    </h3>
                    <button @click="closeShareMenu" class="close-btn">
                        <font-awesome-icon icon="fa-solid fa-times" />
                    </button>
                </div>

                <div class="share-options">
                    <!-- Lien de partage -->
                    <div class="share-link-section">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Lien de partage
                        </label>
                        <div class="link-copy flex gap-2">
                            <input
                                ref="shareLinkInput"
                                type="text"
                                :value="shareLink"
                                readonly
                                class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm"
                            />
                            <button
                                @click="copyToClipboard"
                                class="copy-btn px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors"
                            >
                                <font-awesome-icon icon="fa-solid fa-copy" />
                            </button>
                        </div>
                        <p v-if="copySuccess" class="text-green-600 text-sm mt-2 flex items-center gap-1">
                            <font-awesome-icon icon="fa-solid fa-check" />
                            Lien copié !
                        </p>
                    </div>

                    <!-- Options de partage rapide -->
                    <div class="quick-share-options">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            Partager rapidement
                        </h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <!-- WhatsApp -->
                            <button
                                @click="shareOnWhatsApp"
                                class="share-option-btn bg-green-500 hover:bg-green-600 text-white"
                            >
                                <font-awesome-icon :icon="['fab', 'whatsapp']" class="text-lg" />
                                <span>WhatsApp</span>
                            </button>

                            <!-- Email -->
                            <button
                                @click="shareByEmail"
                                class="share-option-btn bg-blue-500 hover:bg-blue-600 text-white"
                            >
                                <font-awesome-icon icon="fa-solid fa-envelope" class="text-lg text-white" />
                                <span>Email</span>
                            </button>

                            <!-- Facebook -->
                            <button
                                @click="shareOnFacebook"
                                class="share-option-btn bg-blue-700 hover:bg-blue-800 text-white"
                            >
                                <font-awesome-icon :icon="['fab', 'facebook']" class="text-lg" />
                                <span>Facebook</span>
                            </button>

                            <!-- LinkedIn -->
                            <button
                                @click="shareOnLinkedIn"
                                class="share-option-btn bg-blue-600 hover:bg-blue-700 text-white"
                            >
                                <font-awesome-icon :icon="['fab', 'linkedin']" class="text-lg" />
                                <span>LinkedIn</span>
                            </button>

                            <!-- Twitter -->
                            <button
                                @click="shareOnTwitter"
                                class="share-option-btn bg-blue-400 hover:bg-sky-600 text-white"
                            >
                                <font-awesome-icon :icon="['fab', 'twitter']" class="text-lg" />
                                <span>Twitter</span>
                            </button>

                            <!-- Lien direct -->
                            <button
                                @click="copyToClipboard"
                                class="share-option-btn bg-gray-600 hover:bg-gray-700 text-white"
                            >
                                <font-awesome-icon icon="fa-solid fa-link" class="text-lg" />
                                <span>Copier lien</span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, nextTick } from 'vue';

const props = defineProps({
    property: {
        type: Object,
        required: true
    }
});

const isShareMenuOpen = ref(false);
const copySuccess = ref(false);
const shareLinkInput = ref(null);

// Générer le lien de partage
const shareLink = computed(() => {
    const baseUrl = window.location.origin + window.location.pathname;
    const propertyId = props.property.id || props.property.reference;
    return `${baseUrl}?property=${propertyId}`;
});

// Messages de partage
const shareMessage = computed(() => {
    return `🏠 Découvrez ce bien immobilier : ${props.property.categorie} à ${props.property.localisation?.ville || ''} - ${props.property.price}`;
});

// Ouvrir/fermer le menu
const toggleShareMenu = () => {
    isShareMenuOpen.value = !isShareMenuOpen.value;
};

const closeShareMenu = () => {
    isShareMenuOpen.value = false;
    copySuccess.value = false;
};

// Copier dans le presse-papier
const copyToClipboard = async () => {
    try {
        await navigator.clipboard.writeText(shareLink.value);
        copySuccess.value = true;
        setTimeout(() => {
            copySuccess.value = false;
        }, 3000);
    } catch (err) {
        // Fallback pour les anciens navigateurs
        shareLinkInput.value.select();
        document.execCommand('copy');
        copySuccess.value = true;
        setTimeout(() => {
            copySuccess.value = false;
        }, 3000);
    }
};

// Partager sur WhatsApp
const shareOnWhatsApp = () => {
    const url = `https://wa.me/?text=${encodeURIComponent(shareMessage.value + ' ' + shareLink.value)}`;
    window.open(url, '_blank');
};

// Partager par email
const shareByEmail = () => {
    const subject = `Annonce immobilière : ${props.property.categorie}`;
    const body = `${shareMessage.value}\n\n${shareLink.value}\n\n${props.property.description?.substring(0, 200)}...`;
    const url = `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
    window.location.href = url;
};

// Partager sur Facebook
const shareOnFacebook = () => {
    const url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareLink.value)}`;
    window.open(url, '_blank', 'width=600,height=400');
};

// Partager sur LinkedIn
const shareOnLinkedIn = () => {
    const url = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(shareLink.value)}`;
    window.open(url, '_blank');
};

// Partager sur Twitter
const shareOnTwitter = () => {
    const text = `${shareMessage.value}`;
    const url = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(shareLink.value)}`;
    window.open(url, '_blank');
};

// Partager sur Telegram
const shareOnTelegram = () => {
    const url = `https://t.me/share/url?url=${encodeURIComponent(shareLink.value)}&text=${encodeURIComponent(shareMessage.value)}`;
    window.open(url, '_blank');
};

// Partager par SMS
const shareBySMS = () => {
    const url = `sms:?body=${encodeURIComponent(shareMessage.value + ' ' + shareLink.value)}`;
    window.location.href = url;
};

// Générer QR Code (optionnel - nécessite une librairie)
const generateQRCode = async () => {
    // Vous pouvez utiliser une librairie comme qrcode.js si nécessaire
    // Pour l'instant, on laisse un placeholder
};

onMounted(() => {
    // Générer le QR code quand le composant est monté
    generateQRCode();
});
</script>

<style scoped>
.share-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    backdrop-filter: blur(4px);
}

.share-menu {
    background: white;
    border-radius: 16px;
    padding: 24px;
    max-width: 500px;
    width: 90%;
    max-height: 80vh;
    overflow-y: auto;
    z-index: 999;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.dark .share-menu {
    background: #1f2937;
    color: white;
}

.share-header {
    display: flex;
    justify-content: between;
    align-items: center;
    margin-bottom: 20px;
}

.close-btn {
    background: none;
    border: none;
    font-size: 1.25rem;
    color: #6b7280;
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
}

.close-btn:hover {
    background: #f3f4f6;
}

.dark .close-btn:hover {
    background: #374151;
}

.share-options {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.share-link-section {
    margin-bottom: 10px;
}

.link-copy {
    display: flex;
    gap: 8px;
}

.copy-btn {
    white-space: nowrap;
}

.quick-share-options {
    margin-bottom: 10px;
}

.share-option-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 12px 8px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
    font-size: 0.75rem;
    font-weight: 500;
}

.share-option-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.qr-code-section {
    margin-top: 10px;
}

.qr-code-container {
    min-height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Responsive */
@media (max-width: 640px) {
    .share-menu {
        padding: 16px;
        margin: 16px;
    }

    .quick-share-options .grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>
