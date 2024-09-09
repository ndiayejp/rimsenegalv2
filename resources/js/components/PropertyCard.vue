<template>
    <div
        class="rounded-md border-2 hover:border-primary border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800"
    >
        <div class="h-52 w-full">
            <a href="#">
                <img
                    class="mx-auto rounded-t w-full h-full"
                    :src="property.thumb || '../images/noimage.jpg'"
                    @error="handleImageError"
                />
            </a>
        </div>
        <div class="p-6">
            <a
                href="#"
                class="text-lg font-semibold leading-tight text-gray-900 hover:underline dark:text-white"
            >
                {{ property.categorie }}
            </a>
            <ul class="mt-2 flex items-center gap-4">
                <li class="flex items-center gap-2">
                    <i class="fas fa-map-pin text-gray-600"></i>
                    <p
                        class="text-sm font-medium text-gray-500 dark:text-gray-400"
                    >
                        {{
                            property.localisation.quartier
                                ? property.localisation.quartier + " - "
                                : ""
                        }}{{ property.localisation.ville }}
                    </p>
                </li>
            </ul>

            <div class="mt-4 flex items-center justify-between gap-4">
                <p
                    class="text-lg font-extrabold leading-tight text-primary dark:text-white"
                >
                    {{ formatPrice(property.price) }}
                </p>
                <button
                    type="button"
                    @click="openModal"
                    class="inline-flex group-hover:bg-secondary hover:bg-secondary hover:bg-yellow bg-primary text-white rounded px-1.5 py-1.5 items-center justify-center font-medium hover:text-primary dark:text-primary"
                >
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
    </div>

    <div
        v-if="isModalOpen"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    >
        <div
            class="relative bg-white rounded-lg p-6 max-w-7xl mx-auto dark:bg-gray-800"
        >
            <button
                type="button"
                @click="isModalOpen = !isModalOpen"
                class="absolute top-3 right-2.5 bg-primary px-1.5 py-2.5 text-white hover:bg-secondary hover:text-primary rounded text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-hide="progress-modal"
            >
                <i class="fas fa-close"></i>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="flex flex-col md:flex-row gap-10">
                <div>
                    <h2
                        class="text-lg font-bold mb-4 dark:text-white text-primary"
                    >
                        Détails de l'annonce
                    </h2>
                    <p class="mb-4 text-gray-700 dark:text-gray-300">
                        {{ property.categorie }}
                    </p>
                    <p class="mb-4 text-gray-700 dark:text-gray-300">
                        <i class="fas fa-map-pin"></i>
                        {{
                            property.localisation.quartier
                                ? property.localisation.quartier + " - "
                                : ""
                        }}{{ property.localisation.ville }}
                    </p>
                    <p class="mb-4 text-gray-700 dark:text-gray-300">
                        <strong>Prix:</strong>
                        {{ formatPrice(property.price) }}
                    </p>
                    <p class="mb-4 text-gray-700 dark:text-gray-300">
                        {{ property.description }}
                    </p>
                    <h2 class="text-gray-600 font-bold text-lg text-primary">
                        Galerie
                    </h2>
                    <div class="flex flex-wrap items-center gap-2 mt-4">
                        <img
                            v-for="(image, index) in filteredImages"
                            :key="index"
                            :src="image"
                            alt="Thumbnail"
                            class="w-16 h-16 object-cover cursor-pointer rounded"
                            @click="openLightbox(index)"
                            @error="markImageAsBroken(index)"
                        />
                    </div>
                </div>
            </div>

            <button
                @click="isModalOpen = !isModalOpen"
                class="mt-4 bg-primary text-white py-2 px-4 rounded hover:bg-secondary hover:text-primary"
            >
                Fermer
            </button>
        </div>
    </div>
    <!-- Lightbox for displaying large images -->
    <div
        v-if="isLightboxOpen"
        class="fixed inset-0 z-50 bg-black bg-opacity-80 flex items-center justify-center"
    >
        <button
            @click="closeLightbox"
            class="absolute top-4 right-4 text-white text-2xl"
        >
            ✕
        </button>

        <button @click="prevImage" class="absolute left-4 text-white text-3xl">
            ❮
        </button>

        <img
            :src="property.images[currentImageIndex]"
            class="max-w-4xl max-h-screen object-cover"
            alt="Large Image"
        />

        <button @click="nextImage" class="absolute right-4 text-white text-3xl">
            ❯
        </button>
    </div>
</template>

<script setup>
import { onMounted, ref, toRefs, computed } from "vue";
const props = defineProps({
    property: Object,
});

const { property } = toRefs(props);

const isModalOpen = ref(false);
const isLightboxOpen = ref(false);
const currentImageIndex = ref(0);

const selectedImage = ref(null);

const brokenImages = ref([]);

const handleImageError = (event) => {
    event.target.src = "/images/noimage.jpg";
};

const formatPrice = (price, locale = "fr-FR") => {
    if (!price) return "";
    // Remove any non-numeric characters (including spaces, FCFA, etc.)
    const numericPrice = parseInt(price.replace(/[^\d]/g, ""), 10);
    const formattedNumber = new Intl.NumberFormat(locale).format(numericPrice);
    return `${formattedNumber} FCFA`;
};

const filteredImages = computed(() => {
    return property.value.images.filter(
        (image, index) =>
            /\.(png|jpg)$/i.test(image) && !brokenImages.value.includes(index)
    );
});

const markImageAsBroken = (index) => {
    brokenImages.value.push(index); // Mark the image as broken
};

const openModal = () => {
    isModalOpen.value = true;
};

const openLightbox = (index) => {
    currentImageIndex.value = index; // Set the current image index
    isLightboxOpen.value = true; //
};

const closeLightbox = () => {
    isLightboxOpen.value = false; // Hide the lightbox
};

const prevImage = () => {
    currentImageIndex.value =
        (currentImageIndex.value - 1 + property.value.images.length) %
        property.value.images.length;
};

const nextImage = () => {
    currentImageIndex.value =
        (currentImageIndex.value + 1) % property.value.images.length;
};

onMounted(() => {
    selectedImage.value =
        property.thumb ||
        (property.images && property.images[0]) ||
        "/images/noimage.jpg";
});
</script>
