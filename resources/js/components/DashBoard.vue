<template>
    <div>
        <div class="container main">
            <h2>hello you're in dashboard</h2>

        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {}
    },

    mounted() {
        this.getFiles();
    },

    methods: {
        getFiles() {
            axios.get('get-files').then(response => {
                console.log(response);
            })
            axios.post('post-files').then(response => {
                console.log(response);
            })
        }
    }
}
</script>

<style scoped>
.main {
    overflow: auto;
    background-color: white;
    margin: 70px auto 10px auto;
    padding: 30px;
    width: 100vw;
    height: 100vh;
    border-radius: 10px;
    box-shadow: 5px 10px 18px #888888;
}

</style>
