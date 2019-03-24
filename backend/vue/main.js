/*jshint esversion: 6 */

import BootstrapVue from 'bootstrap-vue';
import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';

import axios from 'axios';
axios.defaults.baseURL  = '/api/';

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

Vue.use(BootstrapVue);

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.authRequired)) {
        if (store.getters.isLoggedIn) {
            next();
        } else {
            next({
                path: '/login',
                query: {redirect: to.fullPath}
            });
        }
    } else if (to.matched.some(record => record.meta.guestRequired)) {
        if (store.getters.isLoggedIn) {
            next({
                path: '/',
            });
        } else {
            next();
        }
    } else {
        next();
    }
});

new Vue({
    store,
    router,
    el: '#app',
    render: h => h(App)
});