import './bootstrap';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.js';
import '../css/app.css';
import { createApp } from 'vue';
import App from './pages/App.vue';
import router from './router';
import { createPinia } from 'pinia'
import Swal from 'sweetalert2';
import ApiService from "@/apiClient.js";

window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,

})
const pinia = createPinia()

window.ApiService = ApiService
ApiService.init();
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta?.requireAuth)) {
        if (!localStorage.getItem('token')) {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            next('/login')
        } else {
            // check token validity
            ApiService.get('/user').then(response => {
                next()
            }).catch(error => {
                //if token is not valid destroy token
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                next('/login')
            })
        }
    }
    // if user already login then redirect the user to profile
     if (to.name === 'login') {
        if (localStorage.getItem('token')) {
            next('/');
        }
    }

    next();
});

createApp(App)
    .use(router)
    .use(pinia)
    .mount('#app');
