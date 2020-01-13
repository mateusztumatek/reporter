<template>
    <div>
        <v-navigation-drawer
                v-model="sidebar.opened"
                app

        >
            <v-toolbar color="primary darken-1" dark>
                <div class="text-center w-100">
                    <img src="/static/logo-white.svg" height="36" alt="Vue Material Admin Template" />
                </div>
            </v-toolbar>
            <v-list dense>
                <v-list-item-group
                            v-for="item in items"
                              :key="item.text"
                              v-if="item.visible && checkItem(item)">
                    <v-list-item  v-if="!item.items && item.type != 'subtitle'" :to="(item.to && !item.items)? item.to : null">
                        <v-list-item-icon><v-icon v-text="item.icon"></v-icon></v-list-item-icon>
                        <v-list-item-title>{{$t(item.text)}}</v-list-item-title>
                    </v-list-item>
                    <v-list-group v-if="item.items && item.type != 'subtitle'">
                        <template v-slot:activator>
                            <v-list-item-icon><v-icon v-text="item.icon"></v-icon></v-list-item-icon>
                            <v-list-item-title>{{item.icon}}</v-list-item-title>
                        </template>
                        <v-list-item v-for="subitem in item.items" :to="subitem.to">
                            <v-list-item-content>
                                <v-list-item-title>{{$t(subitem.text)}}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-group>
                    <v-subheader class="mt-4 grey--text text--darken-1" v-if="item.type == 'subtitle'">{{$t('item.text')}}</v-subheader>
                </v-list-item-group>
                <div class="navigation-tick"></div>
            </v-list>
        </v-navigation-drawer>
    </div>
</template>
<script>
    export default {
        props:['open'],
        data(){
            return{
                drawer: false,
                items: [
                    { icon: 'home', text: 'Strona główna', to: '/', visible: true},
                    { icon: 'mdi-account-badge-horizontal', text: 'Załóż konto', guest: true, to: '/register', visible: true},
                    { icon: 'mdi-account', text: 'Zaloguj się', to: '/login', guest: true, visible: true},
                    {type: 'subtitle', text: 'Manage your shop', visible: true, hasPlace: true},
                    { icon: 'mdi-alarm-check', text: 'Twoje miejsca', to:'/place', visible: true, hasPlace: true},
                    { icon: 'mdi-package-variant-closed', text: 'Produkty', to:'/products', visible: true, hasPlace:true},
                    { icon: 'mdi-qrcode', text: 'Generuj kody QR', to:'/generate_qr', visible: true, hasPlace:true},
                    { icon: 'favorite', text: 'Kategorie', to:'/categories', visible: true, hasPlace: true},
                    { icon: 'mdi-cart', text: 'Zamówienia', to:'/orders', visible: true, hasPlace: true},
                    { icon: 'mdi-chart-areaspline-variant', text: 'Statystyki', to:'/stats', visible: true, hasPlace: true},
                    { icon: 'mdi-sale', text: 'Kody zniżkowe', to:'/codes', visible: true, hasPlace: true},

                    /*{ icon: 'favorite', text: 'Kategorie2', to:'/cateories', visible: true, hasPlace: true,
                        items:[
                            {icon: 'home', text: 'Podstrona', to: '/'}
                        ]
                    },*/
                ],
            }
        },
        computed:{
            user() {return this.$store.getters.user},
            activeSellout() {return (this.$store.getters.activeSellout)? this.$store.getters.activeSellout : {}},
            sidebar() {
                return this.$store.getters.sidebar;
            }
        },
        mounted(){
        },
        methods:{
            checkItem(item){
                if(item.guest && this.user.id) return false;
                if(item.hasPlace){
                    if(!this.user.id) return false
                    return true;
                }else{
                    return true;
                }
            }
        }
    }
</script>