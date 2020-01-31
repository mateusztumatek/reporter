<template>
    <div>
        <v-file-input :loading="load" @change="uploadFiles" multiple prepend-icon="mdi-attachment" clear-icon="mdi-close" v-model="file" label="Wgraj plik"></v-file-input>
        <v-row>
            <v-col md="3" v-for="(file, index) in files">
                <v-img :src="getFileImage(file)">
                    <v-btn small fab color="red" dark @click="files.splice(index, 1)"><v-icon>mdi-trash-can-outline</v-icon></v-btn>
                </v-img>
            </v-col>
        </v-row>
    </div>
</template>
<script>
    import {upload} from "../api/upload";

    export default {
        props:['value'],
        data:() => {return {
            file: null,
            files:[],
            load: false,
        }},
        watch:{
          files: function () {
              this.$emit('input', this.files);
          }
        },
        mounted(){
          if(this.value){
              this.files = this.value;
          }
        },
        methods:{
            uploadFiles(files){
                var dataForm = new FormData();
                this.load = true;
                files.forEach((file, index) => {
                    dataForm.append('files['+index+']', file);
                })
                upload(dataForm, 'reports').then(response => {
                    this.files = response.data;
                    this.load = false;
                }).catch(e => {
                    this.$store.dispatch('addMessage', {text: 'Nie udało sie wgrac plików, spróbuj później, albo zmniejsz wielkość plików', type: 'error'});
                })
            },
            getFileImage(file){
                var ext = file.substr(file.lastIndexOf('.') + 1);
                if(ext == 'png' || ext == 'jpg'){
                    return this.$root.getSrc(file);
                }else{
                    return this.$root.getSrc('default/file.jpg');
                }
            }
        }
    }
</script>