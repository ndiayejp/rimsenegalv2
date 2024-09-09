import './bootstrap';


import Alpine from 'alpinejs';

import { createApp } from 'vue/dist/vue.esm-bundler.js';

import 'flowbite';

import Counter from './components/Counter.vue';
import PropertyCard from './components/PropertyCard.vue';

const app = createApp({});

app.component('counter', Counter);
app.component('property-card', PropertyCard);

app.mount("#app");

window.Alpine = Alpine;

Alpine.start();


