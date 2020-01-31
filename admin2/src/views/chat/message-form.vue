<template>
    <div class="w-100" style="height: 100%">
        <v-progress-circular
                v-if="loading"
                indeterminate
                color="primary"
        ></v-progress-circular>
        <div ref="messages" v-if="chat" class="chat">
            <div>
                <v-toolbar flat dense color="transparent" class="mb-4">
                    <v-avatar :size="40">
                        <v-img :src="$root.getSrc(chat.website_user.avatar)"></v-img>
                    </v-avatar>
                    <div class="ml-3">
                        <h2 class="headline">{{chat.website_user.name}}</h2>
                        <p class="mb-0 grey--text caption">{{chat.website_user.address}}</p>
                    </div>

                    <v-spacer></v-spacer>
                    <v-btn text icon><v-icon>mdi-dots-vertical</v-icon></v-btn>
                </v-toolbar>
                <v-list subheader style="background-color: transparent !important;">
                    <v-list-item v-if="chat.messages.length == 0">
                        <v-list-item-content>Brak wiadomości</v-list-item-content>
                    </v-list-item>
                    <v-list-item :class="{'reverse': message.type == 'website'}" v-for="message in chat.messages">
                        <v-list-item-avatar>
                            <v-img style="cursor: pointer" v-if="message.type == 'user'" :src="$root.getSrc(chat.website_user.avatar)"></v-img>
                            <v-img v-if="message.type == 'website'" :src="$root.getSrc(chat.website.logo)"></v-img>
                        </v-list-item-avatar>

                        <v-list-item-content style="flex: unset">
                            <v-list-item-title>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <span v-on="on">{{message.message}}</span>
                                    </template>
                                    <span>{{message.created_at}}</span>
                                </v-tooltip>
                            </v-list-item-title>
                        </v-list-item-content>
                        <v-list-item-action>
                        </v-list-item-action>
                    </v-list-item>
                    <v-list-item v-if="typing">
                        <div class="d-flex">
                            <div class="wave mr-3">
                                <span class="dot"></span>
                                <span class="dot"></span>
                                <span class="dot"></span>
                            </div>
                            Użytkownik pisze: {{typing}}
                        </div>

                    </v-list-item>
                </v-list>
            </div>
            <v-text-field height="20%" dense v-model="message.message" style="flex: none" outlined label="Wiadomość">
                <template v-slot:append>
                    <v-btn @click="sendMessage()" :disabled="!message.message || message.message == ''"  text fab><v-icon>mdi-send</v-icon></v-btn>
                </template>
            </v-text-field>
        </div>

    </div>
</template>
<script>
    import VuePerfectScrollbar from 'vue-perfect-scrollbar'
    export default {
        components:{
            VuePerfectScrollbar
        },
        beforeDestroy(){
            this.$store.commit('chat/SET_ACTIVE_CHAT', null);
        },
        data:() => {
            return{
                loading: true,
                message:{
                    type:'website'
                },
                typing: null
            }
        },
        watch:{
            chat:{
                deep: true,
                handler(){
                    var items = this.chat.messages.filter(item => {
                        return item.seen == false && item.type == 'user';
                    })
                    if(items.length > 0){
                        this.$store.dispatch('chat/setAsRead', items);
                    }
                }
            }
        },
        computed:{
            chat(){
                return this.$store.getters.activeChat
            }
        },
        mounted(){
            this.getChat()
            Echo.join('Chat.'+this.$route.params.hash)
                .listenForWhisper('typing', (e) => {
                    this.typing = e;
                })
        },
        methods:{
            sendMessage(){
                this.$store.dispatch('chat/sendMessage', {...this.message, chat_hash: this.chat.hash}).then(res => {
                    this.scrollToBottom();
                });
                this.message = {type: 'website'};
            },
            getChat(){
                this.$store.dispatch('chat/getChat', this.$route.params.hash).then(response => {
                    this.loading = false;
                })
            },
            scrollToBottom(){
                this.$refs.messages.scrollTop = 9999999999999;
            },
        }
    }
</script>
<style lang="scss">
    .chat{
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
</style>