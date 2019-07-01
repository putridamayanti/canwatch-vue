import axios from 'axios';
import api from './api';
export default {
    index() {
        let request = axios.get(api+'episode').then((response) => {
            return response;
        }).catch(error => console.log(error));

        return request;
    },

    store(params) {
        let request = axios.post(api+'episode', params).then((response) => {
            return response.data;
        }).catch((error) => {
            console.log(error);
            this.error = true;
        });

        return request;
    },

    edit(id) {
        console.log(id);
        let request = axios.get(api+'episode/'+id+'/edit').then((response) => {
            return response.data;
        }).catch((error) => {
            console.log(error);
        });

        return request;
    },

    update(id, params) {
        let request = axios.patch(api+'episode/'+id, params).then((response) => {
            console.log(response);
            return response.data;
        }).catch((error) => {
            console.log(error);
            this.error = true;
        });

        return request;
    },

    delete(id) {
        let request = axios.delete(api+'episode/'+id).then((response) => {
            return response;
        }).catch((error) => {
            console.log(error);
        });

        return request;
    }
}