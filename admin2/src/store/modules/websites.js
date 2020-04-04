import router from '../../router';
import {getData} from "../../api/bread";
import store from "../index";
const state = {
    websites: [],
    websites_init: false,
};

const actions = {
    getWebsites(){
        return new Promise((resolve, reject) => {
            if(!state.websites_init){
                getData('Website', {user_id: store.getters.user.id, per_page: 1000}).then(res => {
                    state.websites = res.data;
                    state.websites_init = true;
                    resolve(res);
                }).catch(e => {})
            }else{
                resolve();
            }
        })
    }
}
const mutations = {
    SET_NOTIFICATIONS: (state, value) => {state.notifications = value}
};

export default {
    namespaced: true,
    actions,
    state,
    mutations,
};

