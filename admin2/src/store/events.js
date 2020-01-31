import store from './index'
import {getChat} from "../api/chats";
const events = {
    NewMessage: (message) => {
        var chats = store.getters.chats.data;
        var active_chat = store.getters.activeChat;
        var index = chats.findIndex(x => x.id == message.chat_id)
        if(index == -1){
            getChat(message.chat.hash).then(response => {
                store.commit('chat/ADD_NEW_CHAT', response);
            })
        }else{
            console.log('ADD NEW CHAT MNESSAGE');
            store.commit('chat/ADD_CHAT_MESSAGE', message);
        }
        events.setUserOnline(message.chat.website_user);
    },
    setUserOnline: (user) => {
        store.getters.chats.data.forEach((item, id) => {
            if(item.website_user.id == user.id){
                store.commit('chat/SET_CHAT_USER_ONLINE', {index: id, is_online: true});
            }
        })
    }
}
export default events