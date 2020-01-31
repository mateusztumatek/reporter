<template>
  <v-app class="reporter-app" :style="colors">
    <v-content ref="content" :style="contentVars" class="reporter-app-content">
        <transition name="slideInLeft">
            <main-window v-if="is_opened"></main-window>
        </transition>
        <markerk-component class="btn-toggler" :class="{'btn-toggler-opened': is_opened}"></markerk-component>
    </v-content>
  </v-app>
</template>
<script>
import MarkerkComponent from './components/marker-component';
import MainWindow from './components/main-window';
import {getWebsiteUser} from "./api/user";
import {getWebsite} from "./api/website";
import {setToken} from "./utilis/auth";

export default {
    components:{
        MarkerkComponent,
        MainWindow
    },
  name: 'App',
    computed:{
        is_opened(){
            return this.$store.getters.is_opened;
        },
        isAnimation(){

        },
        contentVars(){
            var tmp = this.$store.getters.windowSize;
            var calcWidth = tmp.width;
            var calcHeight = tmp.height;
            return {
                '--content-width': calcWidth+'px',
                '--content-height': calcHeight+'px',
            }
        },
        colors(){
            return{
                '--primary-color': this.$vuetify.theme.themes.light.primary,
                '--width-button': '70px',
                '--height-button': '70px',
            }
        }
    },
    mounted() {
        this.$store.dispatch('getWebsite');
        this.$store.dispatch('setWindowSize');
        new ResizeObserver(() => {
            if(this.$refs.content){
                window.parent.postMessage({width: this.$refs.content.$el.clientWidth, height: this.$refs.content.$el.clientHeight}, '*');
            }
        }).observe(this.$refs.content.$el);
        var x = this.contentVars;
    },
    methods:{

    }
};
</script>
<style lang="scss">
    .v-application{
        background-color: transparent !important;
    }
    .reporter-app{
        @import "./assets/custom";
        .v-content{
            transition-duration: 0ms !important;
        }
        .reporter-app-content{
            width: fit-content;
            min-width: var(--content-width);
            min-height: var(--content-height);
            padding: 15px !important;
            .v-content__wrap{
                display: flex;
                justify-content: flex-end;
                align-items: flex-end;
            }
        }
    }
    #app{
        overflow: hidden;
        border: none !important;
        padding: 0px;
        position: fixed;
        right: 0px;
        bottom: 0px;
    }
</style>
