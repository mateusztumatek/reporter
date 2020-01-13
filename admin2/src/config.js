const env = 'local';
const config = {
    base_url: (env == 'local')? 'http://127.0.0.1:8000' : 'https://foodapi.yaxint.nazwa.pl'
}

const storage = config.base_url+'/storage/';
export default {
    storage, config
};