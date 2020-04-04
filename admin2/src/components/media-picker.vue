<template>
    <div class="media-picker">
        <label v-if="label">{{label}}</label>
        <v-dialog v-model="dialog" dark fullscreen persistent hide-overlay transition="dialog-bottom-transition">
            <template v-slot:activator="{ on }">
                <v-btn
                        style="min-height: 50px"
                        color="primary"
                        class="w-100"
                        dark
                        @click="dialog = !dialog"
                        tile
                >
                    Wybierz plik
                </v-btn>
            </template>
            <v-card :loading="loading">
                <v-toolbar dark color="primary">
                    <v-btn icon dark @click="close()">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                    <v-toolbar-title>{{$t('Wybierz plik')}}</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn dark text @click="$emit('select')">Save</v-btn>
                    </v-toolbar-items>
                </v-toolbar>
                <div class="row mx-0" v-if="!loading">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-3" v-for="m in media">
                                <v-card>
                                    <v-img
                                            :src="getImage(m.path)+ '?rnd=' + cacheKey"
                                            class="white--text align-end"
                                            gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                                            height="200px"
                                            v-if="!loading"
                                    >
                                        <v-card-title>
                                            <v-btn :loading="uploading" class="ma-1" color="primary" @click="select(m)">{{$t('Wybierz plik')}}</v-btn>
                                            <div>
                                                <v-btn :loading="uploading" class="ma-1" color="red" fab small @click="remove(m)"><v-icon>mdi-trash-can-outline</v-icon></v-btn>
                                                <v-btn :loading="uploading" class="ma-1" color="primary" fab small @click="$root.$eventBus.$emit('imageEdit', {src: m.path})"><v-icon>mdi-pencil</v-icon></v-btn>
                                            </div>
                                        </v-card-title>
                                    </v-img>
                                </v-card>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input type="file" id="file_input" @change="uploadFile()" style="display: none" ref="file_input"></input>
                        <v-btn :loading="uploading" outlined tile min-height="120px" class="w-100" @click="$refs.file_input.click()">{{$t('Wgraj plik')}}</v-btn>
                    </div>
                </div>
            </v-card>
        </v-dialog>
        <div class="row" v-if="showThumb">
            <div class="col-md-3" v-for="file in selectedFiles">
                <v-card>
                    <v-img
                            class="white--text align-end"
                            height="200px"
                            :src="$root.getSrc(file)"
                    >
                        <v-card-title>
                            <v-btn  class="ma-1" color="red" fab small @click="unselect(file)"><v-icon>mdi-trash-can-outline</v-icon></v-btn>
                        </v-card-title>
                    </v-img>

                </v-card>
            </div>
        </div>
        <div>
            <v-text-field v-model="value" :rules="rules"></v-text-field>
        </div>
    </div>
</template>
<script>
    import {getUserUploads, removeFile} from "../api/upload";
    import {upload} from "../api/upload";

    export default {
        props:['value', 'rules', 'icons', 'label'],
        data(){
            return{
                cacheKey: null,
                dialog: false,
                media: null,
                uploading: false,
                loading: false,
                tmp_value: null,
            }
        },
        computed:{
            showThumb(){
                if(this.icons == null) return true;
                return this.icons;
            },
            selectedFiles(){
                if(typeof this.value == 'array' || typeof this.value == 'object') return this.value;
                if(typeof this.value == 'string') return [this.value];
                return null;
            }
        },
        watch:{
          value: function(){
            this.tmp_value = this.value;
          },
          dialog:function () {
              if(this.dialog){
                  this.getMedia();
              }
          }
        },
        methods:{
            remove(media){
                this.$confirm(this.$t('Czy na pewno chcesz usunąć ten plik')).then(() => {
                    this.uploading = true;
                    removeFile({path: media.path}).then(response => {
                        this.uploading = false;
                        this.media.splice(this.media.findIndex(x => x.path == media.path), 1);
                    })
                })
            },
            uploadFile(event){
                var formData = new FormData();
                formData.append('files[]', this.$refs.file_input.files[0]);
                this.uploading = true;
                upload(formData, 'media').then(response => {
                    this.uploading = false;
                    this.media.push({path: response.data[0]});
                }).catch(e => {
                    this.uploading = false;
                })
            },
            getImage(src){
                return this.$root.base_url+'/storage/'+src;
            },
            select(media){
                this.dialog = false;
                this.$emit('input', media.path);
            },
            unselect(file){
                this.$emit('input', null);
            },
            close(){
                this.dialog = false;
                this.$emit('closeMe');
            },
            getMedia(){
                getUserUploads().then(response => {
                    this.media = response;
                    if(typeof this.media == 'object') this.media = Object.values(this.media);
                }).catch(e => {
                    this.$store.commit('app/ADD_ERROR', {text: 'Nie udało się pobrać plików'});
                })
            }
        }
    }
</script>
<style lang="scss">
    .media-picker{
        .v-input__slot{display: none !important;}
    }
</style>