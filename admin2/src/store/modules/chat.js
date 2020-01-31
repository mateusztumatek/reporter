import events from '../events';
import Vue from 'vue';
import {getChats, getChat, sendMessage, markAsRead} from "../../api/chats";
import store from '../index';
const state = {
   chats:[],
   chats_resolved: false,
    activeChat:null
};

const mutations = {
    SET_CHAT_USER_ONLINE: (state, data) => {
          state.chats.data[data.index].website_user.online = data.is_online;
    },
    SET_ACTIVE_CHAT:(state, data) => {
        state.activeChat = data;
    },
    ADD_CHAT_MESSAGE: (state, data) => {
        if(state.activeChat){
            if(state.activeChat.id == data.chat_id && state.activeChat.messages.findIndex(x => x.id == data.id) == -1){
                state.activeChat.messages.push(data);
            }
        }

        var index = state.chats.data.findIndex(x => x.id == data.chat_id);
        if(index != -1){
            if(!state.chats.data[index].messages) Vue.set(state.chats.data[index], 'messages', []);
            if(state.chats.data[index].messages.findIndex(x => x.id == data.id) == -1){
                state.chats.data[index].messages.push(data);
                state.chats.data[index].last_message = data.chat.last_message;
                if(!state.activeChat || state.chats.data[index].id != state.activeChat.id){
                    state.chats.data[index].unseen_count = state.chats.data[index].unseen_count + 1;
                }
            }
        }
    },
    ADD_NEW_CHAT: (state, data) => {
        state.chats.data.unshift(data);
    }
};

const actions = {
    getChats({ commit }) {
        return new Promise((resolve, reject) => {
            if(!state.chats_resolved){
                getChats().then(response => {
                    state.chats = response;
                    state.chats_resolved = true;
                })
            }else{
                resolve();
            }
            var user_id = store.getters.user.id;
            Echo.channel('private-UserEvents.'+user_id)
                .listen('.message', (e) => {
                    events.NewMessage(e.chat_message);
                })
        })
    },
    getChat({state, commit}, hash){
        return new Promise((resolve, reject) => {
            getChat(hash, {markAsSeen: true}).then(response => {
                state.activeChat = response;
                if(state.chats.data){
                    var index = state.chats.data.findIndex(x => x.id == response.id)
                    if(index != -1) state.chats.data[index] = response;
                }
                resolve(response);
            })
        })
    },
    sendMessage({state, commit}, data) {
        return new Promise((resolve, reject) => {
            sendMessage(data).then(response => {
                resolve(response);
            }).catch(e => {
            })
        })
    },
    setAsRead({state, commit}, data){
        markAsRead(data.map(item => {
            return {id: item.id}
        }))
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
};
