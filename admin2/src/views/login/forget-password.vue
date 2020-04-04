<template>
    <div>
        <h1 class="display-2"><span class="text-muted">Zapomniałeś hasła?</span></h1>
        <h3 class="headline mt-6 mb-6 text-muted" style="font-weight: 200">Wpisz swój adres email i wyślemy ci link do zresetowania hasła.</h3>
        <div class="transparent">
            <v-form ref="form">
                <v-text-field
                        v-if="reset == null"
                        :loading="loading"
                        :error="(errors && errors.email)? true : false"
                        :error-messages="errors.email"
                        name="login"
                        solo
                        height="60px"
                        :label="$t('login.account')"
                        type="text"
                        v-model="user.email"
                ></v-text-field>
                <div v-if="reset && reset.token">
                    <v-text-field
                            :loading="loading"
                            :error-messages="errors.password"
                            name="login"
                            solo
                            type="password"
                            height="60px"
                            :label="$t('Nowe hasło')"
                            v-model="reset.password"
                    ></v-text-field>
                    <v-text-field
                            :error-messages="errors.password_confirmation"
                            name="login"
                            solo
                            :loading="loading"
                            type="password"
                            height="60px"
                            :label="$t('Potwierdź nowe hasło')"
                            v-model="reset.password_confirmation"
                    ></v-text-field>
                </div>

            </v-form>
        </div>
        <div class="row mt-5">
            <div class="col-auto">
                <v-btn dark depressed color="black" class="px-12" style="min-height: 50px" @click="(reset && reset.token)? update() : resetEmail()" :loading="loading">{{$t("Resetuj")}}</v-btn>
            </div>
            <div class="col-auto">
                <v-btn dark depressed color="black" outlined class="px-12" style="min-height: 50px" :to="'/register'"  :loading="loading">{{$t("Register")}}</v-btn>
            </div>
        </div>
    </div>
</template>
<script>
    import {resetPassword, reset} from "../../api/user";

    export default {
        data:() => {
            return{
                loading:false,
                user:{},
                reset:null,
            }
        },
        mounted(){
          if(this.$route.query.token){
              this.reset = {password: null};
              this.$set(this.reset, 'token', this.$route.query.token);
              this.$set(this.reset, 'email', this.$route.query.email);
          }
        },
        methods:{
            update(){
              if(this.$refs.form.validate()){
                  this.loading = true;
                  reset(this.reset).then(response => {
                      this.$store.commit('app/ADD_MESSAGE', {text: 'Zresetowano hasło, zaloguj się ponownie', type: 'success'})
                      this.$router.push('/login');
                      this.loading = false;
                  }).catch(e => {
                      this.errors = e.response.data.errors;
                      this.loading = false;
                  })
              }
            },
            resetEmail(){
                this.loading = true;
                resetPassword(this.user).then(response => {
                    this.$store.commit('app/ADD_MESSAGE', {text: 'Wysłaliśmy link na podany adres email', type: 'success'})
                    this.loading = false;
                }).catch(e => {
                    this.errors = e.response.data.errors;
                    this.loading = false;
                });
            }
        }
    }
</script>