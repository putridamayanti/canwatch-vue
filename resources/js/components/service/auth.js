import axios from 'axios';
import api from './api';
export default {
    login(params) {
        let request = axios.post(api+'login', params).then((response) => {
            console.log(response);
            return response.data;
        }).catch((error) => {
            console.log(error);
            return {
                'status' : 'error_connection',
                'error' : error
            };
        });

        return request;
    },
}