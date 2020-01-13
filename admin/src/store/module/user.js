import {login, register, getUser} from '../../api_my/user';
import {setToken, removeToken} from "../../util/auth";
const state = {
    user:null
}
const actions = {
    login:({state, commit}, data) => {
        return new Promise((resolve, reject) => {
            login(data).then(response => {
                resolve(response);
                commit('SET_USER', response.user);
                setToken(response.access_token);
                resolve();
            }).catch(e => {
                reject(e);
            })
        })
    },
    register:({state, commit}, data) => {
        return new Promise((resolve, reject) => {
            register(data).then(response => {
                resolve(response);
            }).catch(e => {
                reject(e);
            })
        })
    },
    getUser:({state, commit}) => {
        return new Promise((resolve, reject) => {
            getUser().then(response => {
                commit('SET_USER', response);
                resolve();
            }).catch(e => {
                removeToken();
                reject();
            })
        })
    }
}
const mutations = {
    SET_USER: (state, data) => {state.user = data}
}

export default {
    namespaced: true,
    state,
    actions,
    mutations,
};