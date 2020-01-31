<template>
    <div class="app-messages">
        <v-fade-transition group>
            <v-alert :key="id" v-for="(message,id) in messages" :type="message.type" dismissible>{{message.text}}
                <template v-slot:close="{toggle}"><v-btn icon @click="toggle()"><v-icon>mdi-close</v-icon></v-btn></template>
                <template v-slot:prepend>
                    <v-icon v-if="message.type == 'error'"></v-icon>
                    <v-icon v-else>mdi-exclamation-thick</v-icon>
                </template>
            </v-alert>
        </v-fade-transition>
    </div>
</template>
<script>
    export default {
        data:() => {return{

        }},
        computed:{
            messages(){return this.$store.getters.messages},
        }
    }
</script>
<style>
    .app-messages{
        position: absolute;
        bottom: 0px;
        left: 0px;
        width: 100%;
    }
</style>