<template>
    <div>
        <v-badge
                v-if="unseenMessages > 0"
                color="red"
                overlap
        >
            <template v-slot:badge>{{unseenMessages}}</template>
            <v-btn @click="toggleOpened()" color="primary" fab x-large><v-icon v-if="!is_opened">mdi-exclamation-thick</v-icon><v-icon v-else>mdi-window-close</v-icon></v-btn>
        </v-badge>
        <v-btn style="width: 100%; height: 100%" v-else @click="toggleOpened()" color="primary" fab><v-icon v-if="!is_opened">mdi-exclamation-thick</v-icon><v-icon v-else>mdi-window-close</v-icon></v-btn>
    </div>
</template>
<script>
    export default {
        computed:{
            is_opened(){
                return this.$store.getters.is_opened;
            },
            unseenMessages(){
                var chat = this.$store.getters.chat;
                if(!chat) return 0;
                if(chat.messages){
                    var messages = chat.messages.filter(item => {return item.seen == false && item.type == 'website'});
                    return messages.length;
                }else{
                    return 0;
                }

            }
        },
        methods:{
            toggleOpened(){
                this.$store.dispatch('toggleWindow', !this.is_opened);
            }
        }
    }
</script>