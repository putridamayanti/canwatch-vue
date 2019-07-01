import axios from 'axios';
import api from './api';
export default {
    index() {
        let request = axios.get(api+'series').then((response) => {
            return response;
        }).catch(error => console.log(error));

        return request;
    },

    store(params) {
        let request = axios.post(api+'series', params).then((response) => {
            return response.data;
        }).catch((error) => {
            return error;
        });

        return request;
    },

    episodes(id) {
        let request = axios.get(api+'/series/episode/'+id).then((response) => {
            return response;
        }).catch(error => console.log(error));

        return request;
    },

    edit(id) {
        console.log(id);
        let request = axios.get(api+'series/'+id+'/edit').then((response) => {
            return response.data;
        }).catch((error) => {
            console.log(error);
        });

        return request;
    },

    update(id, params) {
        let request = axios.patch(api+'series/'+id, params).then((response) => {
            return response.data;
        }).catch((error) => {
            console.log(error);
            this.error = true;
        });

        return request;
    },

    delete(id) {
        let request = axios.delete(api+'series/'+id).then((response) => {
            return response;
        }).catch((error) => {
            console.log(error);
        });

        return request;
    }
}