import router from '../../router';
import {getData} from "../../api/bread";
import store from "../index";
const state = {
    websites: [],
};

const actions = {
    getWebsites(){
        return new Promise((resolve, reject) => {
            getData('Website', {user_id: store.getters.user.id, per_page: 1000}).then(res => {
                state.websites = res.data;
                resolve(res);
            }).catch(e => {})
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

