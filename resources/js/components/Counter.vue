<template>
    <div class="mx-auto text-center lg:mb-8 mb-10">
        <h2 class="mb-4 text-3xl lg:text-4xl tracking-tight font-extrabold text-gray-800 dark:text-white">
            <strong class="text-primary">{{ filteredProperties . length }}</strong>
            biens disponibles à la <span class="text-primary">vente</span> et à
            la <span class="text-primary">location</span>
        </h2>
    </div>

    <div class="bg-white rounded dark:bg-gray-800 relative shadow-sm border overflow-hidden">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
            <div class="w-full md:w-1/2">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-map-pin text-primary"></i>
                    </div>
                    <input v-model="filters.city" type="text"
                        class="bg-white font-bold border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Dans quelle ville ? Quartier ?" />
                </div>
            </div>
            <div
                class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                <div class="flex items-center space-x-3 w-full md:w-auto">
                    <div>
                        <select v-model="filters.category"
                            class="bg-white font-bold border border-gray-300 text-gray-600 text-sm rounded focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="">Familles de biens</option>
                            <option :value="category" v-for="category in allCategories" :key="category">
                                {{ category }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <select v-model="filters.transaction"
                            class="bg-white font-bold border border-gray-300 text-gray-600 text-sm rounded focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="">Type de recherche</option>
                            <option value="Location">Location</option>
                            <option value="Vente">Vente</option>
                        </select>
                    </div>
                    <div>
                        <input v-model="filters.maxPrice" type="number" name="price" min="0"
                            class="bg-white font-bold border border-gray-300 text-gray-600 text-sm rounded focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Budget maximum" />
                    </div>
                    <div>
                        <input v-model="filters.nbPieces" type="number" name="nbpiece" min="0"
                            class="bg-white font-bold border border-gray-300 text-gray-600 text-sm rounded focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Nombre de pièces" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-gray-600 py-5 flex justify-end">
        <select @onchange="filteredProperties" v-model="sortOption"
            class="text-gray-600 font-bold rounded border text-sm border-gray-300 focus:ring-primary-600 focus:border-primary-600 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            <option value="">Trier par:</option>
            <option value="priceAsc">Prix croissant</option>
            <option value="priceDesc">Prix décroissant</option>
            <option value="date">Date de parution</option>
        </select>
    </div>
    <section class="bg-gray-50 antialiased dark:bg-gray-900">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Colonne de gauche : Liste des annonces -->
            <div class="w-full lg:w-1/2 bg-white shadow p-4 rounded overflow-auto max-h-screen">
                <div class="mx-auto max-w-7xl 2xl:px-0">
                    <div v-if="loading || isFiltering" class="flex items-center justify-center w-full">
                        <div role="status">
                            <svg aria-hidden="true"
                                class="w-16 h-16 text-gray-200 animate-spin dark:text-gray-600 fill-primary"
                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor" />
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="currentFill" />
                            </svg>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div v-else class="mb-5">
                        <template v-if="paginateData.length === 0">
                            <!-- No results message -->
                            <div class="text-center w-full col-span-4">
                                <p
                                    class="flex items-center justify-center gap-2 text-gray-600 font-bold dark:text-gray-300">
                                    <i class="fas fa-circle-exclamation text-red-600"></i>
                                    Aucun bien ne correspond à votre recherche.
                                </p>
                            </div>
                        </template>
                        <template v-else>
                            <ul>
                                <li v-for="property in paginateData" :key="property.id"
                                    :class="{ 'border-primary border-2': selectedProperty && selectedProperty.id === property
                                        .id }"
                                    class="py-3 sm:py-4 cursor-pointer border p-5 rounded-md hover:border-primary hover:border-2 my-3"
                                    @click="selectProperty(property)">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <img class="w-20 h-16 rounded-lg"
                                                :src="property.thumb ||
                                                    '../images/no-image.png'"
                                                @error="handleImageError" />
                                        </div>
                                        <div class="flex-1 min-w-0 ms-4">
                                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                {{ property . categorie }}
                                            </p>
                                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                {{ property . transaction }}
                                                {{ property . localisation . quartier ? ' - ' + property . localisation . quartier + ' - ' : '' }}{{ property . localisation . ville }}
                                            <div class="flex items-center my-2 gap-3">
                                                <span v-if="property.nbchambres !== '0'"
                                                    class="w-16 rounded py-1 bg-gray-50 flex items-center justify-center gap-2">
                                                    {{ property . nbchambres }} <i class="fas fa-bed"></i></span>
                                                <span v-if="property.nbpieces !== '0'"
                                                    class="w-16 rounded py-1 bg-gray-50 flex items-center justify-center gap-2">
                                                    {{ property . nbpieces }} <i
                                                        class="fas fa-arrow-up-right-from-square"></i></span>
                                                <span
                                                    class="w-16 rounded py-1 bg-gray-50 flex items-center justify-center gap-2"
                                                    v-if="property.surface && property.surface!=0">
                                                    {{ property . surface }} m²
                                                </span>
                                            </div>
                                            </p>
                                        </div>
                                        <div
                                            class="inline-flex items-center text-base font-bold text-primary dark:text-white">
                                            {{ formatPrice(property . price) }}
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </template>
                    </div>
                    <div v-if="!loading" class="mt-6 flex items-center justify-center">
                        <button
                            class="mx-2 px-4 py-2 font-bold bg-primary hover:bg-secondary hover:text-primary text-white rounded disabled:opacity-50"
                            @click="prevPage" :disabled="currentPage === 1">
                            Précédent
                        </button>
                        <span class="mx-4 text-lg font-bold text-gray-600">Page {{ currentPage }} of
                            {{ totalPages }}</span>
                        <button
                            class="mx-2 px-4 py-2 font-bold bg-primary hover:bg-secondary hover:text-primary text-white rounded disabled:opacity-50"
                            @click="nextPage" :disabled="currentPage === totalPages">
                            Suivant
                        </button>
                    </div>
                </div>
            </div>
            <!-- Colonne de droite : Détails de l'annonce -->
            <div class="w-full lg:w-1/2 bg-white p-4 rounded shadow">
                <div v-if="selectedProperty">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold mb-4 dark:text-white text-primary">
                            Détails de l'annonce
                            <span class="block text-sm text-gray-500">Référence:
                                {{ selectedProperty . reference }}</span>
                        </h2>
                        <div class="mb-4 text-gray-700 dark:text-gray-300">
                            <h3 class="text-lg"><span
                                    class="text-primary">{{ selectedProperty . categorie + ' en ' + selectedProperty . transaction }}</span>
                            </h3>
                            <div class="mb-4 text-gray-700 dark:text-gray-300">
                                <i class="fas fa-map-pin text-primary"></i>
                                {{ selectedProperty . localisation . quartier ? selectedProperty . localisation . quartier + ' - ' : '' }}{{ selectedProperty . localisation . ville }}
                            </div>
                        </div>

                    </div>
                    <template v-if="filteredImages.length > 0">
                        <h2 class="font-bold text-xl text-primary">Galerie</h2>
                        <div class="flex flex-wrap items-center gap-2 mt-4">
                            <img v-for="(image, index) in filteredImages" :key="index" :src="image"
                                alt="Thumbnail" class="w-16 h-16 object-cover cursor-pointer rounded"
                                @click="openLightbox(index)" @error="markImageAsBroken(index)" />
                        </div>
                    </template>
                    <h2 v-if="selectedProperty.nbchambres || selectedProperty.nbpieces ||  selectedProperty.surface"
                        class="font-bold text-xl text-primary my-4">Caractéristiques</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div class="text-gray-600 border rounded p-3 mb-5"
                            v-if="selectedProperty.nbchambres && selectedProperty.nbchambres !=0">
                            <h2 class="font-semibold text-md"> Nbre Chambres</h2>
                            {{ selectedProperty . nbchambres }}
                        </div>
                        <div class="text-gray-600 border rounded p-3 mb-5"
                            v-if="selectedProperty.nbpieces && selectedProperty.nbpieces!=0">
                            <h2 class="font-semibold text-md"> Nbre pièces</h2>
                            {{ selectedProperty . nbpieces }}
                        </div>
                        <div class="text-gray-600 border rounded p-3 mb-5"
                            v-if="selectedProperty.surface && selectedProperty.surface!=0">
                            <h2 class="font-semibold text-md">Surface habitable</h2>
                            {{ selectedProperty . surface }} m²
                        </div>
                    </div>
                    <p class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-300">
                        <strong>Prix: {{ formatPrice(selectedProperty . price) }}</strong>
                    </p>
                    <h2 class="font-bold text-xl text-primary mb-4">Description</h2>
                    <p class="mb-4 text-gray-700 dark:text-gray-300">
                        {{ selectedProperty . description }}
                    </p>
                    <h2 class="font-bold text-xl text-primary mb-4">Emplacement</h2>
                    <div id="map" class="w-full h-72"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- Lightbox for displaying large images -->
    <div v-if="isLightboxOpen" class="fixed inset-0 z-50 bg-black bg-opacity-80 flex items-center justify-center">
        <button @click="closeLightbox" class="absolute top-4 right-4 text-white text-2xl">
            <i class="fas fa-xmark"></i>
        </button>

        <button @click="prevImage" class="absolute left-4 text-white text-3xl">
            <i class="fas fa-chevron-left"></i>
        </button>

        <img :src="selectedProperty.images[currentImageIndex]" class="max-w-4xl max-h-screen object-cover"
            alt="Large Image" />

        <button @click="nextImage" class="absolute right-4 text-white text-3xl">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</template>
