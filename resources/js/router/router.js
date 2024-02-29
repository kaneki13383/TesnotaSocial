import { createRouter, createWebHistory } from "vue-router";
import MainView from '../views/MainView.vue';
import Profile from '../views/Profile.vue';
import News from '../views/News.vue';
import CheckProfileUser from '../views/CheckProfileUser.vue';
import FriendsView from '../views/FriendsView.vue';

const router = new createRouter({
    base: "/",
    history: createWebHistory(),
    routes: [
        { path: "/", component: MainView },
        { path: "/profile", component: Profile },
        { path: "/news", component: News },
        { path: "/user/:id", component: CheckProfileUser },
        { path: "/friends", component: FriendsView },
    ],
});

export default router;