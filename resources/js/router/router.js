import { createRouter, createWebHistory } from "vue-router";
import MainView from '../views/MainView.vue';
import Profile from '../views/Profile.vue';

const router = new createRouter({
    base: "/",
    history: createWebHistory(),
    routes: [
        { path: "/", component: MainView },
        { path: "/profile", component: Profile },
    ],
});

export default router;