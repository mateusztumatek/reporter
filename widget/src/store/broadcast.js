import {store} from './index';
export default {
    watchChat: () => {
        Echo.channel('ChatChannel.'+store.getters.chat.hash)
            .listen('.message', (e) => {
                e = e.chat_message;
                var messages = store.getters.chat.messages;
                store.commit('ADD_CHAT_MESSAGE', e);
            })
    }
}
