import { createRouter, createWebHistory } from "vue-router";
import MainView from '../views/MainView.vue';
import Profile from '../views/Profile.vue';
import News from '../views/News.vue';

const router = new createRouter({
    base: "/",
    history: createWebHistory(),
    routes: [
        { path: "/", component: MainView },
        { path: "/profile", component: Profile },
        { path: "/news", component: News },
    ],
});

export default router;