import Request from '../utilis/request';
import config from "../../../widget/src/config";
export function saveContacts(data) {
    return Request({
        url:'/api/contacts',
        method:'post',
        data: data
    })
}