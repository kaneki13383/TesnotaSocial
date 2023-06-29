import './bootstrap';
import IndexComponent from './views/IndexView.vue';
import router from './router/router';
import { createApp } from 'vue';
import store from './store/store.js';

createApp(IndexComponent).use(router).use(store).mount('#app');