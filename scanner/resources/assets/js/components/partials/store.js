import Vue from 'vue';
import Vuex from 'vuex';


Vue.use(Vuex);


export default new Vuex.Store({
    state: {
        user : ''
    },
    mutations: {
        loginUser(state, payload) { 
            state.user = payload;
        }
    },
    getters: {
        getLoginUserDetail(state) {
            return state.user;
        }
    },
    
});