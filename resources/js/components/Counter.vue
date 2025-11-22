 <template>
    <!-- Hero Section avec gradient -->
    <div class="bg-gradient-to-br from-[#008dcf] via-[#0099dc] to-[#00a8e8] overflow-hidden relative text-center leading-none text-white py-24 dark:text-white">
        <!-- Formes géométriques animées en arrière-plan -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-10 -right-10 w-72 h-72 bg-secondary opacity-15 rounded-full"></div>
            <div class="absolute top-1/2 -left-20 w-96 h-96 bg-white opacity-15 rounded-full"></div>
            <div class="absolute bottom-0 right-1/3 w-48 h-48 bg-secondary opacity-15 rounded-full"></div>
        </div>

        <div class="relative z-10 max-w-6xl mx-auto px-4">
            <div class="animate-fade-in-up">
                <div class="text-xl md:text-2xl font-light mt-10 opacity-90">
                    <strong class="text-3xl md:text-4xl font-bold text-[#fff02a]">{{  computedProps.filteredProperties.value.length > 0 ? computedProps.filteredProperties.value.length : 'Aucun'  }}</strong>
                    <span class="ml-2">
                        {{ computedProps.filteredProperties.value.length === 1 ? 'Bien disponible' : 'Biens disponibles' }}
                        à la vente ou à la location
                    </span>
                </div>
                <div class="inline-flex items-center space-x-2 bg-white/20 backdrop-blur-sm rounded-full px-6 py-3 text-sm font-medium">
                    <div class="w-2 h-2 bg-[#fff02a] rounded-full animate-pulse"></div>
                    <span>Mis à jour en temps réel</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-screen-2xl mx-auto px-4 py-8">
            <!-- Barre de recherche -->
            <div class="relative -mt-16 z-20 mb-12">
                <div class="bg-white dark:bg-gray-800 rounded-md shadow-sm border border-gray-100 dark:border-gray-700 p-6 backdrop-blur-lg bg-opacity-95 sticky top-4 transition-all duration-300">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-3 h-3 bg-primary rounded-full animate-pulse"></div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                            Recherche intelligente
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        <!-- Champ ville avec icône -->
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                               <font-awesome-icon  icon="fa-solid fa-map-marker-alt" class="text-gray-500 group-focus-within:text-primary transition-colors text-sm"/>
                            </div>
                            <input
                                v-model="filters.city"
                                type="text"
                                class="w-full pl-12 pr-4 py-4 rounded-md border-2 border-gray-200 dark:border-gray-700 focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all duration-300 bg-white dark:bg-gray-800 text-gray-500 dark:text-white placeholder-gray-500"
                                placeholder="Ville, quartier..."
                            />
                        </div>

                        <!-- Select type -->
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <font-awesome-icon icon="fa-solid fa-home" class="text-gray-500 text-sm group-focus-within:text-primary transition-colors " />
                            </div>
                            <select
                                v-model="filters.category"
                                class="w-full pl-12 py-4 rounded-md border-2 border-gray-200 dark:border-gray-700 focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all duration-300 bg-white dark:bg-gray-800 text-gray-500 dark:text-white appearance-none cursor-pointer"
                            >
                                <option value="">  Type de bien</option>
                                <option :value="category" v-for="category in computedProps.allCategories.value" :key="category">
                                    {{ category }}
                                </option>
                            </select>
                        </div>

                        <!-- Select transaction -->
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <font-awesome-icon icon="fa-solid fa-handshake"  class="text-gray-500 text-sm group-focus-within:text-primary transition-colors" />
                            </div>
                            <select
                                v-model="filters.transaction"
                                class="w-full pl-12 py-4 rounded-md border-2 border-gray-200 dark:border-gray-700 focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all duration-300 bg-white dark:bg-gray-800 text-gray-500 dark:text-white appearance-none cursor-pointer"
                            >
                                <option value="">Transaction</option>
                                <option value="Location">Location</option>
                                <option value="Vente">Vente</option>
                            </select>
                        </div>

                        <!-- Budget avec icône -->
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-gray-500 group-focus-within:text-primary transition-colors"><font-awesome-icon icon="fa-solid fa-money-check"  class="text-gray-500 text-sm group-focus-within:text-primary transition-colors" /></span>
                            </div>
                            <input
                                v-model="filters.maxPrice"
                                type="number"
                                min="0"
                                class="w-full pl-10 pr-4 py-4 rounded-md border-2 border-gray-200 dark:border-gray-700 focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all duration-300 bg-white dark:bg-gray-800 text-gray-500 dark:text-white placeholder-gray-500"
                                placeholder="Budget max"
                            />
                        </div>

                        <!-- Nombre de pièces -->
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <font-awesome-icon icon="fa-solid fa-building"  class="text-gray-500 text-sm group-focus-within:text-primary transition-colors" />
                            </div>
                            <input
                                v-model="filters.nbPieces"
                                type="number"
                                min="0"
                                class="w-full pl-12 pr-4 py-4 rounded-md border-2 border-gray-200 dark:border-gray-700 focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all duration-300 bg-white dark:bg-gray-800 text-gray-500 dark:text-white placeholder-gray-500"
                                placeholder="Nombre de pièces"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats et tri -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div class="flex items-center gap-4">
                    <div class="bg-white dark:bg-gray-800 rounded-md px-6 py-3 shadow-sm border border-gray-200 dark:border-gray-700">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Résultats:</span>
                        <span class="ml-2 font-bold text-primary dark:text-blue-400">
                            {{ computedProps.visibleProperties.value.length }} / {{ computedProps.filteredProperties.value.length }}
                        </span>
                        <span class="text-xs text-gray-400 ml-2" v-if="computedProps.filteredProperties.value.length > computedProps.visibleProperties.value.length">
                            (scroller pour voir plus)
                        </span>
                    </div>

                </div>
                <div class="relative">
                         <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <font-awesome-icon icon="fa-solid fa-sort" class="text-gray-500 text-sm" />
                        </div>
                    <select
                        v-model="sortOption"
                        class="pl-12 py-3 rounded-md border-2 border-gray-200 dark:border-gray-700 focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all duration-300 bg-white dark:bg-gray-800 text-gray-500 dark:text-white appearance-none cursor-pointer pr-12"
                    >
                        <option value="">Trier par</option>
                        <option value="priceAsc">Prix croissant</option>
                        <option value="priceDesc">Prix décroissant</option>
                        <option value="date">Plus récents</option>
                    </select>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Liste des biens -->
                <div class="order-2 lg:order-1">
                    <div class="bg-white dark:bg-gray-800 rounded-md shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-white dark:bg-gray-800 p-6 border-b border-gray-200 dark:border-gray-700 z-10">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                                <div class="w-2 h-2 bg-primary rounded-full animate-pulse"></div>
                                Biens disponibles
                            </h3>
                        </div>

                        <div class="h-[calc(190vh-10px)] overflow-y-auto custom-scrollbar" id="property-list">
                            <!-- Loading state  -->
                            <div v-if="loading || isFiltering" class="flex flex-col items-center justify-center h-64 p-6">
                                <div class="relative">
                                    <div class="w-16 h-16 border-4 border-primary/20 rounded-full animate-spin"></div>
                                    <div class="absolute top-0 left-0 w-16 h-16 border-t-4 border-primary rounded-full animate-spin"></div>
                                </div>
                                <p class="mt-4 text-gray-500 dark:text-gray-400 font-medium">Recherche en cours...</p>
                            </div>

                            <div v-else class="p-4">
                                <template v-if="computedProps.filteredProperties.value.length === 0">
                                    <div class="text-center py-16">
                                        <div class="w-24 h-24 mx-auto bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                            Aucun résultat trouvé
                                        </h3>
                                        <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-6">
                                            Aucun bien ne correspond à vos critères de recherche actuels.
                                        </p>
                                        <button
                                            @click="resetAllFilters"
                                            class="bg-gradient-to-r from-primary to-[#006a9a] text-white px-6 py-3 rounded-md font-medium hover:shadow-lg transition-all duration-300"
                                        >
                                            Réinitialiser les filtres
                                        </button>
                                    </div>
                                </template>
                                <!-- Liste des biens -->
                                <template v-else>
                                    <div class="space-y-4">
                                        <div
                                            v-for="property in computedProps.visibleProperties.value"
                                            :key="property.id"
                                            :data-property-id="property.id"
                                            @click="propertyMethods.selectProperty(property)"
                                            :class="{
                                                'ring-4 ring-primary/30 border-primary': selectedProperty && selectedProperty.id === property.id,
                                                'hover:shadow-xl hover:scale-[1.02]': true,
                                            }"
                                            class="bg-white dark:bg-gray-800 rounded-md overflow-hidden transition-all duration-300 cursor-pointer border-2 border-gray-100 dark:border-gray-700 group"
                                        >
                                            <div class="flex flex-col sm:flex-row">
                                                <!-- Image avec overlay -->
                                                <div class="relative sm:w-1/3 h-32 sm:h-48">
                                                    <img
                                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                                        :src="property.thumb || '../images/noimage.jpg'"
                                                        @error="imageMethods.handleImageError($event, property.id)"
                                                        alt="Image du bien"
                                                    />
                                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

                                                    <!-- Badge transaction -->
                                                    <div class="absolute top-4 left-4">
                                                        <div
                                                            class="px-3 py-1.5 rounded-full text-xs font-bold backdrop-blur-md"
                                                            :class="{
                                                                'bg-primary/90 text-white': property.transaction === 'Location',
                                                                'bg-secondary/90 text-gray-900': property.transaction === 'Vente',
                                                            }"
                                                        >
                                                            {{ property.transaction }}
                                                        </div>
                                                    </div>

                                                    <!-- Prix en overlay -->
                                                    <div class="absolute bottom-4 left-4">
                                                        <div class="bg-white/95 backdrop-blur-sm rounded-md px-3 py-2">
                                                            <span class="text-lg font-bold text-gray-900">
                                                                {{ utils.formatPrice(property.price) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Contenu -->
                                                <div class="p-6 sm:w-2/3 flex flex-col justify-between">
                                                    <div>
                                                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 group-hover:text-primary transition-colors">
                                                            {{ property.categorie }}
                                                        </h3>
                                                        <div class="flex items-center text-gray-500 dark:text-gray-400 mb-4">
                                                           <font-awesome-icon  icon="fa-solid fa-map-marker-alt" class="text-gray-400 group-focus-within:text-primary transition-colors text-sm"/>
                                                            {{ property?.localisation?.quartier || "Non précisé" }}
                                                        </div>
                                                    </div>

                                                    <!-- Caractéristiques avec icônes -->
                                                    <div class="flex flex-wrap gap-4">
                                                        <div v-if="property.nbchambres && property.nbchambres >0" class="flex items-center bg-gray-100 dark:bg-gray-700 rounded-md px-3 py-1.5">
                                                            <svg class="w-4 h-4 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2z" />
                                                            </svg>
                                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                                {{ property.nbchambres }} ch.
                                                            </span>
                                                        </div>
                                                        <div v-if="property.nbpieces && property.nbpieces >0" class="flex items-center bg-gray-100 dark:bg-gray-700 rounded-md px-3 py-1.5">
                                                            <svg class="w-4 h-4 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                            </svg>
                                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                                {{ property.nbpieces }} pièces
                                                            </span>
                                                        </div>
                                                        <div v-if="property.surface && property.surface > 0" class="flex items-center bg-gray-100 dark:bg-gray-700 rounded-md px-3 py-1.5">
                                                            <svg class="w-4 h-4 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                                                            </svg>
                                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                                {{ property.surface }} m²
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Sentinel pour scroll infini -->
                                    <div id="sentinel" class="flex items-center justify-center py-6">
                                        <div v-if="isLoadingMore" class="flex items-center gap-3">
                                            <div class="w-6 h-6 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
                                            <span class="text-gray-500 dark:text-gray-400">Chargement...</span>
                                        </div>
                                    </div>

                                    <!-- Messages de fin -->
                                    <div v-if="computedProps.visibleProperties.length < computedProps.filteredProperties.length" class="text-center py-6">
                                        <p class="text-gray-500 dark:text-gray-400">Faites défiler pour voir plus de biens</p>
                                    </div>
                                    <div v-else-if="computedProps.filteredProperties.length > 0" class="text-center py-6">
                                        <div class="inline-flex items-center gap-2 bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 px-4 py-2 rounded-full">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Tous les biens ont été affichés
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Détails du bien  -->
                <div class="order-1 lg:order-2">
                    <div class="sticky top-8">
                        <div v-if="selectedProperty"  class="bg-white dark:bg-gray-800 rounded-md shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700">
                            <!-- En-tête avec gradient -->
                            <div class="bg-gradient-to-r from-primary to-[#006a9a] p-8 text-white">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-4">
                                            <div
                                                class="px-4 py-2 rounded-full text-sm font-bold bg-white/20"
                                                :class="{
                                                    '': selectedProperty.transaction === 'Location',
                                                    '': selectedProperty.transaction === 'Vente',
                                                }"
                                            >
                                                {{ selectedProperty.transaction }}
                                            </div>
                                            <div class="bg-white/20 backdrop-blur-md px-3 py-1 rounded-full text-sm">
                                                Réf: {{ selectedProperty.reference }}
                                            </div>
                                        </div>
                                        <h2 class="text-2xl sm:text-lg md:text-xl lg:text-3xl font-bold mb-2">
                                            {{ selectedProperty.categorie }}
                                        </h2>
                                        <div class="flex items-center text-blue-100 text-lg">
                                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            </svg>
                                            {{ selectedProperty.localisation.quartier }}, {{ selectedProperty.localisation.ville }}
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="bg-white/20 backdrop-blur-md rounded-2xl p-4">
                                            <div class="text-2xl sm:text-lg md:text-xl lg:text-3xl font-bold">
                                                {{ utils.formatPrice(selectedProperty.price) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Caractéristiques  -->
                            <div class="p-8 -mt-4 relative">
                                <div v-if="selectedProperty.nbchambres >0 && selectedProperty.nbpieces >0 && selectedProperty.surface >0" class="bg-white dark:bg-gray-800 rounded-md p-6 shadow-lg border border-gray-100 dark:border-gray-700 mb-8">
                                    <h3  class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                                        <div class="w-2 h-2 bg-primary rounded-full"></div>
                                        Caractéristiques principales
                                    </h3>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                                        <div v-if="selectedProperty.nbchambres >0" class="text-center">
                                            <div class="w-16 h-16 bg-primary/10 rounded-xl flex items-center justify-center mx-auto mb-3">
                                                <svg class="w-8 h-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2z" />
                                                </svg>
                                            </div>
                                            <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                                {{ selectedProperty.nbchambres }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                Chambres
                                            </div>
                                        </div>
                                        <div v-if="selectedProperty.nbpieces >0" class="text-center">
                                            <div class="w-16 h-16 bg-secondary/10 rounded-md flex items-center justify-center mx-auto mb-3">
                                                <svg class="w-8 h-8 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                            </div>
                                            <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                                {{ selectedProperty.nbpieces }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                Pièces
                                            </div>
                                        </div>
                                        <div v-if="selectedProperty.surface && selectedProperty.surface > 0" class="text-center">
                                            <div class="w-16 h-16 bg-primary/10 rounded-md flex items-center justify-center mx-auto mb-3">
                                                <svg class="w-8 h-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                                                </svg>
                                            </div>
                                            <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                                {{ selectedProperty.surface }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                m² Surface
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Galerie photos  -->
                                <div v-if="computedProps.filteredImages.value.length > 0" class="mb-8">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                                        <div class="w-2 h-2 bg-secondary rounded-full"></div>
                                        Galerie photos
                                        <span class="text-sm font-normal text-gray-500">({{ computedProps.filteredImages.value.length }})</span>
                                    </h3>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div
                                            v-for="(image, index) in computedProps.filteredImages.value.slice(0, 4)"
                                            :key="index"
                                            @click="imageMethods.openLightbox(index)"
                                            class="relative group cursor-pointer overflow-hidden rounded-md"
                                            :class="{
                                                'col-span-2': index === 0,
                                                'h-64': index === 0,
                                                'h-32': index !== 0
                                            }"
                                        >
                                            <img
                                                :src="image"
                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                                :alt="`Photo ${index + 1} du bien`"
                                                @error="imageMethods.handleImageError($event, index)"
                                            />
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                                                <div class="transform scale-0 group-hover:scale-100 transition-transform duration-300">
                                                    <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Badge pour plus de photos -->
                                            <div v-if="index === 3 && computedProps.filteredImages.value.length > 4" class="absolute inset-0 bg-black/60 flex items-center justify-center">
                                                <div class="text-white text-center">
                                                    <div class="text-2xl font-bold">+{{ computedProps.filteredImages.value.length - 4 }}</div>
                                                    <div class="text-sm">photos</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="mb-8">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                                        <div class="w-2 h-2 bg-primary rounded-full"></div>
                                        Description
                                    </h3>
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-md p-6">
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                                            {{ selectedProperty.description }}
                                        </p>
                                    </div>
                                </div>

                                <!-- CTA  -->
                                <div class="bg-gradient-to-r from-primary/10 to-secondary/10 dark:from-gray-700 dark:to-gray-700 rounded-md p-6">
                                    <div class="text-center mb-4">
                                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">
                                            Intéressé par ce bien ?
                                        </h4>
                                        <p class="text-gray-600 dark:text-gray-300">
                                            Contactez nos experts pour plus d'informations
                                        </p>
                                    </div>
                                     <div class="flex flex-col sm:flex-row gap-3">
                                        <button
                                            @click="contactMethods.openContactForm"
                                            class="w-full bg-gradient-to-r from-primary to-[#006a9a] hover:from-primary/90 hover:to-[#006a9a]/90 text-white py-4 px-8 rounded-md font-bold text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3"
                                        >
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                            </svg>
                                            Contacter un conseiller
                                        </button>
                                        <ShareProperty
                                            :property="selectedProperty"
                                            class="flex-1"
                                        />
                                     </div>

                                </div>
                            </div>
                        </div>
                        <!-- État vide pour la sélection -->
                        <div v-else class="bg-white dark:bg-gray-800 rounded-md shadow-lg border border-gray-200 dark:border-gray-700 p-12 text-center">
                            <div class="w-32 h-32 mx-auto bg-gradient-to-br from-primary/10 to-secondary/10 dark:from-gray-700 dark:to-gray-600 rounded-full flex items-center justify-center mb-8">
                                <svg class="w-16 h-16 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                                Découvrez nos biens
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400 text-lg mb-8 max-w-md mx-auto">
                                Sélectionnez un bien dans la liste pour voir tous les détails, photos et caractéristiques.
                            </p>
                            <div class="flex items-center justify-center gap-2 text-primary">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                </svg>
                                <span class="font-medium">Cliquez sur un bien</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lightbox -->
    <div v-if="isLightboxOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/95 backdrop-blur-sm transition-all duration-300">
        <!-- Contrôles -->
        <button @click="imageMethods.closeLightbox" class="absolute top-8 right-8 text-white hover:text-gray-300 z-20 group">
            <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-full flex items-center justify-center group-hover:bg-white/20 transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
        </button>

        <button @click="imageMethods.prevImage" class="absolute left-8 text-white hover:text-gray-300 z-20 group">
            <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-full flex items-center justify-center group-hover:bg-white/20 transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </div>
        </button>

        <button @click="imageMethods.nextImage" class="absolute right-8 text-white hover:text-gray-300 z-20 group">
            <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-full flex items-center justify-center group-hover:bg-white/20 transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </div>
        </button>

        <!-- Image -->
        <div class="max-w-6xl w-full max-h-[85vh] flex items-center justify-center px-16">
            <img
                :src="computedProps.filteredImages.value[currentImageIndex]"
                class="max-w-full max-h-full object-contain rounded-md shadow-xl"
                :alt="`Image ${currentImageIndex + 1} du bien`"
            />
        </div>

        <!-- Compteur et miniatures -->
        <div class="absolute bottom-8 left-0 right-0">
            <div class="text-center text-white mb-6">
                <div class="bg-white/10 backdrop-blur-md rounded-full px-4 py-2 inline-block">
                    <span class="font-medium">{{ currentImageIndex + 1 }} / {{ computedProps.filteredImages.value.length }}</span>
                </div>
            </div>

            <!-- Miniatures -->
            <div class="flex justify-center gap-2 px-8 overflow-x-auto">
                <div
                    v-for="(image, index) in computedProps.filteredImages.value"
                    :key="index"
                    @click="currentImageIndex = index"
                    class="w-16 h-16 rounded-md overflow-hidden cursor-pointer border-2 transition-all duration-200"
                    :class="{
                        'border-white': index === currentImageIndex,
                        'border-white/30 hover:border-white/60': index !== currentImageIndex
                    }"
                >
                    <img
                        :src="image"
                        class="w-full h-full object-cover"
                        :alt="`Miniature ${index + 1}`"
                    />
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de contact  -->
    <div v-if="isContactFormOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm transition-all duration-300 p-4">
        <div class="bg-white dark:bg-gray-800 rounded-md shadow-2xl w-full max-w-2xl relative overflow-hidden">
            <!-- Header avec gradient -->
            <div class="bg-gradient-to-r from-primary to-[#006a9a] p-8 text-white">
                <button
                    @click="contactMethods.closeContactForm"
                    class="absolute top-6 right-6 text-white/80 hover:text-white group"
                >
                    <div class="w-10 h-10 bg-white/10 backdrop-blur-md rounded-full flex items-center justify-center group-hover:bg-white/20 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </button>

                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-md flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold mb-2">Contactez-nous</h2>
                        <p class="text-blue-100">
                            À propos du bien: <span class="font-semibold">{{ selectedProperty.reference }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Formulaire -->
            <div class="p-8">
                <form @submit.prevent="contactMethods.submitContactForm" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                                Nom complet
                            </label>
                            <input
                                v-model="contactForm.name"
                                type="text"
                                :class="[
                                    'w-full px-4 py-4 roundedmd border-2 focus:ring-4 focus:ring-primary/20 transition-all duration-300 bg-white dark:bg-gray-800',
                                    formErrors.name
                                        ? 'border-red-500 focus:border-red-500'
                                        : 'border-gray-200 dark:border-gray-700 focus:border-primary',
                                ]"
                                @input="contactMethods.validateField('name')"
                                placeholder="Votre nom complet"
                            />
                            <p v-if="formErrors.name" class="mt-2 text-sm text-red-600 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ formErrors.name }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                                Email
                            </label>
                            <input
                                v-model="contactForm.email"
                                type="email"
                                :class="[
                                    'w-full px-4 py-4 rounded-xl border-2 focus:ring-4 focus:ring-primary/20 transition-all duration-300 bg-white dark:bg-gray-800',
                                    formErrors.email
                                        ? 'border-red-500 focus:border-red-500'
                                        : 'border-gray-200 dark:border-gray-700 focus:border-primary',
                                ]"
                                @input="contactMethods.validateField('email')"
                                placeholder="votre@email.com"
                            />
                            <p v-if="formErrors.email" class="mt-2 text-sm text-red-600 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ formErrors.email }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                            Téléphone
                        </label>
                        <input
                            v-model="contactForm.phone"
                            type="tel"
                            class="w-full px-4 py-4 rounded-md border-2 border-gray-200 dark:border-gray-700 focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all duration-300 bg-white dark:bg-gray-800"
                            placeholder="06 12 34 56 78"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                            Message
                        </label>
                        <textarea
                            v-model="contactForm.message"
                            rows="5"
                            :class="[
                                'w-full px-4 py-4 rounded-md border-2 focus:ring-4 focus:ring-primary/20 transition-all duration-300 bg-white dark:bg-gray-800 resize-none',
                                formErrors.message
                                    ? 'border-red-500 focus:border-red-500'
                                    : 'border-gray-200 dark:border-gray-700 focus:border-primary',
                            ]"
                            @input="contactMethods.validateField('message')"
                            placeholder="Décrivez votre projet, vos besoins ou posez vos questions..."
                        ></textarea>
                        <p v-if="formErrors.message" class="mt-2 text-sm text-red-600 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ formErrors.message }}
                        </p>
                    </div>

                    <button
                        type="submit"
                        :disabled="isSubmitting"
                        class="w-full bg-gradient-to-r from-primary to-[#006a9a] hover:from-primary/90 hover:to-[#006a9a]/90 disabled:from-gray-400 disabled:to-gray-500 text-white py-4 px-8 rounded2xl font-bold text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 disabled:transform-none transition-all duration-300 flex items-center justify-center gap-3"
                    >
                        <span v-if="isSubmitting" class="flex items-center gap-3">
                            <div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                            Envoi en cours...
                        </span>
                        <span v-else class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            Envoyer ma demande
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <Chatbot
        :properties="computedProps.filteredProperties.value"
        @propertySelected="handlePropertySelected"
        @updateFilters="handleUpdateFilters"
        @scrollToProperty="handleScrollToProperty"
        @openContactModal="handleOpenContactModal"
    />
</template>

<style scoped>
/* Largeur du scrollbar - Plus visible */
.custom-scrollbar::-webkit-scrollbar {
    width: 12px;
}

/* Track (fond) du scrollbar - Toujours visible */
.custom-scrollbar::-webkit-scrollbar-track {
    background: linear-gradient(to right, #f1f5f9, #e2e8f0);
    border-radius: 10px;
    margin: 4px 0;
    border: 1px solid #e2e8f0;
    box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.05);
}

/* Thumb (poignée) du scrollbar - Design moderne */
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, #008dcf, #0077b5);
    border-radius: 10px;
    border: 2px solid #f1f5f9;
    box-shadow: 0 2px 6px rgba(0, 141, 207, 0.3);
    transition: all 0.3s ease;
    min-height: 40px;
}

/* Effet hover sur le thumb */
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(180deg, #0099dc, #008dcf);
    border-color: #e2e8f0;
    box-shadow: 0 4px 12px rgba(0, 141, 207, 0.5);
    transform: scaleX(1.1);
}

/* Effet actif (quand on clique) */
.custom-scrollbar::-webkit-scrollbar-thumb:active {
    background: linear-gradient(180deg, #0077b5, #006699);
    box-shadow: 0 2px 8px rgba(0, 141, 207, 0.6);
}

/* Mode sombre - Track */
.dark .custom-scrollbar::-webkit-scrollbar-track {
    background: linear-gradient(to right, #1f2937, #374151);
    border-color: #4b5563;
    box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
}

/* Mode sombre - Thumb */
.dark .custom-scrollbar::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, #008dcf, #0077b5);
    border-color: #374151;
    box-shadow: 0 2px 6px rgba(0, 141, 207, 0.4);
}

/* Mode sombre - Hover */
.dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(180deg, #0099dc, #008dcf);
    border-color: #4b5563;
    box-shadow: 0 4px 12px rgba(0, 141, 207, 0.6);
}

/* Support Firefox */
.custom-scrollbar {
    scrollbar-color: #008dcf #f1f5f9;
    scrollbar-width: auto;
}

.dark .custom-scrollbar {
    scrollbar-color: #008dcf #374151;
}

/* Animation de pulse subtile */
@keyframes scrollbar-pulse {
    0%, 100% {
        box-shadow: 0 2px 6px rgba(0, 141, 207, 0.3);
    }
    50% {
        box-shadow: 0 4px 12px rgba(0, 141, 207, 0.5);
    }
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    animation: scrollbar-pulse 3s ease-in-out infinite;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    animation: none;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

.highlight-property {
    animation: pulse-highlight 2s ease-in-out;
    border-color: #667eea !important;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1) !important;
}

@keyframes pulse-highlight {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.1);
    }
    50% {
        box-shadow: 0 0 0 10px rgba(102, 126, 234, 0.2);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeInUp {
    animation: fadeInUp 0.6s ease-out;
}
.mapboxgl-popup-content {
    color: #000;
}
</style>

 <script setup>
import { ref, onMounted, computed, watch, onUnmounted, nextTick} from "vue";
import axios from "axios";
import mapboxgl from "mapbox-gl";
import MapboxGeocoder from "@mapbox/mapbox-gl-geocoder";

// Configuration Mapbox
mapboxgl.accessToken = "pk.eyJ1IjoibmRpYXllanAiLCJhIjoiY2p4YWI1bDJpMDBsdzNxcWl3NjU3Znd4YSJ9.15lXtSdUn6ucBGQGs9rhTw";

// États réactifs
const state = {
  // Données
  datas: ref([]),
  loading: ref(true),
  isFiltering: ref(false),
  brokenImages: ref([]),

  // UI
  sortOption: ref(""),
  selectedProperty: ref(null),
  isModalOpen: ref(false),
  isLightboxOpen: ref(false),
  currentImageIndex: ref(0),
  isContactFormOpen: ref(false),
  isSubmitting: ref(false),

  // Map
  map: ref(null),
  geocoder: ref(null),

  // Filtres
  filters: ref({
    city: "",
    category: "",
    transaction: "",
    maxPrice: null,
    nbPieces: null,
  }),

  // Scroll infini
  visibleItems: ref(20),
  isLoadingMore: ref(false),
  scrollObserver: ref(null),

  // Formulaire de contact
  contactForm: ref({
    name: "",
    email: "",
    message: "",
  }),
  formErrors: ref({
    name: null,
    email: null,
    message: null,
  })
};

// Destructuration pour faciliter l'accès
const {
  datas, loading, isFiltering, brokenImages,
  sortOption, selectedProperty, isModalOpen, isLightboxOpen, currentImageIndex,
  isContactFormOpen, isSubmitting, map, geocoder, filters,
  visibleItems, isLoadingMore, scrollObserver,
  contactForm, formErrors
} = state;

// Computed properties
const computedProps = {
  // Propriétés filtrées et triées
  filteredProperties: computed(() => {
    let filtered = datas.value.filter((property) => {
      const cityMatch =
        !filters.value.city ||
        (property.localisation.quartier &&
          property.localisation.quartier
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .includes(filters.value.city
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, ''))
            ) ||
      (property.localisation.ville &&
        property.localisation.ville
          .toLowerCase()
          .normalize('NFD')
          .replace(/[\u0300-\u036f]/g, '')
          .includes(filters.value.city
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
          ));;

      const categoryMatch =
        !filters.value.category ||
        property.categorie === filters.value.category;

      const transactionMatch =
        !filters.value.transaction ||
        property.transaction === filters.value.transaction;

      const priceMatch =
        !filters.value.maxPrice ||
        parseFloat(property.price.replace(/[^\d]/g, "")) <=
          filters.value.maxPrice;

      const propertyNbPieces = property.nbpieces
        ? parseInt(property.nbpieces.match(/\d+/)?.[0], 10) || 0
        : 0;

      const nbPiecesMatch =
        !filters.value.nbPieces ||
        propertyNbPieces >= filters.value.nbPieces;


      return (
        cityMatch &&
        categoryMatch &&
        transactionMatch &&
        priceMatch &&
        nbPiecesMatch
      );
    });

    // Tri des résultats
    if (sortOption.value === "priceAsc") {
      filtered.sort((a, b) => parseFloat(a.price.replace(/[^\d]/g, "")) - parseFloat(b.price.replace(/[^\d]/g, "")));
    } else if (sortOption.value === "priceDesc") {
      filtered.sort((a, b) => parseFloat(b.price.replace(/[^\d]/g, "")) - parseFloat(a.price.replace(/[^\d]/g, "")));
    } else if (sortOption.value === "date") {
      filtered.sort((a, b) => new Date(b.date_creation) - new Date(a.date_creation));
    }

    return filtered;
  }),

  // Propriétés visibles (pour scroll infini)
  visibleProperties: computed(() => {
    return computedProps.filteredProperties.value.slice(0, visibleItems.value);
  }),

  // Catégories uniques
  allCategories: computed(() => {
    const categories = datas.value.map((property) => property.categorie);
    return [...new Set(categories)].filter(Boolean);
  }),

  hasActiveFilters: computed(() => {
    return filters.value.city ||
           filters.value.category ||
           filters.value.transaction ||
           filters.value.maxPrice ||
           filters.value.nbPieces;
  }),

  // Images filtrées (valides et non cassées)
  filteredImages: computed(() => {
    if (!selectedProperty.value?.images) return [];
    return selectedProperty.value.images.filter((image, index) => {
      const isValidFormat = /\.(png|jpg|jpeg)$/i.test(image);
      const isNotBroken = !brokenImages.value.includes(index);
      return isValidFormat && isNotBroken;
    });
  })
};

// Méthodes utilitaires
const utils = {
  transformString: (str) => {
    const firstSpaceIndex = str.indexOf(" ");
    if (firstSpaceIndex !== -1) {
      return str.slice(0, firstSpaceIndex) + "_" + str.slice(firstSpaceIndex + 1);
    }
    return str;
  },

  formatPrice: (price, locale = "fr-FR") => {
    if (!price) return "";
    const numericPrice = parseInt(price.replace(/[^\d]/g, ""), 10);
    if (isNaN(numericPrice)) return price; // Retourne le prix original si le parsing échoue
    return new Intl.NumberFormat(locale).format(numericPrice) + " FCFA";
  },

  formatContent: (content) => {
    if (!content) return "";
    return content.replace(/\n/g, " ").replace(/\\/g, "");
  }
};

// Méthodes de gestion des images
const imageMethods = {
  handleImageError: (event, index) => {
    event.target.src = "/images/noimage.jpg";
    if (index !== undefined && !brokenImages.value.includes(index)) {
      brokenImages.value.push(index);
    }
  },

  markImageAsBroken: async (index, imageUrl) => {
    if (brokenImages.value.includes(index)) return;

    try {
      const response = await axios.head(imageUrl);
      if (response.status !== 200) {
        brokenImages.value.push(index);
      }
    } catch (error) {
      brokenImages.value.push(index);
    }
  },

  openLightbox: (index) => {
    currentImageIndex.value = index;
    isLightboxOpen.value = true;
  },

  closeLightbox: () => {
    isLightboxOpen.value = false;
  },

  prevImage: () => {
    if (!selectedProperty.value?.images) return;
    currentImageIndex.value =
      (currentImageIndex.value - 1 + selectedProperty.value.images.length) %
      selectedProperty.value.images.length;
  },

  nextImage: () => {
    if (!selectedProperty.value?.images) return;
    currentImageIndex.value =
      (currentImageIndex.value + 1) % selectedProperty.value.images.length;
  }
};

// Méthodes de gestion de la carte
const mapMethods = {
  initializeMap: () => {
    if (map.value || !selectedProperty.value) return;

    const { longitude, latitude } = selectedProperty.value.localisation;
    const propLatLng = [parseFloat(longitude), parseFloat(latitude)];

    map.value = new mapboxgl.Map({
      container: "map",
      style: "mapbox://styles/mapbox/streets-v10",
      center: propLatLng,
      zoom: 15,
    });

    // Ajout du geocoder
    geocoder.value = new MapboxGeocoder({
      accessToken: mapboxgl.accessToken,
      mapboxgl: mapboxgl,
      marker: false,
    });

    // Ajout du marqueur
    const popup = new mapboxgl.Popup({ offset: 25 })
      .setText(selectedProperty.value.localisation.quartier ||
               selectedProperty.value.localisation.ville ||
               "Localisation");

    new mapboxgl.Marker()
      .setLngLat(propLatLng)
      .setPopup(popup)
      .addTo(map.value);
  },

  updateMapCenter: (property) => {
    if (!map.value || !property) return;

    const propLatLng = [
      parseFloat(property.localisation.longitude),
      parseFloat(property.localisation.latitude)
    ];

    map.value.flyTo({ center: propLatLng });

    // Mise à jour du marqueur
    const popup = new mapboxgl.Popup({ offset: 25 })
      .setText(property.localisation.quartier ||
               property.localisation.ville ||
               "Localisation");

    // Supprime les anciens marqueurs
    document.querySelectorAll('.mapboxgl-marker').forEach(el => el.remove());

    new mapboxgl.Marker()
      .setLngLat(propLatLng)
      .setPopup(popup)
      .addTo(map.value);
  }
};

// Méthodes de gestion des propriétés
const propertyMethods = {
  selectProperty: (property) => {
    selectedProperty.value = property;
    mapMethods.updateMapCenter(property);
  },

  openModal: (property) => {
    selectedProperty.value = property;
    isModalOpen.value = true;
    nextTick(() => {
      mapMethods.initializeMap();
    });
  }
};

// Méthodes de gestion du formulaire de contact
const contactMethods = {
  openContactForm: () => {
    isContactFormOpen.value = true;
  },

  closeContactForm: () => {
    isContactFormOpen.value = false;
    contactMethods.resetContactForm();
  },

  resetContactForm: () => {
    contactForm.value = { name: "", email: "", message: "" };
    formErrors.value = { name: null, email: null, message: null };
  },

  validateField: (field) => {
    switch (field) {
      case "name":
        if (!contactForm.value.name) {
          formErrors.value.name = "Le nom est obligatoire.";
        } else if (contactForm.value.name.length < 3) {
          formErrors.value.name = "Le nom doit contenir au moins 3 caractères.";
        } else {
          formErrors.value.name = null;
        }
        break;

      case "email":
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!contactForm.value.email) {
          formErrors.value.email = "L'adresse e-mail est obligatoire.";
        } else if (!emailRegex.test(contactForm.value.email)) {
          formErrors.value.email = "Veuillez saisir une adresse e-mail valide.";
        } else {
          formErrors.value.email = null;
        }
        break;

      case "message":
        if (!contactForm.value.message) {
          formErrors.value.message = "Le message est obligatoire.";
        } else if (contactForm.value.message.length < 10) {
          formErrors.value.message = "Le message doit contenir au moins 10 caractères.";
        } else {
          formErrors.value.message = null;
        }
        break;
    }
  },

  validateForm: () => {
    contactMethods.validateField("name");
    contactMethods.validateField("email");
    contactMethods.validateField("message");
    return (
      !formErrors.value.name &&
      !formErrors.value.email &&
      !formErrors.value.message
    );
  },

  submitContactForm: async (e) => {
    e.preventDefault();
    isSubmitting.value = true;
    if (!contactMethods.validateForm()) {
      isSubmitting.value = false;
      return;
    }

    try {
      await axios.post("/contact-agency", {
        property_id: selectedProperty.value.id,
        reference: selectedProperty.value.reference,
        location: `${selectedProperty.value.localisation.quartier || ""} - ${selectedProperty.value.localisation.ville || ""}`,
        price: selectedProperty.value.price,
        category: selectedProperty.value.categorie,
        agent_email: selectedProperty.value.agent?.email || '',
        ...contactForm.value
      });

      alert("Votre message a été envoyé avec succès !");
      contactMethods.closeContactForm();
    } catch (error) {
      alert("Une erreur est survenue. Veuillez réessayer.");
    } finally {
      isSubmitting.value = false;
    }
  }
};

const resetAllFilters = () => {
  filters.value = {
    city: "",
    category: "",
    transaction: "",
    maxPrice: null,
    nbPieces: null,
  };
  sortOption.value = "";
  selectedProperty.value = null;
  visibleItems.value = 20;

    nextTick(() => {
        if (computedProps.filteredProperties.value.length > 0) {
            setTimeout(() => {
                    selectedProperty.value = computedProps.filteredProperties.value[0];
            }, 100);
        } else {
            selectedProperty.value = null;
        }
    });
};

// Méthodes pour le scroll infini
const infiniteScrollMethods = {
  setupInfiniteScroll: () => {
     if (scrollObserver.value) {
      scrollObserver.value.disconnect();
    }
    const options = {
      root: null,
      rootMargin: "20px",
      threshold: 0.1
    };

    scrollObserver.value = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting &&
            !isLoadingMore.value &&
            visibleItems.value < computedProps.filteredProperties.value.length) {
          infiniteScrollMethods.loadMoreItems();
        }
      });
    }, options);

     nextTick(() => {
      setTimeout(() => {
        const sentinel = document.querySelector("#sentinel");
        if (sentinel) {
          scrollObserver.value.observe(sentinel);
        } else {
          console.warn('Sentinel non trouvé');
        }
      }, 500);
    });
  },

  loadMoreItems: () => {
   if (isLoadingMore.value) return;

    isLoadingMore.value = true;

    setTimeout(() => {
      const newVisibleCount = visibleItems.value + 20;
      visibleItems.value = Math.min(newVisibleCount, computedProps.filteredProperties.value.length);
      isLoadingMore.value = false;


      // Réobserver le nouveau sentinel
      nextTick(() => {
        const sentinel = document.querySelector("#sentinel");
        if (sentinel && scrollObserver.value) {
          scrollObserver.value.observe(sentinel);
        }
      });
    }, 800);
  },

  cleanupInfiniteScroll: () => {
     if (scrollObserver.value) {
      scrollObserver.value.disconnect();
      scrollObserver.value = null;
    }
  }
};

