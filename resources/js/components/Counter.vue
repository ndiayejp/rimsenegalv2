<template>
    <section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12">
        <div class="mx-auto max-w-7xl px-4 2xl:px-0">
            <!-- Heading & Filters -->
            <div v-if="loading" class="flex items-center justify-center w-full">
                <div role="status">
                    <svg
                        aria-hidden="true"
                        class="w-16 h-16 text-gray-200 animate-spin dark:text-gray-600 fill-blue"
                        viewBox="0 0 100 101"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="currentColor"
                        />
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentFill"
                        />
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div
                v-else
                class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4"
            >
                <template v-for="property in paginateData" :key="property.id">
                    <property-card :property="property" />
                </template>
            </div>
            <div v-if="!loading" class="mt-6 flex items-center justify-center">
                <button
                    class="mx-2 px-4 py-2 bg-primary hover:bg-secondary hover:text-primary text-white rounded disabled:opacity-50"
                    @click="prevPage"
                    :disabled="currentPage === 1"
                >
                    Précédent
                </button>
                <span class="mx-4 text-lg text-gray-600"
                    >Page {{ currentPage }} of {{ totalPages }}</span
                >
                <button
                    class="mx-2 px-4 py-2 bg-primary hover:bg-secondary hover:text-primary text-white rounded disabled:opacity-50"
                    @click="nextPage"
                    :disabled="currentPage === totalPages"
                >
                    Suivant
                </button>
            </div>
        </div>
    </section>
</template>
<script setup>
import { ref, onMounted, computed } from "vue";
import axios from "axios";
const datas = ref([]);
const loading = ref(true);
const currentPage = ref(1);
const itemsPerPage = 20;

const paginateData = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return datas.value.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(datas.value.length / itemsPerPage);
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

onMounted(async () => {
    try {
        const response = await axios.get(
            "https://www3.pagesimmo.net/chercher_Annonces.ashx?C1=AN5C3D7Z7HEL&C_Rest=Avec_Fichiers%7C!%7Ctrue&Avec_Donnees_Complementaires%7C!%7Ctrue&Avec_Donnees_Confidentielles%7C!%7Ctrue&C_Rest=Bien_DU_AU%7C!%7C0,100000",
            {
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
                    const fichiers = Array.isArray(data.FICHIER)
                        ? data.FICHIER
                        : [data.FICHIER];
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
                        .filter((img) => img !== null);
                    // Find the key that starts with 'CATEGORIE_'
                    let category = findCategoryInObject(data) || "AUTRE";
                    return {
                        id: data.REFERENCE ? data.REFERENCE["#text"] : "",
                        categorie:
                            data.APPARTEMENT &&
                            data.APPARTEMENT.CATEGORIE_APPARTEMENT
                                ? data.APPARTEMENT.CATEGORIE_APPARTEMENT[
                                      "#text"
                                  ]
                                : "Non spécifiée",

                        reference: data.REFERENCE
                            ? data.REFERENCE["#text"]
                            : "",
                        localisation: {
                            ville:
                                data.LOCALISATION && data.LOCALISATION.VILLE
                                    ? data.LOCALISATION.VILLE["#text"]
                                    : "",
                            quartier:
                                data.LOCALISATION && data.LOCALISATION.QUARTIER
                                    ? data.LOCALISATION.QUARTIER["#text"]
                                    : "",
                            cp:
                                data.LOCALISATION && data.LOCALISATION.CP
                                    ? data.LOCALISATION.CP["#text"]
                                    : "",
                            latitude:
                                data.LOCALISATION && data.LOCALISATION.LATITUDE
                                    ? data.LOCALISATION.LATITUDE["#text"]
                                    : "",
                            longitude:
                                data.LOCALISATION && data.LOCALISATION.LONGITUDE
                                    ? data.LOCALISATION.LONGITUDE["#text"]
                                    : "",
                            pays:
                                data.LOCALISATION && data.LOCALISATION.PAYS
                                    ? data.LOCALISATION.PAYS["#text"]
                                    : "",
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
                        transation: (() => {
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
                                return `${data.LOCATION.TEXTES.DESCRIPTION_FR["#text"]}`;
                            } else if (
                                data.VENTE &&
                                data.VENTE.TEXTES &&
                                data.VENTE.TEXTES.DESCRIPTION_FR
                            ) {
                                return `${data.LOCATION?.TEXTES.DESCRIPTION_FR["#text"]}`;
                            } else {
                                return "";
                            }
                        })(),
                        categorie: category,
                        thumb:
                            data.FICHIER &&
                            data.FICHIER[1] &&
                            data.FICHIER[1].FICHIER_JOINT &&
                            data.FICHIER[1].FICHIER_JOINT.NOM_FICHIER
                                ? data.FICHIER[1].FICHIER_JOINT.NOM_FICHIER[
                                      "#text"
                                  ]
                                : null,
                        date_creation: data.DATE_CREATION
                            ? data.DATE_CREATION["#text"]
                            : "",
                        images: images,
                    };
                }),
            ];
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
