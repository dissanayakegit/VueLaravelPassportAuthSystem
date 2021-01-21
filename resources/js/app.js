import Vue from "vue";

require('./bootstrap');

window.Vue = require('vue');

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


const app = new Vue({
    el: '#app',

    router,

    components: {App}
});
