<template>
    <v-card class="elevation-1 pa-3 login-card">
        <v-card-text>
            <div class="layout column align-center">
                <v-img class="mb-5" src="/static/logo.svg" alt="Vue Material Admin" width="120" />
            </div>
            <v-form>
                <v-text-field
                        :error="(errors && errors.email)? true : false"
                        :error-messages="errors.email"
                        append-icon="person"
                        name="login"
                        :label="$t('login.account')"
                        type="text"
                        v-model="user.email"
                ></v-text-field>
                <v-text-field
                        append-icon="lock"
                        name="password"
                        :label="$t('login.password')"
                        id="password"
                        type="password"
                        v-model="user.password"
                ></v-text-field>
            </v-form>
        </v-card-text>
        <v-card-actions>
            <v-btn color="primary" @click="loginUser" :loading="loading">{{$t("login.submit")}}</v-btn>
            <v-btn  :to="'/auth/register'" color="primary">{{$t("Zarejestruj się")}}</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    export default {
        data(){
            return{
                user:{},
                errors:[],
                loading: false
            }
        },

        methods: {
            loginUser(){
                this.startLoading();
                this.$store.dispatch('user/login', this.user).then(response => {
                    this.$router.push({ path: this.redirect || '/' });
                    this.stopLoading();
                }).catch(e => {
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
<style scoped lang="css"></style>
