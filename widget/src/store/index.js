import Vue from 'vue'
import Vuex from 'vuex'
import Axios from 'axios'
import getters from './getters';
import actions from './actions';
import mutations from './mutations'
import state from './state'
Vue.use(Vuex);

export const store = new Vuex.Store({
    actions,
    getters,
    mutations,
    state
})