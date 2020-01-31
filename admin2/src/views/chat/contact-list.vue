<template>
    <div>
        <v-navigation-drawer
                style="height: calc(100vh - 64px)"
                class="pt-5"
                v-model="drawer"
                persistant
                expand-on-hover
                width="500px"
        >
            <v-toolbar flat dense>
                <v-text-field clearable full-width prepend-icon="search" label="Search"></v-text-field>
            </v-toolbar>
            <vue-perfect-scrollbar class="chat-history--scrollbar">
                <v-divider></v-divider>
                <v-list two-line class="chat-contact--list">
                    <v-list-item :to="'/chat/'+item.hash" hover v-for="(item, index) in filteredChats">
                        <v-badge
                                bordered
                                top
                                overlap
                                color="red"
                                dot
                        >
                            <template v-slot:badge>
                                {{item.unseen_count}}
                            </template>
                            <v-list-item-avatar color="primary">
                                <img :src="$root.getSrc(item.website_user.avatar)" v-if="item.website_user.avatar" />
                            </v-list-item-avatar>
                        </v-badge>
                        <v-list-item-content>
                            <v-list-item-title>
                                <p class="mb-0">{{ item.website_user.name }}</p>
                                <p class="mb-0 caption grey--text">{{ item.website_user.email }}</p>
                                <p  class="mb-0 caption grey--text">{{item.website_user.address}}</p>
                            </v-list-item-title>
                        </v-list-item-content>
                        <v-list-item-action>
                            <span class="grey--text caption">{{item.last_message}}</span>
                            <div class="dot" :style="{'background-color': userStatusColor(item.website_user)}"></div>
                        </v-list-item-action>
                    </v-list-item>
                </v-list>
            </vue-perfect-scrollbar>
        </v-navigation-drawer>
    </div>
</template>
<script>
    import VuePerfectScrollbar from 'vue-perfect-scrollbar'

    export default {
        components:{VuePerfectScrollbar},
        data:() => {
            return{
                drawer: true
            }
        },
        methods:{
            userStatusColor(user){
                return (user.online)? 'green' : 'red';
            },
        },
        computed:{
            filteredChats(){
                if(!this.chats || !this.chats.data) return [];
                return this.chats.data.sort((a, b) => {
                    return Date.parse(b.last_message) - Date.parse(a.last_message)
                })
            },
            chats(){return this.$store.getters.chats}
        }
    }
</script>
<style lang="scss">
    .dot{
        width: 10px;
        height: 10px;
        border-radius: 100%;
    }
    .v-badge__badge{
        top: 5px !important;
        right: 15px !important;
    }
</style>