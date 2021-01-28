export default {
    methods: {
        async getUser() {
            let token = localStorage.getItem("token");
            await axios.post("user", {}, {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }).then((response) => {
                if (response.status === 200) {
                    localStorage.setItem("user", JSON.stringify(response.data));
                    if (this.$route.name === 'login' || this.$route.name === 'dashBoard') {
                        this.$router.push({name: 'dashBoard'}).catch(() => {
                        });
                    }
                } else {
                    localStorage.removeItem("user");
                    localStorage.removeItem("token");
                    this.$router.push({name: 'login'}).catch(() => {
                    });
                }
            }).catch((e) => {
                localStorage.removeItem("user");
                localStorage.removeItem("token");
                this.$router.push({name: 'login'}).catch(() => {
                });

            });
        },
    }
}