const handlePropertySelected = (property) => {
    propertyMethods.selectProperty(property);
   nextTick(() => {
        setTimeout(() => {
            handleScrollToProperty(property);
        }, 300);
    });
};

const handleUpdateFilters = (newFilters) => {

    // RÉINITIALISER COMPLÈTEMENT les filtres au lieu de les fusionner
    filters.value = {
        city: newFilters.city || "",
        category: newFilters.category || "",
        transaction: newFilters.transaction || "",
        maxPrice: newFilters.maxPrice || null,
        nbPieces: newFilters.nbPieces || null,
    };

    // Réinitialiser aussi le tri
    sortOption.value = "";

    visibleItems.value = 20;

    // Scroll vers le haut de la liste
    nextTick(() => {
        const propertyList = document.querySelector('.order-2');
        if (propertyList) {
            propertyList.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });
    // Sélectionner le premier bien après mise à jour des filtres
    nextTick(() => {
        setTimeout(() => {
            if (computedProps.filteredProperties.value.length > 0) {
                selectedProperty.value = computedProps.filteredProperties.value[0];
            } else {
                selectedProperty.value = null;
            }
        }, 200);
    });
};

const handleScrollToProperty = (property) => {
    nextTick(() => {
        const propertyElement = document.querySelector(`[data-property-id="${property.id}"]`);
        if (propertyElement) {
            propertyElement.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            // Ajouter un effet visuel
            propertyElement.classList.add('highlight-property');
            setTimeout(() => {
                propertyElement.classList.remove('highlight-property');
            }, 2000);
        }
    });
};

const handleOpenContactModal = (property) => {
    // Sélectionner la propriété et ouvrir le modal
    propertyMethods.selectProperty(property);
    contactMethods.openContactForm();
};

// Watchers
watch(filters, () => {
  visibleItems.value = 20; // Reset visible items when filters change
  isFiltering.value = true;

  if (selectedProperty.value) {
    const propertyStillVisible = computedProps.filteredProperties.value.some(
      prop => prop.id === selectedProperty.value.id
    );

    if (!propertyStillVisible && computedProps.filteredProperties.value.length > 0) {
      selectedProperty.value = computedProps.filteredProperties.value[0];
    } else if (computedProps.filteredProperties.value.length === 0) {
      selectedProperty.value = null;
    }
  } else if (computedProps.filteredProperties.value.length > 0) {
    selectedProperty.value = computedProps.filteredProperties.value[0];
  }
 setTimeout(() => {
    isFiltering.value = false;
    infiniteScrollMethods.setupInfiniteScroll(); // Réactiver le scroll infini
  }, 500);
}, { deep: true });

const getUrlParameter = (name) => {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
};

const findAndSelectProperty = (propertyId) => {
    const property = datas.value.find(p => {
        return String(p.id) === String(propertyId) ||
               String(p.reference) === String(propertyId);
    });

    if (property) {
        selectedProperty.value = property;

        // Scroller vers le bien
        setTimeout(() => {
            const card = document.querySelector(`[data-property-id="${propertyId}"]`);
            if (card) {
                card.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }, 1000);
    } else {
        console.log('Bien non trouvé. IDs disponibles:', datas.value.slice(0, 5).map(p => p.reference));
    }
};


// Fonction pour ouvrir un bien spécifique via son ID
const openPropertyFromUrl = (propertyId) => {
    const property = datas.value.find(p =>
        p.id === propertyId || p.reference === propertyId
    );

    if (property) {
        selectedProperty.value = property;

        // Scroll vers le bien dans la liste (optionnel)
        nextTick(() => {
            const propertyCard = document.querySelector(`[data-property-id="${propertyId}"]`);
            if (propertyCard) {
                propertyCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    }
};

// Écouter les changements dans l'URL (bouton précédent/suivant du navigateur)
window.addEventListener('popstate', () => {
    const propertyId = getUrlParameter('property');
    if (propertyId && datas.value.length > 0) {
        openPropertyFromUrl(propertyId);
    }
});

watch(selectedProperty, (newProperty) => {
  if (newProperty) {
    mapMethods.updateMapCenter(newProperty);
    const newUrl = `${window.location.pathname}?property=${newProperty.id}`;
    window.history.pushState({ propertyId: newProperty.id }, '', newUrl);
  }
});

// Cycle de vie
onMounted(async () => {
  try {
     const propertyIdFromUrl = getUrlParameter('property');
     const response = await axios.get(
      "https://www3.pagesimmo.net/chercher_Annonces.ashx?C1=AN5C3D7Z7HEL&C_Rest=Avec_Fichiers%7C!%7Ctrue&Avec_Donnees_Complementaires%7C!%7Ctrue&Avec_Donnees_Confidentielles%7C!%7Ctrue&C_Rest=Bien_DU_AU%7C!%7C0,100000"
    );

    const xmlData = response.data;
    const parser = new DOMParser();
    const xmlDoc = parser.parseFromString(xmlData, "application/xml");

    // Fonction pour convertir XML en JSON
    const xmlToJson = (xml) => {
      let obj = {};
      if (xml.nodeType === 1) {
        if (xml.attributes.length > 0) {
          obj["@attributes"] = {};
          for (let j = 0; j < xml.attributes.length; j++) {
            const attribute = xml.attributes.item(j);
            obj["@attributes"][attribute.nodeName] = attribute.nodeValue;
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

    // Trouver la catégorie dans l'objet
    const findCategoryInObject = (obj) => {
      for (let key in obj) {
        if (key.startsWith("CATEGORIE_")) {
          return key.replace("CATEGORIE_", "");
        } else if (typeof obj[key] === "object" && obj[key] !== null) {
          const result = findCategoryInObject(obj[key]);
          if (result) return result.replace("_", " ");
        }
      }
      return null;
    };

    const jsonResult = xmlToJson(xmlDoc);
    if (jsonResult.ROOT?.DESTINATAIRE?.AGENCE?.BIEN) {
      const bienItems = Array.isArray(jsonResult.ROOT.DESTINATAIRE.AGENCE.BIEN)
        ? jsonResult.ROOT.DESTINATAIRE.AGENCE.BIEN
        : [jsonResult.ROOT.DESTINATAIRE.AGENCE.BIEN];

      datas.value = bienItems.map((data) => {
        const fichiers = Array.isArray(data.FICHIER)
          ? data.FICHIER
          : data.FICHIER ? [data.FICHIER] : [];

        const images = fichiers
          .map((fichier) => fichier?.FICHIER_JOINT?.NOM_FICHIER?.["#text"])
          .filter(Boolean)
          .slice(1);

        let category = findCategoryInObject(data) || "AUTRE";

        const interlocuteurDetails = data.LOCATION?.INTERLOCUTEUR_DETAILS ||
                                data.VENTE?.INTERLOCUTEUR_DETAILS;

        return {
          id: data.REFERENCE?.["#text"] || "",
          reference: data.REFERENCE?.["#text"] || "",
          nbchambres: data[utils.transformString(category)]?.NB_CHAMBRES?.["#text"] || "",
          nbpieces: data[utils.transformString(category)]?.NB_PIECES?.["#text"] || "",
          surface: data[utils.transformString(category)]?.SURFACE_HABITABLE?.["#text"] || "",
          etage: data[utils.transformString(category)]?.ETAGE?.["#text"] || "",
          ascenseur: data[utils.transformString(category)]?.ASCENSEUR?.["#text"] || "",
          localisation: {
            ville: data.LOCALISATION?.VILLE?.["#text"] || "",
            quartier: data.LOCALISATION?.QUARTIER?.["#text"] || "",
            cp: data.LOCALISATION?.CP?.["#text"] || "",
            latitude: data.LOCALISATION?.LATITUDE?.["#text"] || "",
            longitude: data.LOCALISATION?.LONGITUDE?.["#text"] || "",
            pays: data.LOCALISATION?.PAYS?.["#text"] || "",
          },
          price: data.LOCATION?.LOYER_MENSUEL_TTC?.["#text"]
            ? `${data.LOCATION.LOYER_MENSUEL_TTC["#text"]} F CFA`
            : data.VENTE?.PRIX?.["#text"]
              ? `${data.VENTE.PRIX["#text"]} F CFA`
              : "",
          transaction: data.LOCATION ? "Location" : data.VENTE ? "Vente" : "",
          description: utils.formatContent(
            data.LOCATION?.TEXTES?.DESCRIPTION_FR?.["#text"] ||
            data.VENTE?.TEXTES?.DESCRIPTION_FR?.["#text"] ||
            ""
          ),
          categorie: category,
          thumb: fichiers[1]?.FICHIER_JOINT?.NOM_FICHIER?.["#text"] || null,
          date_creation: data.DATE_CREATION?.["#text"] || "",
          images: images,
          agent: {
                nom: interlocuteurDetails?.NOM?.["#text"] || "",
                prenom: data.LOCATION?.INTERLOCUTEUR?.["#text"] || data.VENTE?.INTERLOCUTEUR?.["#text"] || "",
                email: interlocuteurDetails?.EMAIL?.["#text"] || "",
                telephone: interlocuteurDetails?.TELEPHONE_DOMICILE?.["#text"] || "",
                adresse: interlocuteurDetails?.ADRESSE1?.["#text"] || "",
                ville: interlocuteurDetails?.VILLE?.["#text"] || "",
                genre: interlocuteurDetails?.GENRE?.["#text"] || "",
            }
        };
      });


     await nextTick();

       if (propertyIdFromUrl) {
        findAndSelectProperty(propertyIdFromUrl);
      } else if (computedProps.filteredProperties.value.length > 0) {
        // Sinon, sélectionner la première propriété
        selectedProperty.value = computedProps.filteredProperties.value[0];
      }

      // 5. Configurer le scroll infini
      nextTick(() => {
        infiniteScrollMethods.setupInfiniteScroll();
      });
    }
  } catch (error) {
    console.error("Erreur lors du chargement des données :", error);
  } finally {
    loading.value = false;
  }
});

onUnmounted(() => {
  infiniteScrollMethods.cleanupInfiniteScroll();
  if (map.value) {
    map.value.remove();
    map.value = null;
  }
});
</script>
