<template>
    <div refs="main" class="main-card rounded-card" :style="varCss">
        <transition name="toggle" mode="in-out">
            <v-card :loading="loading" v-if="is_opened" class="elevation-5" style="width: 100%; height: 100%">
                <v-toolbar color="primary" :prominent="activeWindow == null" dark src="https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg">
                    <v-toolbar-title class="animated fadeIn" v-if="activeWindow == null || activeWindow == -1">Nazwa strony</v-toolbar-title>
                    <v-btn v-if="activeWindow != null && activeWindow >= 0" icon @click="(!$store.getters.activeContact)? $store.commit('SET_ACTIVE_WINDOW', null) : $store.commit('SET_ACTIVE_CONTACT', null)" class="animated fadeIn">
                        <v-icon>mdi-arrow-left-thick</v-icon>
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn icon>
                        <v-icon>mdi-heart</v-icon>
                    </v-btn>
                    <v-btn icon>
                        <v-icon>mdi-dots-vertical</v-icon>
                    </v-btn>
                </v-toolbar>
                <v-card-text :style="{'height': 'calc(100% - '+headerHeight+'px)'}">
                    <chat-component key="chat" v-if="activeWindow == 0"></chat-component>
                    <contact-component v-if="activeWindow == 1"></contact-component>
                    <report-component v-if="activeWindow == 2"></report-component>
                    <v-list rounded v-if="activeWindow == null" key="list">
                        <v-subheader>Wybierz akcje</v-subheader>
                        <v-list-item-group :value="activeWindow" @input="changeWindow" color="primary">
                            <v-list-item
                                    @click="changeWindow(i)"
                                    v-for="(item, i) in items"
                                    :key="i"
                            >
                                <v-list-item-icon>
                                    <v-icon v-text="item.icon"></v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title v-text="item.text"></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-item-group>
                    </v-list>
                </v-card-text>
            </v-card>
        </transition>
        <error-component></error-component>
        <update-user-component></update-user-component>
    </div>
</template>
<script>
    import UpdateUserComponent from './update-user-component';
    import ChatComponent from './chat-component';
    import ContactComponent from './contact-component';
    import ReportComponent from './report-component';
    import ErrorComponent from './error-component';
    export default {
        components:{ChatComponent, UpdateUserComponent, ContactComponent, ReportComponent, ErrorComponent},
        data(){
            return{
                items: [
                    { value: 'chat', text: 'Otwórz czat', icon: 'mdi-chat-outline' },
                    { text: 'Kontakt', value: 'contacts', icon: 'mdi-phone-outline' },
                    { text: 'Conversions', value: 'report', icon: 'mdi-flag-outline' },
                ],
            }
        },
        computed:{
            headerHeight(){
                if(this.activeWindow == null) return 120;
                return 64;
            },
            loading(){
                return this.$store.getters.loading
            },
          activeWindow(){
              return this.$store.getters.activeWindow
          },
          is_opened(){
              return this.$store.getters.is_opened;
          },
          varCss(){
              var appearance = this.$store.getters.appearance;
              return{
                  '--width': appearance.width+'px',
                  '--height': appearance.height+'px',
              }
          }
        },
        mounted(){
        },
        methods:{
            changeWindow(value){
                this.$store.commit('SET_ACTIVE_WINDOW', value);
            }
        }
    }
</script>
