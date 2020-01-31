import Request from '../utilis/request';
export function getData(model, params) {
    return Request({
        url:'/api/bread/'+model,
        method:'get',
        params: params
    })
}

export function saveData(model, data) {
    return Request({
        url:'/api/bread/'+model,
        method:'post',
        data: data
    })
}
export function updateData(model,id, data) {
    return Request({
        url:'/api/bread/'+model+'/'+id,
        method:'put',
        data: data
    })
}
export function getSingleData(model, id) {
    return Request({
        url:'/api/bread/'+model+'/'+id,
        method:'get',
    })
}
