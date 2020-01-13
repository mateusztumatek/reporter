<template>
    <v-card class="elevation-1 pa-3 login-card">
        <v-card-text>
            <div class="layout column align-center">
                <img src="/static/m.png" alt="Vue Material Admin" width="120" height="120" />
                <h1 class="flex my-4 primary--text">Material Admin Template</h1>
            </div>
            <v-form>
                <v-text-field
                        :error="(errors && errors.name)? true : false"
                        :error-messages="errors.name"
                        append-icon="person"
                        :label="$t('name and surname')"
                        type="text"
                        v-model="user.name"
                ></v-text-field>
                <v-text-field
                        append-icon="email"
                        :error="(errors && errors.email)? true : false"
                        :error-messages="errors.email"
                        :label="$t('email')"
                        type="email"
                        v-model="user.email"
                ></v-text-field>
                <v-text-field
                        append-icon="lock"
                        :error="(errors && errors.password)? true : false"
                        :error-messages="errors.password"
                        name="password"
                        :label="$t('Hasło')"
                        type="password"
                        v-model="user.password"
                ></v-text-field>
                <v-text-field
                        append-icon="lock"
                        :label="$t('Powtórz hasło')"
                        type="password"
                        v-model="user.password_confirmation"
                ></v-text-field>
            </v-form>
        </v-card-text>
        <div class="login-btn">
            <v-btn block color="primary" @click="register" :loading="loading">{{$t("login.submit")}}</v-btn>
        </div>
    </v-card>
</template>

<script>
    export default {
        data: () => ({
            loading: false,
            errors:{},
            user:{}
        }),

        methods: {
            register() {
                this.loading = true;
                // handle login
                this.$store.dispatch('user/register', this.user).then(response => {
                    this.$router.push('/');
                }).catch(e => {
                    if(e.response && e.response.data){
                        this.errors = e.response.data.errors;
                    }
                    this.loading = false;
                })
            }
        }
    }
</script>
<style scoped lang="css"></style>
