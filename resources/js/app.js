import Vue from "vue";

require('./bootstrap');

window.Vue = require('vue');

import "../css/app.css"

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap';

import router from './router'

import App from './App.vue'

import axios from 'axios';

axios.defaults.baseURL = 'http://localhost:8000/api';
axios.defaults.headers.common = {'Authorization': `Bearer ${localStorage.getItem('token')}`};

//mixins
import user from './Auth.js';

Vue.mixin(user);

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(VueSweetalert2);

const app = new Vue({
    el: '#app',

    router,

    components: {App}
});
