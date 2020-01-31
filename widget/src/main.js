require('./bootstrap');
import Vue from 'vue'
import App from './App.vue'
import mixins from './mixinsj';
import config from './config';
import vuetify from './plugins/vuetify';
Vue.prototype.$eventBus = new Vue(); // add this line of code
import PerfectScrollbar from 'vue2-perfect-scrollbar'
import 'vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css'

Vue.use(PerfectScrollbar)
import {store} from './store/index';
Vue.config.productionTip = false;
Vue.mixin(mixins);
new Vue({
    data(){
        return{
            base_url: null
        }
    },

    mounted(){
        this.base_url = config.config.base_url;
    },

    methods:{
        isMobile(){
            if(/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) return true
            else return false;
        },
        getSrc(src){
            return config.storage+''+src;
        }
    },
    store,

    vuetify,
    render: h => h(App)
}).$mount('#reporter-app')