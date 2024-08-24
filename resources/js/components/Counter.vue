<template>
    <div v-for="data  in datas " :key="data.id">
        <h2 class="text-gray-600">{{ data.title }}</h2>
    </div>

</template>
<script setup>
    import { ref, onMounted } from "vue";
    import axios from "axios";
    const datas = ref([]);

    onMounted(async() =>  {
        const response = await axios.get("https://www3.pagesimmo.net/chercher_Annonces.ashx?C1=AN5C3D7Z7HEL&C_Rest=Avec_Fichiers%7C!%7Ctrue&Avec_Donnees_Complementaires%7C!%7Ctrue&Avec_Donnees_Confidentielles%7C!%7Ctrue&C_Rest=Bien_DU_AU%7C!%7C0,10000").then((response)=>{
            datas.value = response.data
        });
    });

</script>
