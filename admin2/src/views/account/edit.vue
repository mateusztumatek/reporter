<template>
    <div style="width: 100%">
        <v-container>
            <v-card
                    style="width: 100%"
                    class="mx-auto w-100"
            >
                <v-card-title>{{$t('Edytuj swoje konto')}}</v-card-title>
                <v-card-text>
                    <v-row justify="center">
                        <v-col cols="12" class="text-center">
                            <v-avatar class="change-avatar" color="indigo" size="200">
                                <img
                                        style="object-fit: cover"
                                        :src="$root.getSrc(user.avatar)"
                                        :alt="user.name"
                                >
                                <div class="change"><v-btn @click="$refs.file_input.click()" small color="primary">{{$t('Zmień')}}</v-btn></div>
                                <input type="file" id="file_input" @change="uploadLogo()" style="display: none" ref="file_input"></input>
                            </v-avatar>
                            <div v-if="user.avatar" class="mt-2"><v-btn @click="$root.$eventBus.$emit('imageEdit', {src: user.avatar})" small color="primary">{{$t('Edytuj zdjęcie')}}</v-btn></div>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field :value="user.name" @input="updateUser('name', $event)" :label="$t('Imię i nazwisko')"></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field :value="user.city" @input="updateUser('city', $event)" :label="$t('Miasto')"></v-text-field>
                        </v-col>

                        <v-col cols="12">
                            <v-textarea
                                    outlined
                                    :value="user.desc"
                                    @input="updateUser('desc', $event)"
                                    :label="$t('Twój krótki opis')"
                            ></v-textarea>
                        </v-col>
                    </v-row>
                </v-card-text>

                <v-card-actions>
                    <v-btn @click="save()" text>{{$t('Wyślij')}}</v-btn>
                </v-card-actions>
            </v-card>
        </v-container>

    </div>
</template>
<script>
    import UploadImage from 'vue-upload-image';
    import {upload} from "../../api/upload";

    export default {
        components:{UploadImage},
        data(){
            return{
                editUser: {},
            }
        },
        computed:{
            user(){
                return this.$store.getters.user;
            }
        },

        methods:{
            save(){
                this.startLoading();
                this.$store.dispatch('user/update', {data: this.user, id: this.user.id}).then(response => {this.stopLoading();}).catch(e => {this.stopLoading()});
            },
            updateUser(field, event){
                this.$store.commit('user/setField', {field: field, data: event});
            },
            uploadLogo(){
                var formData = new FormData();
                formData.append('files[]', this.$refs.file_input.files[0]);
                this.startLoading();
                upload(formData, 'users').then(response => {
                    this.stopLoading();
                    this.updateUser('avatar', response.data[0]);
                    this.$store.dispatch('user/update', {data: this.user, id: this.user.id})
                })
            },

        }
    }
</script>
