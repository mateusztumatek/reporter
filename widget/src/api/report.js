import Request from '../utilis/request';
import config from "../config";
export function storeReport(data) {
    return Request({
        url: config.config.base_url+'/api/reports',
        method: 'post',
        data: data
    })
}
