import axios from 'axios';
import api from './api';
export default {
    index() {
        let request = axios.get(api+'resource').then((response) => {
            return response;
        }).catch(error => console.log(error));

        return request;
    },

    store(params) {
        let request = axios.post(api+'resource', params).then((response) => {
            return response;
        }).catch((error) => {
            console.log(error);
            this.error = true;
        });

        return request;
    },

    edit(id) {
        console.log(id);
        let request = axios.get(api+'resource/'+id+'/edit').then((response) => {
            return response.data;
        }).catch((error) => {
            console.log(error);
        });

        return request;
    },

    update(id, params) {
        let request = axios.patch(api+'resource/'+id, params).then((response) => {
            console.log(response);
            return response;
        }).catch((error) => {
            console.log(error);
            this.error = true;
        });

        return request;
    },

    delete(id) {
        let request = axios.delete(api+'resource/'+id).then((response) => {
            return response;
        }).catch((error) => {
            console.log(error);
        });

        return request;
    }
}