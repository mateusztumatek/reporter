import Request from '../utilis/request';
import config from "../config";
export function upload(data, path) {
    return Request({
        url: config.config.base_url+'/api/upload/'+path,
        method: 'post',
        data: data
    })
}
