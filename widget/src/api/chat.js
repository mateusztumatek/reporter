import Request from '../utilis/request';
import config from "../config";
export function getChat() {
    return Request({
        url: config.config.base_url+'/api/chat',
        method: 'get',
    })
}
export function sendMessage(data) {
    return Request({
        url: config.config.base_url+'/api/chat_message',
        method: 'post',
        data: data
    })
}
export function markAsRead(data) {
    return Request({
        url: config.config.base_url+'/api/chat/markAsRead',
        method:'post',
        data: data
    })
}