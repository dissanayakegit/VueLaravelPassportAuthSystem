<template>
    <div>
        <div class="container main">
            <FileComponent
                :files="files"
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
        this.getAllFiles();
    },

    methods: {
        getSelectedFiles(files) {
            console.log(files);
            this.files = files;
        },

        deletedFileIds(deletedFileIds) {
            console.log(deletedFileIds);
            this.deletedRecordIds = deletedFileIds;
        },

        getAllFiles() {
            axios.get('get-all-files').then(response => {
                this.files = response.data;
            });
        },

        submit() {
            let self = this;
            let formData = new FormData();
            formData.append("files", JSON.stringify({files: self.files}));
            formData.append("deletedRecordIds", JSON.stringify(self.deletedRecordIds));

            axios.post('/update-files', formData).then(response => {
                if (response.data) {
                    this.$swal({
                        title: 'Succeed',
                        text: "Files saved successfully",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    })
                }
            });
        }
    }
}
</script>

<style scoped>

</style>
