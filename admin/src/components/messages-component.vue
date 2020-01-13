<template>
    <div class="messages">
        <v-alert class="elevation-5" type="error" v-for="(message, id) in messages">
            {{message.text}}
            <v-btn @click="dismiss(id)" icon><v-icon>close</v-icon></v-btn>
        </v-alert>
    </div>
</template>
<script>
    export default {
        computed:{
            messages(){return this.$store.getters.app.messages}
        },
        methods:{
            dismiss(id){
                this.$store.commit('app/DELETE_MESSAGE', id);
            }
        }
    }
</script>