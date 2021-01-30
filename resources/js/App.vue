<template>
    <div>
        <nav class="navbar navbar-expand-sm bg-light navbar-light  fixed-top"
             v-if="this.$route.name !== 'login' && this.$route.name !== 'register'">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="navbar-brand nav-link"
                       @click.prevent="LogOut()">{{ ("Log Out") }}</a>
                </li>
                <li class="nav-item active">
                    <router-link class="navbar-brand nav-link"
                                 v-if="this.$route.name !== 'dashBoard'"
                                 to="/dashBoard">{{ ("Dash Board") }}
                    </router-link>
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


</style>
