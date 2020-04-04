<template>
    <v-app>
       <div class="row">
           <div class="col-lg-5 col-md-7 d-flex justify-center align-center">
               <div class="col-md-10 col-xs-12">
                   <transition name="route" mode="out-in">
                       <router-view :key="$route.path"></router-view>
                   </transition>
               </div>
           </div>
           <div class="col-lg-7 col-md-5 pa-0" v-if="!isSmall">
               <v-img style="height: 100vh; width: 100%" :src="$root.getSrc('default/login.jpg')"></v-img>
           </div>
       </div>
        <errors-component></errors-component>
    </v-app>
</template>

<script>
    import ErrorsComponent from './components/errors';

    export default {
        components:{ErrorsComponent},
        computed:{
            isSmall(){
                return this.$vuetify.breakpoint.smAndDown;
            }
        },
        data: () => ({}),

        methods: {}
    }
</script>
<style scoped lang="scss">
    .split-bg {
        height: 50%;
        width: 100%;
        position: absolute;
        top: 0;
        left: 0;
        content: "";
        z-index: 0;
    }
    @import "assets/custom.scss";
</style>
