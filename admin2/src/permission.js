import router from './router';
import store from './store';
import {getToken, removeToken} from './utilis/auth';
import Vue from 'vue';
/*router.beforeEach(async (to, from, next) => {
    if(!store.getters.app.langs){
        store.dispatch('app/getLangs');
    }
    console.log(store.getters.notifications);
    if(store.getters.notifications == null){
        store.dispatch('notifications/getNotifications');
    }
    store.dispatch('user/checkLocation');
    next();
})*/
router.beforeEach(async(to, from, next) => {
    // start progress bar
    // set page title
    if(to.meta.title){
        document.title =to.meta.title;
    }

    store.commit('app/setLoading', true);
    // determine whether the user has logged in
    const hasToken = getToken();
    if (hasToken) {
        if (to.meta.guest == true) {
            next({ path: '/' });
        } else {
            if(!store.getters.user.id){
                store.dispatch('user/getUser').then(response => {
                    if(!store.getters.user.email_verified_at){
                        if(to.path !== '/verify'){
                            next('/verify');
                        }
                    }
                    if(to.path == '/verify') next('/');
                    store.dispatch('websites/getWebsites').then(response => {
                        next();
                    })
                });
            }else{
                store.dispatch('websites/getWebsites').then(response => {
                    next();
                })
            }
        }
    } else {
        if (to.meta.auth == true) {
            // in the free login whitelist, go directly
            next({path: '/login'});
        } else {
            next();
        }
    }
});

router.afterEach((to) => {
    if(to.meta.header_visible){
        store.commit('navigation/SET_HEADER', {title: ''});
    }else store.commit('navigation/RESET_HEADER');
    if((store.getters.user.is_facebook || store.getters.user.is_google) && store.getters.user.last_password_change == null){
        setTimeout(() => {
            Vue.prototype.$eventBus.$emit('updateUserPassword');
        }, 1000)
    }
})