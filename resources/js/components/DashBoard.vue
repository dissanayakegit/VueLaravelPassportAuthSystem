<template>
    <div>
        <div class="container main">
            <router-link to="/file-handler">{{("Files")}}</router-link>
            <button @click.prevent="gotoFiles()">{{("Files")}}</button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {}
    },

    mounted() {
       // this.getFiles();
    },

    methods: {
        getFiles() {
            axios.get('get-files').then(response => {
                console.log(response);
            })
            axios.post('post-files').then(response => {
                console.log(response);
            })
        },
        gotoFiles(){
            this.$router.push({path:'/file-handler'});
        }
    }
}
</script>

<style scoped>

</style>
