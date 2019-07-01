import axios from 'axios';
import api from './api';
export default {
    drama(params) {
        console.log('Params', params);
        let request = axios.post(api+'drama/get', params).then((response) => {
            return response.data;
        }).catch(error => console.log(error));

        return request;
    },
}