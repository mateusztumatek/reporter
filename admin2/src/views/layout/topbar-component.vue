<template>
    <div>
        <v-app-bar
                fixed
                dark
                app
                color="primary"
                class="my-header"
        >
            <v-app-bar-nav-icon @click="toggleSidebar()"></v-app-bar-nav-icon>

                <v-spacer></v-spacer>
                <v-toolbar-items v-if="!isTransparent()">
                    <v-btn icon @click="fullScreen()">
                        <v-icon>fullscreen</v-icon>
                    </v-btn>
                    <v-menu offset-y origin="center center" :nudge-bottom="10" transition="scale-transition" v-if="user.id">
                        <template v-slot:activator="{ on }">
                            <v-btn v-on="on" icon large >
                                <v-avatar size="30px">
                                    <img style="object-fit: cover" :src="$root.getSrc(user.image)" alt="Michael Wang" />
                                </v-avatar>
                            </v-btn>
                        </template>

                        <v-list class="pa-0">
                            <v-list-item
                                    v-for="(item, i) in menu_items"
                                    :key="i"
                                    @click="item.handler"
                            >
                                <v-list-item-icon>
                                    <v-icon v-text="item.icon"></v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title v-text="$t(item.name)"></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </v-toolbar-items>
        </v-app-bar>
    </div>
</template>
<script>
    import { mapGetters, mapActions} from 'vuex';
    import Notification from '../../components/notifications';
    import Autocomplete from './autocomplete';
    import util from '../../utilis';
    import LangSwitcher from '../../components/lang-switcher';
    export default {
        components:{
          NotificationList: Notification,LangSwitcher,
            Autocomplete
        },

        data(){
            return{
                menu_items:[
                    {
                        name: 'Edytuj konto',
                        icon: 'mdi-account-edit',
                        handler: () => {this.$router.push('/user/edit')},
                    },
                    {
                        name: 'Dodaj miejsce',
                        icon: 'mdi-account-edit',
                        handler: () => {this.$router.push('/place/create')},
                    },
                    {
                        name: 'Wyloguj się',
                        icon: 'mdi-logout',
                        handler: () => {this.logout()},
                    }
                ]
            }
        },
        computed:{
            ...mapGetters([
                'user',
            ]),
        },
        mounted(){

        },
        methods:{
          isTransparent(){
            if(this.$route.name == 'login' || this.$route.name == 'register') return true;
            return false;
          },
          toggleSidebar(){
            this.$store.dispatch('navigation/toggleSideBar');
          },
          fullScreen(){
           util.toggleFullScreen();
          },
          logout(){
              this.$store.dispatch('user/logout');
          }
        }
    }
</script>
<style lang="scss">
    .my-header{
        .v-toolbar__content{
/*
            transition: all 300ms;
*/
        }
    }
    .searching{
        .v-toolbar__content{
            transform: translateX(-40px);
            width: 150%;
        }
    }

</style>