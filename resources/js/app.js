import './bootstrap';
import '../css/app.css';
import { createApp } from 'vue/dist/vue.esm-bundler';

// import {createApp} from 'vue'

import Chart from './components/Chart.vue';

createApp({
    components: {
        Chart,
    }
}).mount('#app');
