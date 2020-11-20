import { getContacts, getContact } from '../api/api';

export default {
    state: {
        contacts: [],
        search: null,
        totalContacts: 0,
        pageSize: 10,
        page: 1,
    },
    mutations: {
        setContacts(state, contacts = []) {
            state.contacts = contacts;
        },
        setTotalContacts(state, totalContacts) {
            state.totalContacts = totalContacts;
        },
        setPageSize(state, pageSize) {
            state.pageSize = pageSize;
        },
        setPage(state, page) {
            state.page = page;
        },
        setSearch(state, search = null) {
            state.search = search;
        }
    },
    getters: {
        pagesCount(state) {
            return Math.ceil(state.totalContacts / state.pageSize);
        }
    },
    actions: {
        async loadContacts({ commit, state }) {
            commit('setLoading', true);
            const response = await getContacts(state.page, state.pageSize, state.search);
            if (response && !response.data) {
                commit('setPage', response.pageNumber);
                commit('setPageSize', response.pageSize);
                commit('setTotalContacts', response.contactsCount);
                commit('setContacts', response.contacts.map(contact => {
                    contact.id = +contact.id;
                    return contact;
                }));
            }

            commit('setLoading', false);
        },
        setPage({ commit, dispatch }, page = 1) {
            commit('setPage', page);
            dispatch('loadContacts');
        },
        setSearch({ commit, dispatch }) {
            commit('setPage', 1);
            dispatch('loadContacts');
        },
        async loadContact({ commit }, id) {
            commit('setLoading', true);

            let contact = null;
            const response = await getContact(id);
            if (response && !response.data) {
                contact = {...response, id: +response.id};
            }
            
            commit('setLoading', false);
            return contact;
        },
        async updateContact({ commit, dispatch, state }, id) {
            const contact = await dispatch('loadContact', id);
            if (contact) {
                let updated = false;
                const contacts = state.contacts.map(item => {
                    if (item.id == id) {
                        updated = true;
                        return contact;
                    }
                    return item;
                });

                if (!updated) contacts.push(contact);

                commit('setContacts', contacts);

                if (contacts.length > state.pageSize) {
                    dispatch('loadContacts');
                }
            }
        }
    }
}