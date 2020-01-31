<template>
    <div>
        <v-navigation-drawer
                light
                color="white"
                :mini-variant="!sidebar.opened"
                app

        >
            <v-toolbar flat>
                <div class="text-center w-100 d-flex justify-center">
                    <img style="max-width: 100%; object-fit: contain" :src="$root.getSrc('default/logo.png')" height="36" alt="Vue Material Admin Template" />
                    <div class="d-flex align-center">
                        <h3 v-if="sidebar.opened">Reporter</h3>
                    </div>

                </div>
            </v-toolbar>
            <v-list dense class="left-nav">
                <v-list-item-group
                            v-for="item in items"
                              :key="item.text"
                              v-if="item.visible && checkItem(item)">
                    <v-list-item style="min-height: 50px" v-if="!item.items && item.type != 'subtitle'" :to="(item.to && !item.items)? item.to : null">
                        <v-list-item-icon ><v-icon v-text="item.icon"></v-icon></v-list-item-icon>
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
                    { icon: 'web', text: 'Twoje strony', to: '/websites', visible: true},
                    {icon: 'mdi-contactless-payment', text: 'Kontakty', to: '/contacts', visible: true},
                    { icon: 'mdi-chart-tree', text: 'Kategorie', to: '/categories', visible: true},
                    { icon: 'mdi-chat', text: 'Chat na stronie', to: '/chat', visible: true},

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
<style lang="scss">
    @import "../../assets/variables";
    .left-nav{
        .v-list-item{
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            .v-list-item__title{
                color: $grey-color!important;
            }

            &:before{
                display: none !important;
            }
            i{
                color: #cbcbcb;
            }
            .v-list-item__icon{
                margin-top: 16px !important;
                margin-bottom: 16px !important;
            }

        }
        .v-item--active{
            .v-list-item__title{
                color: $black-color !important;
            }
            i{
                background: rgb(47,164,241);
                background: linear-gradient(90deg, rgba(47,164,241,1) 0%, rgba(147,102,205,1) 100%);
                -webkit-background-clip: text !important;
                -webkit-text-fill-color: transparent !important;
            }
        }
    }

</style>