import Vue from "vue"
import Router from "vue-router"
import { publicRoute, protectedRoute } from "./config"
import NProgress from "nprogress"
import "nprogress/nprogress.css"
import store from '../store/index';
import {getToken, } from "../util/auth";

protectedRoute.forEach(item => {
  if(item.meta){
    item.meta.auth = true;
  }
  if(item.children){
    item.children.forEach(item_2 => {
      if(!item_2.meta) item_2.meta = {};
      item_2.meta.auth = true;
    })
  }
})
const routes = publicRoute.concat(protectedRoute)

Vue.use(Router)
const router = new Router({
  mode: "history",
  linkActiveClass: "active",
  routes: routes
})
// router gards
router.beforeEach((to, from, next) => {
  NProgress.start();
  const hasToken = getToken();
  if (hasToken) {
    if (to.name === 'login') {
      // if is logged in, redirect to the home page
      next({ path: '/' });
    } else {
      if(!store.getters.user){
        store.dispatch('user/getUser').then(response => {
          next();
        });
      }else{
        next();
      }
    }
  } else {
    if (to.meta.auth == true) {
      // in the free login whitelist, go directly
      next({path: '/auth'});
    } else {
      next();
    }
  }
})

router.afterEach((to, from) => {
  NProgress.done()
})

export default router
