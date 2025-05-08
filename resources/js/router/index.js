import { createRouter, createWebHistory } from 'vue-router';
import Task from "@/pages/Task.vue";
import Login from "@/pages/Login.vue";

const routes = [
    {
        path: '/',
        component: Task,
        meta: {
            requireAuth: true
        }
    },
    {
        path: '/login',
        component: Login,
        name: 'login',
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
