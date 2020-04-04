import {store} from './index';
import vuetify from '../plugins/vuetify';
export default {
    SET_WEBSITE:(state, data) => {state.website = data},
    TOOGLE_WINDOW: (state, data) => {
        state.is_opened = data
        store.dispatch('setWindowSize')
    },
    SET_ACTIVE_WINDOW:(state, data) => {state.activeWindow = data},
    SET_CHAT: (state, data) => {state.chat = data},
    SET_LOADING: (state, data) => {state.loading = data},
    SET_APPEARANCE: (state, data) => {
        state.appearance = data;
        store.dispatch('setWindowSize');
    },
    SET_CHAT_SETTINGS:(state, data) => {
        vuetify.framework.theme.themes.light.primary = data.primary;
        state.chat_settings = data;
        console.log(vuetify.framework.theme.themes.light);
    },
    ADD_CHAT_MESSAGE: (state, data) => {
        if(state.chat.id == data.chat_id && state.chat.messages.findIndex(x => x.id == data.id) == -1){
            state.chat.messages.push(data);
        }
    },
    MARK_AS_READ: (state, data) => {
        state.chat.messages.forEach(item => {
            if(data.findIndex(x => x.id == item.id) != -1) item.seen = true;
        });
    },
    SET_CONTACTS:(state, data) => {
        state.contacts = data;
    },
    SET_ACTIVE_CONTACT:(state, data) => {
        state.activeContact = data;
    }
}