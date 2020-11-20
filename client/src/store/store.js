import Vue from 'vue';
import Vuex from 'vuex';
import modal from './modal';
import contact from './contact';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        isLoading: false
    },
    mutations: {
        setLoading (state, isLoading = !state.isLoading) {
            state.isLoading = isLoading;
        }
    },
    modules: {
        modal,
        contact
    }
});