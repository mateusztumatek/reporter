import Request from '../utilis/request';
import config from "../config";
export function getWebsiteUser() {
    return Request({
        url: config.config.base_url+'/api/website_user',
        method: 'get',
    })
}
export function updateUser(data) {
    return Request({
        url: config.config.base_url+'/api/website_user',
        method: 'post',
        data: data
    })
}
export function upload(path, data) {
    return Request({
        url: config.config.base_url+'/api/upload/'+path,
        method: 'post',
        data: data
    })
}