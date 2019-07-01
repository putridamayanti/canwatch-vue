import axios from 'axios';
import api from './api';
export default {
    index() {
        let request = axios.get(api+'category').then((response) => {
            return response;
        }).catch(error => console.log(error));

        return request;
    },

    store(params) {
        let request = axios.post(api+'category', params).then((response) => {
            return response;
        }).catch((error) => {
            console.log(error);
            this.error = true;
        });

        return request;
    },

    edit(id) {
        console.log(id);
        let request = axios.get(api+'category/'+id+'/edit').then((response) => {
            return response.data;
        }).catch((error) => {
            console.log(error);
        });

        return request;
    },

    update(id, params) {
        let request = axios.patch(api+'category/'+id, params).then((response) => {
            console.log(response);
            return response;
        }).catch((error) => {
            console.log(error);
            this.error = true;
        });

        return request;
    },

    delete(id) {
        let request = axios.delete(api+'category/'+id).then((response) => {
            return response;
        }).catch((error) => {
            console.log(error);
        });

        return request;
    }
}