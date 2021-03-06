 import Echo from 'laravel-echo'
 import secrete from './secrete';
 import {getToken} from "./utilis/auth";
 import config from './config';
 window.Pusher = require('pusher-js');

 window.Echo = new Echo({
     broadcaster: 'pusher',
     key: secrete.PUSHER_API_KEY,
     wsHost: '127.0.0.1',
     wsPort: 6001,
     authEndpoint: config.config.base_url+'/broadcasting/auth',
     auth: {
         headers: {
             'website_user_hash': getToken(),
         }
     },
 });