<style>
    .mapboxgl-popup-content {
        color: #000;
    }
</style>
<script setup>
    import {
        ref,
        onMounted,
        computed,
        watch
    } from "vue";
    import axios from "axios";
    import mapboxgl from 'mapbox-gl';
    import MapboxGeocoder from '@mapbox/mapbox-gl-geocoder';
    const datas = ref([]);
    const loading = ref(true);
    const isFiltering = ref(false);
    const currentPage = ref(1);
    const itemsPerPage = 20;
    const sortOption = ref("");
    const selectedProperty = ref(null);
    const isModalOpen = ref(false);
    const isLightboxOpen = ref(false);
    const currentImageIndex = ref(0);
    const map = ref(null);
    const geocoder = ref(null);
    const selectedImage = ref(null);

    mapboxgl.accessToken = 'pk.eyJ1IjoibmRpYXllanAiLCJhIjoiY2p4YWI1bDJpMDBsdzNxcWl3NjU3Znd4YSJ9.15lXtSdUn6ucBGQGs9rhTw';

    // Filters reactive properties
    const filters = ref({
        city: "",
        category: "",
        transaction: "",
        maxPrice: null,
        nbPieces: null,
    });

    const brokenImages = ref([]);

    const paginateData = computed(() => {
        const start = (currentPage.value - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        return filteredProperties.value.slice(start, end);
    });

    const filteredProperties = computed(() => {
        let filtered = datas.value.filter((property) => {
            const cityMatch = !filters.value.city ||
                (property.localisation.quartier &&
                    property.localisation.quartier
                    .toLowerCase()
                    .includes(filters.value.city.toLowerCase()));
            const categoryMatch = !filters.value.category ||
                property.categorie === filters.value.category;
            const transactionMatch = !filters.value.transaction ||
                property.transation === filters.value.transaction;
            const priceMatch = !filters.value.maxPrice ||
                parseFloat(property.price.replace(/[^\d]/g, "")) <=
                filters.value.maxPrice;
            const propertyNbPieces = property.nbpieces ?
                parseInt(property.nbpieces.match(/\d+/)?.[0], 10) ||
                0 // Extract number or fallback to 0
                :
                0;
            const nbPiecesMatch = !filters.value.nbPieces ||
                propertyNbPieces >= filters.value.nbPieces;
            return (
                cityMatch &&
                categoryMatch &&
                transactionMatch &&
                priceMatch &&
                nbPiecesMatch
            );
        });
        if (sortOption.value === "priceAsc") {
            filtered.sort((a, b) => parseFloat(a.price) - parseFloat(b.price));
        } else if (sortOption.value === "priceDesc") {
            filtered.sort((a, b) => parseFloat(b.price) - parseFloat(a.price));
        } else if (sortOption.value === "date") {
            filtered.sort((a, b) => new Date(b.date) - new Date(a.date));
        }
        return filtered;
    });


    const initializeMap = () => {
        if (map.value) return; // Prevent map reinitialization

        const propLatLng = [selectedProperty.value.localisation.longitude, selectedProperty.value.localisation
            .latitude
        ]
        // Initialize the map
        map.value = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v10',
            center: propLatLng, // Use lng/lat from property
            zoom: 15
        });

        // Add geocoder (optional if you want search functionality)
        geocoder.value = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl,
            marker: false
        });

        const popup = new mapboxgl.Popup({
            offset: 25
        }).setText(selectedProperty.value.localisation.quartier);

        // Add a marker at the property's location
        new mapboxgl.Marker()
            .setLngLat(propLatLng)
            .setPopup(popup)
            .addTo(map.value);
    };

    const markImageAsBroken = (index) => {
        brokenImages.value.push(index); // Mark the image as broken
    };

    const allCategories = computed(() => {
        const categories = datas.value.map((property) => property.categorie);
        return [...new Set(categories)].filter((category) => category); // Remove duplicates and falsy values
    });

    const filteredImages = computed(() => {
        return selectedProperty.value.images.filter(
            (image, index) =>
            /\.(png|jpg)$/i.test(image) && !brokenImages.value.includes(index)
        );
    });

    const totalPages = computed(() => {
        return Math.ceil(filteredProperties.value.length / itemsPerPage);
    });

    const nextPage = () => {
        if (currentPage.value < totalPages.value) {
            currentPage.value++;
        }
    };

    const prevPage = () => {
        if (currentPage.value > 1) {
            currentPage.value--;
        }
    };

    const transformString = (str) => {
        const firstSpaceIndex = str.indexOf(" ");
        if (firstSpaceIndex !== -1) {
            return (
                str.slice(0, firstSpaceIndex) + "_" + str.slice(firstSpaceIndex + 1)
            );
        }
        return str;
    };

    const formatPrice = (price, locale = "fr-FR") => {
        if (!price) return "";
        // Remove any non-numeric characters (including spaces, FCFA, etc.)
        const numericPrice = parseInt(price.replace(/[^\d]/g, ""), 10);
        const formattedNumber = new Intl.NumberFormat(locale).format(numericPrice);
        return `${formattedNumber} FCFA`;
    };

    const formatContent = (content) => {
        if (!content) return "";
        return content.replace(/\n/g, " ").replace(/\\/g, "");
    };

    const handleImageError = (event) => {
        event.target.src = "/images/noimage.jpg";
    };

    const selectProperty = (property) => {
        selectedProperty.value = property;
    };

    const openModal = () => {
        isModalOpen.value = true;
        setTimeout(() => {
            initializeMap();
        }, 300);
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
            (currentImageIndex.value - 1 + selectedProperty.value.images.length) %
            property.value.images.length;
    };

    const nextImage = () => {
        currentImageIndex.value =
            (currentImageIndex.value + 1) % selectedProperty.value.images.length;
    };

    watch(
        filters,
        () => {
            currentPage.value = 1; // Reset to first page when filters are changed
            isFiltering.value = true;
            setTimeout(() => {
                isFiltering.value = false; // Stop the loader when filtering is done
            }, 500);
        }, {
            deep: true
        }
    );

    watch(selectedProperty, (newProperty) => {
        console.log(newProperty)
        if (newProperty && map.value) {
            const propLatLng = [
                parseFloat(newProperty.localisation.longitude),
                parseFloat(newProperty.localisation.latitude)
            ];
            console.log(propLatLng)

            // Update the map center and add a new marker
            map.value.setCenter(propLatLng);

            const popup = new mapboxgl.Popup({
                offset: 25
            }).setText(
                newProperty.localisation.quartier || newProperty.localisation.ville
            );

            // Add a new marker at the new location
            new mapboxgl.Marker()
                .setLngLat(propLatLng)
                .setPopup(popup)
                .addTo(map.value);
        }
    });



    onMounted(async () => {
        selectedImage.value =
            selectedProperty.thumb ||
            (selectedProperty.images && selectedProperty.images[0]) ||
            "/images/noimage.jpg";

        try {
            const response = await axios.get(
                "https://www3.pagesimmo.net/chercher_Annonces.ashx?C1=AN5C3D7Z7HEL&C_Rest=Avec_Fichiers%7C!%7Ctrue&Avec_Donnees_Complementaires%7C!%7Ctrue&Avec_Donnees_Confidentielles%7C!%7Ctrue&C_Rest=Bien_DU_AU%7C!%7C0,100000", {
                    headers: {
                        "Content-Type": "application/xml",
                    },
                }
            );
            const xmlData = response.data;
            const parser = new DOMParser();
            const xmlDoc = parser.parseFromString(xmlData, "application/xml");

            // Fonction pour convertir le XML en objet JSON
            const xmlToJson = (xml) => {
                let obj = {};
                if (xml.nodeType === 1) {
                    if (xml.attributes.length > 0) {
                        obj["@attributes"] = {};
                        for (let j = 0; j < xml.attributes.length; j++) {
                            const attribute = xml.attributes.item(j);
                            obj["@attributes"][attribute.nodeName] =
                                attribute.nodeValue;
                        }
                    }
                } else if (xml.nodeType === 3) {
                    obj = xml.nodeValue;
                }

                if (xml.hasChildNodes()) {
                    for (let i = 0; i < xml.childNodes.length; i++) {
                        const item = xml.childNodes.item(i);
                        const nodeName = item.nodeName;
                        if (typeof obj[nodeName] === "undefined") {
                            obj[nodeName] = xmlToJson(item);
                        } else {
                            if (typeof obj[nodeName].push === "undefined") {
                                const old = obj[nodeName];
                                obj[nodeName] = [];
                                obj[nodeName].push(old);
                            }
                            obj[nodeName].push(xmlToJson(item));
                        }
                    }
                }
                return obj;
            };

            const findCategoryInObject = (obj) => {
                for (let key in obj) {
                    if (key.startsWith("CATEGORIE_")) {
                        return key.replace("CATEGORIE_", ""); // Extract the category part
                    } else if (typeof obj[key] === "object" && obj[key] !== null) {
                        const result = findCategoryInObject(obj[key]);
                        if (result) return result.replace("_", " ");
                    }
                }
                return null; // Return null if no category found
            };

            const jsonResult = xmlToJson(xmlDoc);
            console.log(jsonResult);
            if (
                jsonResult.ROOT &&
                jsonResult.ROOT.DESTINATAIRE.AGENCE.BIEN &&
                jsonResult.ROOT.DESTINATAIRE.AGENCE.BIEN
            ) {
                const bienItems = jsonResult.ROOT.DESTINATAIRE.AGENCE.BIEN;
                datas.value = [
                    ...bienItems.map((data) => {
                        const fichiers = Array.isArray(data.FICHIER) ?
                            data.FICHIER :
                            [data.FICHIER];
                        const images = fichiers
                            .map((fichier) => {
                                if (
                                    fichier &&
                                    fichier.FICHIER_JOINT &&
                                    fichier.FICHIER_JOINT.NOM_FICHIER
                                ) {
                                    return fichier.FICHIER_JOINT.NOM_FICHIER[
                                        "#text"
                                    ]; // URL de l'image
                                }
                                return null;
                            })
                            .filter((img) => img !== null)
                            .slice(1);
                        // Find the key that starts with 'CATEGORIE_'
                        let category = findCategoryInObject(data) || "AUTRE";
                        return {
                            id: data.REFERENCE ? data.REFERENCE["#text"] : "",

                            reference: data.REFERENCE ?
                                data.REFERENCE["#text"] :
                                "",
                            nbchambres: data[transformString(category)] &&
                                data[transformString(category)].NB_CHAMBRES ?
                                data[transformString(category)].NB_CHAMBRES[
                                    "#text"
                                ] :
                                "",
                            nbpieces: data[transformString(category)] &&
                                data[transformString(category)].NB_PIECES ?
                                data[transformString(category)].NB_PIECES[
                                    "#text"
                                ] :
                                "",
                            surface: data[transformString(category)] &&
                                data[transformString(category)].SURFACE_HABITABLE ?
                                data[transformString(category)]
                                .SURFACE_HABITABLE["#text"] :
                                "",
                            etage: data[transformString(category)] &&
                                data[transformString(category)].ETAGE ?
                                data[transformString(category)].ETAGE["#text"] :
                                "",
                            ascenseur: data[transformString(category)] &&
                                data[transformString(category)].ASCENSEUR ?
                                data[transformString(category)].ASCENSEUR[
                                    "#text"
                                ] :
                                "",
                            localisation: {
                                ville: data.LOCALISATION && data.LOCALISATION.VILLE ?
                                    data.LOCALISATION.VILLE["#text"] :
                                    "",
                                quartier: data.LOCALISATION && data.LOCALISATION.QUARTIER ?
                                    data.LOCALISATION.QUARTIER["#text"] :
                                    "",
                                cp: data.LOCALISATION && data.LOCALISATION.CP ?
                                    data.LOCALISATION.CP["#text"] :
                                    "",
                                latitude: data.LOCALISATION && data.LOCALISATION.LATITUDE ?
                                    data.LOCALISATION.LATITUDE["#text"] :
                                    "",
                                longitude: data.LOCALISATION && data.LOCALISATION.LONGITUDE ?
                                    data.LOCALISATION.LONGITUDE["#text"] :
                                    "",
                                pays: data.LOCALISATION && data.LOCALISATION.PAYS ?
                                    data.LOCALISATION.PAYS["#text"] :
                                    "",
                            },
                            price: (() => {
                                // Check if the price is in LOCATION or VENTE
                                if (
                                    data.LOCATION &&
                                    data.LOCATION.LOYER_MENSUEL_TTC
                                ) {
                                    return `${data.LOCATION.LOYER_MENSUEL_TTC["#text"]} F CFA`;
                                } else if (data.VENTE && data.VENTE.PRIX) {
                                    return `${data.VENTE.PRIX["#text"]} F CFA`;
                                } else {
                                    return "";
                                }
                            })(),
                            transaction: (() => {
                                if (data.LOCATION) {
                                    return "Location";
                                } else if (data.VENTE) {
                                    return "Vente";
                                } else {
                                    return "";
                                }
                            })(),
                            description: (() => {
                                // Check if the price is in LOCATION or VENTE
                                if (
                                    data.LOCATION &&
                                    data.LOCATION.TEXTES &&
                                    data.LOCATION.TEXTES.DESCRIPTION_FR
                                ) {
                                    return `${formatContent(
                                    data.LOCATION.TEXTES.DESCRIPTION_FR["#text"]
                                )}`;
                                } else if (
                                    data.VENTE &&
                                    data.VENTE.TEXTES &&
                                    data.VENTE.TEXTES.DESCRIPTION_FR
                                ) {
                                    return `${formatContent(
                                    data.LOCATION?.TEXTES.DESCRIPTION_FR[
                                        "#text"
                                    ]
                                )}`;
                                } else {
                                    return "";
                                }
                            })(),
                            categorie: category,
                            thumb: data.FICHIER &&
                                data.FICHIER[1] &&
                                data.FICHIER[1].FICHIER_JOINT &&
                                data.FICHIER[1].FICHIER_JOINT.NOM_FICHIER ?
                                data.FICHIER[1].FICHIER_JOINT.NOM_FICHIER[
                                    "#text"
                                ] :
                                null,
                            date_creation: data.DATE_CREATION ?
                                data.DATE_CREATION["#text"] :
                                "",
                            images: images,
                        };
                    }),
                ];
                selectedProperty.value = filteredProperties.value[0];
                if (selectedProperty.value) {
                    setTimeout(() => {
                        initializeMap(); // Initialize the map only after DOM is ready
                    }, 300); // Add a slight delay to ensure the DOM is fully rendered
                }
            } else {
                console.log("aucune donnée trouvée...");
            }
        } catch (error) {
            console.log(error);
        } finally {
            loading.value = false; // Stop loading after data is fetched
        }
    });
</script>
