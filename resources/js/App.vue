<template>
    <div>
        <nav class="navbar fixed-top navbar-light bg-light nav-bar"
             v-if="this.$route.name !== 'login' && this.$route.name !== 'register'">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="navbar-brand nav-link"
                       @click.prevent="LogOut()">{{ ("Log Out") }}</a>
                </li>
            </ul>
        </nav>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    mounted() {
        this.getUser();
    },

    methods: {
        LogOut() {
            axios.post('logout');
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            window.location.reload();
        }
    }
}
</script>

<style scoped>

.nav-bar {
    background-color: #e3f2fd;
}

.nav-link {
    cursor: pointer;
    font-size: 15px;
}
</style>
