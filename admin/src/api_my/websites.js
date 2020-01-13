import Request from '../util/request';
import config from  '../config';
export function getWebsites(params){
    return Request({
        url: '/api/websites',
        method: 'get',
        params: params
    })
}
