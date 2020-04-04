<template>
    <div>
        <h1 class="display-2"><span class="text-muted">Witamy w </span><strong style="font-weight: 900">Reporter</strong></h1>
        <h3 class="headline mt-6 mb-6 text-muted" style="font-weight: 200">Ulepsz komunikację z klientem<br> jednym prostum ruchem.</h3>
        <div class="transparent">
            <v-form>
                <v-text-field
                        :error="(errors && errors.email)? true : false"
                        :error-messages="errors.email"
                        name="login"
                        solo
                        height="60px"
                        :label="$t('login.account')"
                        type="text"
                        v-model="user.email"
                ></v-text-field>
                <v-text-field
                        solo
                        height="60px"
                        name="password"
                        class="login-input"
                        :label="$t('login.password')"
                        id="password"
                        type="password"
                        v-model="user.password"
                ></v-text-field>
                <div class="row justify-space-between align-center">
                    <div class="col-auto">
                        <v-checkbox label="Zapamiętaj mnie"></v-checkbox>
                    </div>
                    <div class="col-auto">
                        <router-link  to="/reset"><a class="my-link black--text my-link">Zapomniałeś hasła?</a></router-link>
                    </div>
                </div>
            </v-form>
        </div>
        <div class="row mt-5">
            <div class="col-auto">
                <v-btn dark depressed color="black" class="px-12" style="min-height: 50px" @click="loginUser" :loading="loading">{{$t("login")}}</v-btn>
            </div>
            <div class="col-auto">
                <v-btn dark depressed color="black" outlined class="px-12" style="min-height: 50px" :to="'/register'"  :loading="loading">{{$t("Register")}}</v-btn>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-auto">
                <v-btn dark depressed color="grey" class="px-12" style="min-height: 50px" :href="$root.base_url+'/auth/facebook'" :loading="loading"><v-icon class="mr-3">mdi-facebook</v-icon>{{$t("Login by facebook")}}</v-btn>
            </div>
            <div class="col-auto">
                <v-btn dark depressed color="grey" class="px-12" style="min-height: 50px" :href="$root.base_url+'/auth/google'" :loading="loading"><v-icon class="mr-3">mdi-google</v-icon>{{$t("Login by google")}}</v-btn>
            </div>
        </div>
        <p class="mt-10 text-muted">
            By signing up, you agree on:<br>
            <a :href="'/strona/regulamin'" class="black--text font-weight-bold my-link">Regulamin</a> & <a :href="'/strona/polityka'" class="black--text font-weight-bold my-link">Polityka prywatności</a>
        </p>
    </div>
</template>

<script>
    export default {
        computed:{
            isSmall(){
                return this.$vuetify.breakpoint.smAndDown;
            }
        },
        data(){
            return{
                user:{},
                errors:[],
                loading: false
            }
        },
        mounted(){
          if(this.$route.query.error){
              this.$store.commit('app/ADD_MESSAGE', {text: this.$route.query.error, type: 'error'});
          }
        },
        methods: {
            loginUser(){
                this.loading = true;
                this.startLoading();
                this.$store.dispatch('user/login', this.user).then(response => {
                    this.$router.push({ path: this.redirect || '/' });
                    this.loading = false;
                    this.stopLoading();
                }).catch(e => {
                    this.loading = false;
                    this.stopLoading();
                    this.errors = e.response.data.errors;
                    setTimeout(() => {
                        this.errors = [];
                    }, 3000)
                })
            },

        }
    }
</script>
<style lang="scss">
    @import "../../assets/variables";
    .login-input{
        min-height: 70px;
    }
    .login-card{
        -webkit-box-shadow: 25px 25px 50px -15px rgba(0,0,0,0.18);
        -moz-box-shadow: 25px 25px 50px -15px rgba(0,0,0,0.18);
        box-shadow: 25px 25px 50px -15px rgba(0,0,0,0.18);
    }
</style>
