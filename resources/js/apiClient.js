import axios from 'axios';
//this service is use for send api request to endpoint with Bearer token
const ApiService = {
    init() {
        axios.defaults.baseURL = "http://task-manager.test/api/";
        axios.defaults.headers.common["Authorization"] = `Bearer ${localStorage.getItem('token')}`;
    },

    get(resource, params) {
        return axios.get(`${resource}`, params);
    },

    post(resource, params) {
        return axios.post(`${resource}`, params);
    },

    update(resource, params) {
        return axios.put(`${resource}`, params);
    },

    delete(resource) {
        return axios.delete(resource);
    },
};

export default ApiService;
