const env = 'local';
const config = {
    base_url: (env == 'local')? 'http://localhost:8000' : 'https://foodapi.yaxint.nazwa.pl'
}

const storage = config.base_url+'/storage/';
export default {
    storage, config
};