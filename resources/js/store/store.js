import {defineStore} from "pinia";

export const useStore = defineStore('storeId', {
    // arrow function recommended for full type inference
    state: () => {
        return {
            // all these properties will have their type inferred automatically
            token:  localStorage.getItem('token') || null,
            user: localStorage.getItem('user') || {},
        }
    },
    getters: {
        getToken: (state) => state.token,
        getUser: (state) => state.user
    },
    actions: {
        setToken(payload) {
            this.token = payload;
            localStorage.setItem('token', payload);
        },
        setUser(payload) {
            this.user = payload;
            localStorage.setItem('user', payload);
        },
        logout() {
            this.user = {};
            this.token = null;
            localStorage.removeItem('token');
            localStorage.removeItem('user');
        }
    }
})

export default useStore;
