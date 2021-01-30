<template>
    <div>
        <button type="button" class="btn btn-success common-margit-bottom" @click="addNewFile">{{
                ("Add New File")
            }}
        </button>
        <div>
            <div class="row">
                <div class="col-lg-4">
                    <label>{{ ("File Description") }}</label>
                </div>
                <div class="col-lg-4">
                    <label>{{ ("File") }}</label>
                </div>
                <div class="col-lg-2"><label>{{ ("Delete") }}</label>
                </div>
                <div class="col-lg-2"><label>{{ ("Download") }}</label>
                </div>
            </div>
        </div>

        <div v-for="file in filesArray">
            <div class="row file-row">
                <div class="col-lg-4">
                    <input type="text" class="form-control"
                           id="description"
                           placeholder="Enter file description"
                           v-if="isNewFile(file.id)"
                           v-model="file.fileDescription">

                    <input v-else class="form-control"
                           readonly
                           :value="file.file_description">
                </div>
                <div class="col-lg-4">
                    <input type="file" class="form-control"
                           placeholder="Select file"
                           v-bind:id="file.id"
                           v-if="isNewFile(file.id)"
                           @change="setFile(file.id,$event)">

                    <input v-else class="form-control"
                           readonly
                           :value="file.file_name">
                </div>
                <div class="col-lg-2">
                    <button type="button" class="btn btn-outline-danger"
                            @click="deleteFile(file.id)">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                <div class="col-lg-2">
                    <button type="button" class="btn btn-outline-success"
                            @click="downloadFile(file.id)">
                        <i class="bi bi-arrow-down-circle"></i>
                    </button>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: "FileComponent",

    props: {
        files: {
            type: Array,
        },
    },

    watch: {
        files(files) {
            this.filesArray = files;
        },
    },

    data() {
        return {
            fileId: 0,
            filesArray: [],
            fileDescription: '',
            isLargerFile: false,
            fileBrowseName: '',
            fileName: '',
            selectedFileMimeType: '',
            deletedFileIds: [],
        }
    },

    methods: {
        isNewFile(id) {
            let file_id = id.toString();
            if (file_id.startsWith("new_") == true) {
                return true
            } else {
                return false
            }
        },
        addNewFile() {
            this.filesArray.push(
                {
                    id: 'new_' + this.fileId,
                    fileDescription: this.fileDescription,
                    file: this.fileDescription,
                    fileBrowseName: this.fileDescription,
                    selectedFileMimeType: this.fileDescription,
                }
            );
            this.fileId++;
        },

        setFile(id, e) {
            let self = this;
            let imageSizeInMB = e.target.files[0].size / (1024 * 1024);

            if (imageSizeInMB > 5) {
                this.isLargerFile = true;

                self.filesArray.forEach(function (element) {
                    if (id == element.id) {
                        element.file = '';
                    }
                });
            } else {
                if (e.target.files.length > 0) {
                    let reader = new FileReader();
                    reader.readAsDataURL(e.target.files[0]);

                    reader.onload = function () {
                        self.filesArray.forEach(function (element) {
                            if (id == element.id) {
                                element.file = reader.result;
                                element.fileBrowseName = e.target.files[0].name;
                                element.selectedFileMimeType = reader.result.substring(reader.result.indexOf(":") + 1, reader.result.indexOf(";"));
                                element.fileDescription = element.fileDescription === '' ? e.target.files[0].name : element.fileDescription;
                            }
                        });
                    }
                }
                this.$emit('files', self.filesArray);
            }
        },

        deleteFile(fileId) {
            let self = this;
            let i = 0;
            let file_id = fileId.toString();
            self.filesArray.forEach(function (item) {
                if (item.id == file_id) {
                    if (file_id.startsWith("new_") == true) {
                        self.filesArray.splice(i, 1);
                    } else {
                        self.filesArray.splice(i, 1);
                        self.deletedFileIds.push({deleted_record_id: file_id});
                    }
                }
                i++;
            });
            this.$emit('files', self.filesArray);
            this.$emit('deletedFileIds', self.deletedFileIds);
        },

        downloadFile(fileId) {
            alert(fileId);
        }
    }
}
</script>

<style scoped>
.file-row {
    margin-bottom: 10px;
}
</style>
