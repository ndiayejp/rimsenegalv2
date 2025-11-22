import './bootstrap';

import jQuery from 'jquery';
window.$ = jQuery;

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue/dist/vue.esm-bundler.js';
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

import {
    faMapMarkerAlt,
    faHome,
    faHandshake,
    faCalendarAlt,
    faTag,
    faEuroSign,
    faDoorOpen,
    faFilter,
    faSort,
    faArrowUp,
    faArrowDown,
    faClock,
    faBed,
    faRulerCombined,
    faBuilding,
    faChessRook,
    faCity,
    faMoneyBillWave,
    faSearch,
    faPhone,
    faRedo,
    faEllipsisH,
    faPaperPlane,
    faTimes,
    faRobot,
    faHand,
    faShareAlt,
    faCommentSms,
    faEnvelope,
    faQrcode,
    faLink,
    faCopy,
    faCheck,
    faMoneyCheck,
    faUser,
    faEnvelopeOpen,
    faInfo,
    faMessage,
    faArrowRightLong,
    faHeart,
    faHistory,
    faBrain,
    faBolt,
    faHome as faHomeIcon
} from '@fortawesome/free-solid-svg-icons';

import {
    faWhatsapp,
    faFacebook,
    faTwitter,
    faLinkedin,
    faTelegram
} from '@fortawesome/free-brands-svg-icons';

// Ajouter les icônes à la library
library.add(
    faMapMarkerAlt,
    faHome,
    faHandshake,
    faCalendarAlt,
    faTag,
    faEuroSign,
    faDoorOpen,
    faFilter,
    faSort,
    faArrowUp,
    faArrowDown,
    faClock,
    faBed,
    faRulerCombined,
    faBuilding,
    faChessRook,
    faCity,
    faMoneyBillWave,
    faSearch,
    faPhone,
    faRedo,
    faEllipsisH,
    faPaperPlane,
    faTimes,
    faRobot,
    faHand,
    faShareAlt,
    faHomeIcon,
    faWhatsapp,
    faFacebook,
    faTwitter,
    faLinkedin,
    faTelegram,
    faCommentSms,
    faEnvelope,
    faQrcode,
    faLink,
    faCopy,
    faCheck,
    faMoneyCheck,
    faUser,
    faInfo,
    faMessage,
    faArrowRightLong,
    faEnvelopeOpen,
    faHeart,
    faHistory,
    faBrain,
    faBolt
);


import 'flowbite';

import Counter from './components/Counter.vue';
import PropertyCard from './components/PropertyCard.vue';
import Chatbot from './components/Chatbot.vue';
import ShareProperty from './components/ShareProperty.vue';


const app = createApp({});

app.component('counter', Counter);
app.component('property-card', PropertyCard);
app.component('Chatbot', Chatbot);
app.component('font-awesome-icon', FontAwesomeIcon);
app.component('ShareProperty', ShareProperty);

app.mount("#app");
