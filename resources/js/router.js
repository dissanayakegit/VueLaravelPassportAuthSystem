import Vue from 'vue';
import VueRouter from 'vue-router';
import DashBoard from "./components/DashBoard";
import Login from "./components/Login";
import Register from "./components/Register";
import CustomerList from "./components/CustomerList";


Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {
            name: 'dashBoard',
            path: '/dashBoard',
            component: DashBoard
        },
        {
            name: 'login',
            path: '/login',
            component: Login
        },
        {
            name: 'register',
            path: '/register',
            component: Register
        },
        {
            name: 'customer',
            path: '/customer',
            component: CustomerList
        }
    ],

    mode: 'history'
});
