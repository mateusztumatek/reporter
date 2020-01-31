import Request from '../utilis/request';
import config from "../config";
export function getContacts() {
    return Request({
        url: config.config.base_url+'/api/contacts',
        method: 'get',
    })
}