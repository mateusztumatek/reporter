<template>
    <div style="height: 100%">
        <div class="chat" v-if="chat">
            <perfect-scrollbar ref="messages" class="messages">
                <v-list style="background-color: transparent !important;" subheader>
                    <v-subheader>Czat z pracownikiem</v-subheader>
                    <v-list-item v-if="chat.messages && chat.messages.length == 0">
                        <v-list-item-content>Brak wiadomości</v-list-item-content>
                    </v-list-item>
                    <v-list-item v-if="chat.messages" :class="{'reverse': message.type == 'website'}" v-for="message in chat.messages">
                        <v-list-item-avatar>
                            <v-img style="cursor: pointer" @click="$root.$eventBus.$emit('updateUser')" v-if="message.type == 'user'" :src="$root.getSrc(user.avatar)"></v-img>
                            <v-img v-if="message.type == 'website'" :src="$root.getSrc(website.logo)"></v-img>
                        </v-list-item-avatar>

                        <v-list-item-content style="flex: unset">
                            <v-list-item-title>

                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <span v-on="on">{{message.message}}</span>
                                    </template>
                                    <span>{{getMessageDiff(message)}}</span>
                                </v-tooltip>
                            </v-list-item-title>
                        </v-list-item-content>
                        <v-list-item-action>
                        </v-list-item-action>
                    </v-list-item>
                </v-list>
            </perfect-scrollbar>

            <div class="form">
                <v-textarea @input="typing" class="validation-hidden" outlined v-model="message.message" rows="3" label="Twoja wiadomość">
                    <template v-slot:append>
                        <transition name="grow">
                            <v-btn
                                    v-if="message != null && message != ''"
                                    absolute
                                    dark
                                    fab
                                    top
                                    right
                                    color="pink"
                                    small
                                    @click="sendMessage()"
                            >
                                <v-icon>mdi-send</v-icon>
                            </v-btn>
                        </transition>
                    </template>
                </v-textarea>
            </div>
        </div>
    </div>
</template>
<script>
    import {markAsRead} from "../api/chat";

    export default {
        beforeDestroy(){
            this.$store.commit('SET_APPEARANCE', {width: 400, height: 400});
        },
        data:() => {return {
           message:{
               type:'user',
           }
        }},
        mounted() {
            this.$store.commit('SET_APPEARANCE', {width: 400, height: 550});
            this.markAsRead();
/*
            this.$store.dispatch('getChat');
*/
        },
        watch:{
            chat:{
                deep:true,
                handler: function () {
                    this.scrollToBottom();
                    this.markAsRead();
                }
            }
        },
        computed:{
            website(){return this.$store.getters.website},
            user(){return this.$store.getters.user},
            chat(){
                return this.$store.getters.chat
            }
        },
        methods:{
            typing(message){
                Echo.join('Chat.'+this.chat.hash).whisper('typing', message);
            },
            markAsRead(){
                if(this.chat.messages){
                    var data = this.chat.messages.filter(item => {
                        if(item.type == 'user') return false;
                        if(item.seen) return false;
                        return true;
                    })
                    if(data.length > 0){
                        markAsRead(data.map(item => {return {id: item.id}}));
                        this.$store.commit('MARK_AS_READ', data);
                    }
                }

            },
            sendMessage(){
                if(!this.user.email){
                    this.$root.$eventBus.$emit('updateUser');
                    return null;
                }
                this.$store.dispatch('sendMessage', {...this.message, chat_hash: this.chat.hash}).then(res => {
                    this.scrollToBottom();
                });
                this.message = {type: 'user'};
                Echo.join('Chat.'+this.chat.hash).whisper('typing', '');
            },
            getMessageDiff(message){
                return message.created_at;
            },
            scrollToBottom(){
                this.$refs.messages.$el.scrollTop = 9999999999999;
            },
            addAttachment(){

            }
        }
    }
</script>