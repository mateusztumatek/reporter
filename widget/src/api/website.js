import Request from '../utilis/request';
import config from "../config";
export function getWebsite() {
    return Request({
        url: config.config.base_url+'/api/website',
        method: 'get',
    })
}