import axios from 'axios';
import api from './api';
export default {
    index() {
        console.log(api+'homepage');
        let request = axios.get(api+'homepage').then((response) => {
            return response.data;
        }).catch(error => console.log(error));

        return request;
    },
    detail(slug) {
        let request = axios.get(api+'detail/'+slug).then((response) => {
            return response.data;
        }).catch((error) => {
            return error;
        });

        return request;
    },
}