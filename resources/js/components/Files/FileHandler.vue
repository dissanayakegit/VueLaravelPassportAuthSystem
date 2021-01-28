<template>
    <div>
        <div class="container main">
            <FileComponent
                @files="getSelectedFiles"
                @deletedFileIds="deletedFileIds"
            >
            </FileComponent>
            <button type="button" class="btn btn-success" @click="submit">{{ ("Submit") }}</button>
        </div>
    </div>
</template>

<script>
import FileComponent from './_FileComponent';

export default {
    name: "FileHandler",

    data() {
        return {
            files: [],
            deletedRecordIds: [],
        }
    },

    components: {
        FileComponent
    },

    mounted() {
    },

    methods:{
        getSelectedFiles(files){
            console.log(files);
            this.files = files;
        },

        deletedFileIds(deletedFileIds){
            console.log(deletedFileIds);
            this.deletedRecordIds = deletedFileIds;
        },

        submit(){
            let self = this;
            let formData = new FormData();
            formData.append("files", JSON.stringify({files: self.files}));
            formData.append("deletedRecordIds", JSON.stringify(self.deletedRecordIds));

            axios.post('/update-files',formData).then(response => {
                console.log();
            });
        }


    }
}
</script>

<style scoped>

</style>
