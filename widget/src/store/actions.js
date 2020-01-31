import {getWebsite} from "../api/website";
import {getWebsiteUser, updateUser} from "../api/user";
import {setToken} from "../utilis/auth";
import {getChat, sendMessage} from "../api/chat";
import {getContacts} from "../api/contacts";
import broadcast from './broadcast';
export default {
    getWebsite({state, commit}){
        return new Promise((resolve, reject) => {
            getWebsite().then(response => {
                commit('SET_WEBSITE', response);
            })
        })
    },
    toggleWindow:({state, commit, dispatch}, data) => {
        if(data && state.user == null){
            getWebsiteUser().then(response => {
                setToken(response.session_hash);
                state.user = response;
                dispatch('getChat');
                commit('TOOGLE_WINDOW', data);
            })
        }else{
            commit('TOOGLE_WINDOW', data);
        }
    },
    getChat:({state, commit}) => {
        if(state.chat == null){
            commit('SET_LOADING', true);
            getChat().then(response => {
                commit('SET_CHAT', response);
                commit('SET_LOADING', false);
                broadcast.watchChat();
            })
        }
    },
    sendMessage({state, commit}, data) {
        return new Promise((resolve, reject) => {
            sendMessage(data).then(response => {
                commit('ADD_CHAT_MESSAGE', response);
                resolve(response);
            }).catch(e => {
                console.log(e.response);
            })
        })
    },
    updateUser:({state, commit}, data) => {
        return new Promise((resolve, reject) => {
            updateUser(data).then(response => {
                state.user = response;
                resolve(response);
            })
        })
    },
    getContacts({state, commit}){
        return new Promise((resolve, reject) => {
            if(state.contacts){
                resolve();
            }
            getContacts().then(res => {
                commit('SET_CONTACTS', res);
                resolve(res);
            })
        })
    },
    addMessage:({state, commit}, data) => {
        state.messages.push(data);
    },
    setWindowSize:({state, commit}) => {
        if(!state.is_opened){
            state.windowSize.width = 700;
            state.windowSize.height = 700;
            setTimeout(() => {
                state.windowSize.width = 100;
                state.windowSize.height = 100;
            }, 400)
        }else{
            var appearance = state.appearance;
            var calcWidth = appearance.width + 65;
            var calcHeight = appearance.height + 65;
            state.windowSize.width = calcWidth;
            state.windowSize.height = calcHeight;
        }


    }
}