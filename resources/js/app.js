import './bootstrap';

import jQuery from 'jquery';
window.$ = jQuery;

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue/dist/vue.esm-bundler.js';

import 'flowbite';

import Counter from './components/Counter.vue';
import PropertyCard from './components/PropertyCard.vue';

const app = createApp({});

app.component('counter', Counter);
app.component('property-card', PropertyCard);

app.mount("#app");









