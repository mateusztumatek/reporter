<template>
    <div>
        <h1 class="display-2"><span class="text-muted">Witamy w </span><strong style="font-weight: 900">Reporter</strong></h1>
        <h3 class="headline mt-6 mb-6 text-muted" style="font-weight: 200">Ulepsz komunikację z klientem<br> jednym prostum ruchem.</h3>
        <div class="transparent">
            <v-form
                    ref="form"
                    v-model="valid"
                    lazy-validation
            >
                <v-text-field
                        v-model = "user.name"
                        :label="$t('Imie i nazwisko')"
                        name="name"
                        solo
                        height="60px"
                        :error-messages="errors.name"
                        :rules="nameRules"
                        type="text"
                ></v-text-field>
                <v-text-field
                        v-model = "user.login"
                        :label="$t('Login')"
                        name="login"
                        solo
                        height="60px"
                        :error="(errors.login)? true : false"
                        :error-messages="errors.login"
                        :rules="nameRules"
                        type="text"
                ></v-text-field>
                <v-text-field
                        v-model = "user.email"
                        :label="$t('Email')"
                        :rules="emailRules"
                        :error="(errors.email)? true : false"
                        :error-messages="errors.email"
                        name="email"
                        solo
                        height="60px"
                        type="email"
                ></v-text-field>
                <v-text-field
                        v-model = "user.password"
                        id="password"
                        :label="$t('Hasło')"
                        name="password"
                        :error="(errors.password)? true : false"
                        :error-messages="errors.password"
                        :rules="passwordRules"
                        solo
                        height="60px"
                        type="password"
                ></v-text-field>
                <v-text-field
                        v-model = "user.password_confirmation"
                        id="password"
                        :label="$t('Powtórz hasło')"
                        name="password"
                        :error="(errors.password_confirmation)? true : false"
                        :error-messages="errors.password_confirmation"
                        solo
                        height="60px"
                        type="password"
                ></v-text-field>
            </v-form>
        </div>
        <div class="row mt-5">
            <div class="col-auto">
                <v-btn dark depressed color="black" class="px-12" style="min-height: 50px" @click="registerUser()" :loading="loading">{{$t("Register user")}}</v-btn>
            </div>
            <div class="col-auto">
                <v-btn dark depressed color="black" outlined class="px-12" style="min-height: 50px" :to="'/login'"  :loading="loading">{{$t("Zaloguj sie")}}</v-btn>
            </div>
        </div>
        <p class="mt-10 text-muted">
            By signing up, you agree on:<br>
            <a :href="'/strona/regulamin'" class="black--text font-weight-bold my-link">Regulamin</a> & <a :href="'/strona/polityka'" class="black--text font-weight-bold my-link">Polityka prywatności</a>
        </p>
    </div>
</template>
<script>
    import {mapActions} from 'vuex';
    export default {
        computed:{
            isSmall(){
                return this.$vuetify.breakpoint.smAndDown;
            }
        },
        data(){
            var strongRegex = new RegExp("^(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})");
            return{
                valid: true,
                loading: false,
                user:{},
                errors:[],
                nameRules: [
                    v => !!v || 'Name is required',
                    v => (v && v.length <= 25) || 'Name must be less than 25 characters',
                ],
                passwordRules: [
                    v => !!v || 'Password is required',
                    v => (strongRegex.test(v)) || 'The password must contain at least 1 lowercase, 1 uppercase, 1 numeric, alphabetical character',
                ],
                emailRules: [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
                ],
            }
        },
        methods:{
            registerUser(){
                this.loading = true;
                if(this.$refs.form.validate()){
                    this.$store.dispatch('user/register', this.user).then(response => {
                        this.loading = false;
                        this.$router.push('/');
                        this.user = response;
                    }).catch(e => {
                        this.errors = e.response.data.errors;
                        setTimeout(() => {
                            this.errors = [];
                        }, 3500);
                        this.loading = false;
                    })
                }else{
                    this.loading = false;
                }
            }
        }
    }
</script>