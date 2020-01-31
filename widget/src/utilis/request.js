import axios from 'axios';

import { getToken, setToken } from './auth';
import config from '../config';
const service = axios.create({
    baseURL: config.config.base_url,
    timeout: 10000, // Request timeout
    withCredentials: true
});

// Request intercepter
service.interceptors.request.use(
    config => {
        const token = getToken();
        if (token) {
            config.headers['website_user_hash'] = getToken();
        }
        config.headers['website_hash'] = website_hash;
        return config;
    },
    error => {
        Promise.reject(error);
    }
);

// response pre-processing
service.interceptors.response.use(
    response => {
        return response.data;
    },
    error => {

        return Promise.reject(error);
    },
);

export default service;
