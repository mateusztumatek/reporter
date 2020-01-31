<template>
    <div>
        <v-overlay
                style="border-radius: 16px"
                :absolute="true"
                :value="show"
        >
            <div class="d-flex justify-end">
                <v-btn icon @click="close()" dark><v-icon>mdi-close</v-icon></v-btn>
            </div>
            <v-form ref="user_form">
                <v-text-field  v-model='user.name' label="Imię i nazwisko" :rules="rules.name"></v-text-field>
                <v-text-field v-model='user.email' label="Twój adres email" :rules="rules.email"></v-text-field>
                <div class="text-center">
                    <v-avatar size="110px" style="cursor: pointer" @click="$refs.file.click()">
                        <v-img v-if="!user.avatar" :src="$root.getSrc('/default/avatar.jpg')"></v-img>
                        <v-img v-else :src="$root.getSrc(user.avatar)"></v-img>
                    </v-avatar>
                </div>
                <input type="file" @change="changeAvatar" accept="image/*" label="File input" style="display: none" ref="file">
                <v-btn @click="updateUser()" class="w-100" color="primary mt-2" tile>Zapisz</v-btn>
            </v-form>
        </v-overlay>
        <transition name="grow">
            <v-btn style="top: 90px" :loading="load" small @click="show = true" color="primary" v-if="showButton" absolute right fab top>
                <v-icon class="edit-button">mdi-pencil</v-icon>
            </v-btn>
        </transition>
    </div>
</template>
<script>
    import {upload} from "../api/user";

    export default {
        data: () => {return {
            show: false,
            showButton: false,
            interval: null,
            user:{},
            load: false,
            rules:{
                email:[
                    v => !!v || 'Email jest wymagany',
                    v => /.+@.+\..+/.test(v) || 'Te pole musi być poprawnym adresem email',
                ],
                name: [
                    v => !!v || 'Nazwa jest wymagana'
                ]
            }
        }},
        watch:{
            userOrigin: function(){
                if(this.userOrigin){
                    this.user = this.userOrigin;
                }
            },
            is_opened: function () {
                if(!this.is_opened){
                    this.showButton = false;
                    this.show = false;
                }
            }
        },
        beforeDestroy(){
            window.clearInterval(this.interval);
        },
        computed:{
            userOrigin(){
                return this.$store.getters.user;
            },
          is_opened(){
              return this.$store.getters.is_opened;
          }
        },
        mounted() {
            this.interval = setInterval(() => {
                if(this.is_opened && this.userOrigin.email == null){
                    this.showButton = !this.showButton;
                }else{
                    this.showButton = false;
                }
            }, 8000);
            this.$root.$eventBus.$on('updateUser', () => {this.show =true});
        },
        methods:{
            close(){
                this.show = false;
            },
            updateUser(){
                if(this.$refs.user_form.validate()){
                    this.load = true;
                    this.$store.dispatch('updateUser', this.user).then(res => {
                        this.load = false;
                        this.show = false;
                    });
                }

            },
            changeAvatar(){
                var data = new FormData();
                data.append('file', this.$refs.file.files[0]);
                upload('website_user', data).then(response => {
                    if(response.data){
                        this.$set(this.user, 'avatar', response.data[0]);
                    }
                })
            }
        }
    }
</script>
<style scoped lang="scss">
    .edit-button{
        animation: bounce;
        animation-iteration-count: 2000;
        animation-duration: 1200ms;
    }
    .info{
        right: 100px;
        top: 90px;
        background-color: black;
        padding: 8px;
        border-radius: 10px;
        z-index:2;
        font-size: 0.8rem;
        position: absolute;
        color: white;
    }
    @keyframes bounce {
        0%{
            transform: scale(1);
        }
        50%{
            transform: scale(1.1);
        }
        100%{
            transform: scale(1);
        }
    }
</style>