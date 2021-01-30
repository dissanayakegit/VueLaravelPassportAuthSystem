import Vue from 'vue';
import VueRouter from 'vue-router';
import DashBoard from "./components/DashBoard";
import Login from "./components/Login";
import Register from "./components/Register";
import FileHandler from "./components/Files/FileHandler";
import CustomerList from "./components/Customers/CustomerList";


Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {
            name: 'login',
            path: '/',
            component: Login
        },
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
            name: 'fileHandler',
            path: '/file-handler',
            component: FileHandler
        },
        {
            name: 'customer-list',
            path: '/customer-list',
            component: CustomerList
        },
    ],

    mode: 'history'
});
