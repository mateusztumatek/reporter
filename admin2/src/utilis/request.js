import axios from 'axios';
import { getToken, setToken } from './auth';
import config from '../config';
// Create axios instance
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
            config.headers['Authorization'] = 'Bearer ' + getToken(); // Set JWT token
        }
        return config;
    },
    error => {
        // Do something with request error
        Promise.reject(error);
    }
);

// response pre-processing
service.interceptors.response.use(
    response => {
        if (response.headers.authorization) {
            setToken(response.headers.authorization);
            response.data.token = response.headers.authorization;
        }
        return response.data;
    },
    error => {
        if(error.response.status == 413){
            store.commit('app/ADD_ERROR', {text: 'Wysłany obrazek jest prawdopodobnie zbyt duży', cancelable: true});
        }
        let message = error.message;
        if (error.response.data && error.response.data.message) {
            message = error.response.data.message;
        }

        return Promise.reject(error);
    },
);

export default service;
