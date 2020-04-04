<template>
    <div>
        <v-dialog persistent v-model="opened" :width="width">
            <v-card>
                <v-card-title>Aktualizuj hasło</v-card-title>
                <v-card-text>
                    <v-form ref="form">
                        <v-text-field :error-messages="errors.password" :rules="[rules.required]" label="Nowe hasło" v-model="user.password" type="password"></v-text-field>
                        <v-text-field :error-messages="errors.password_confirmation" :rules="[rules.required]" label="Powtórz nowe hasło" v-model="user.password_confirmation" type="password"></v-text-field>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="primary" @click="update()">Aktualizuj</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
    import {update} from "../../api/user";

    export default {
        data:() => {
            return{
                rules:{
                    required: v => !!v || 'Ten element jest wymagany',
                },
                opened:false,
                user:{}
            }
        },
        computed:{
            us(){return this.$store.getters.user},
          width(){
              if(this.$vuetify.breakpoint.lgAndUp) return '50%';
              if(this.$vuetify.breakpoint.mdAndUp) return '70%';
              return '90%';
          }
        },
        mounted() {
            this.$root.$eventBus.$on('updateUserPassword', () => {
                this.opened = true;
            })
        },
        methods:{
            update(){
                if(this.$refs.form.validate()){
                    update(this.user, this.us.id).then(response => {
                        this.opened = false;
                        this.$store.commit('user/setUser', response);
                    }).catch(e => {
                        this.errors = e.response.data.errors;
                    })
                }
            }
        }
    }
</script>