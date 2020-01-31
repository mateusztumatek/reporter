import Request from '../utilis/request';
import config from "../../../widget/src/config";
export function getChats(params) {
    return Request({
        url:'/api/chats',
        method:'get',
        params: params
    })
}
export function getChat(hash, params) {
    return Request({
        url:'/api/chats/'+hash,
        method:'get',
        params: params
    })
}
export function sendMessage(data) {
    return Request({
        url: config.config.base_url+'/api/chats/message',
        method: 'post',
        data: data
    })
}
export function markAsRead(data) {
    return Request({
        url: config.config.base_url+'/api/chats/markAsRead',
        method:'post',
        data: data
    })
}