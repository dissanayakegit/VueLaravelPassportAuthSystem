export default {
    methods: {
         async getUser() {
            let token = localStorage.getItem("token");
            console.log('token:',token);
             await axios.post("user", {}, {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }).then((response) => {
                if (response.status === 200) {
                    localStorage.setItem("user", JSON.stringify(response.data));
                    this.$router.push({name: 'dashBoard'})
                }else{
                    localStorage.removeItem("user");
                    localStorage.removeItem("token");
                    this.$router.push({name: 'login'})
                }
            }).catch((e)=>{
                 localStorage.removeItem("user");
                 localStorage.removeItem("token");
                 this.$router.push({name: 'login'})
             });
        },
    }
}
