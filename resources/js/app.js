import './bootstrap';
import 'flowbite';
import.meta.glob([
    '../images/**'
]);
import '@fortawesome/fontawesome-free/js/all';

import {createApp} from "vue"
import Counter from "./components/Counter.vue"

const app = createApp({});
app.component('Counter',Counter)
app.mount("#app")
