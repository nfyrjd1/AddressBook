import { setContact, setContactImage } from '../api/api';

const addingContactTitle = 'Добавление нового контакта';
const editContactTitle = 'Редактирование контакта';

export default {
    state: {
        showModal: false,
        modalTitle: addingContactTitle,
        contact: null,
        postErrors: [],
    },
    mutations: {
        showAddingModal(state) {
            state.modalTitle = addingContactTitle;
            state.contact = null;
            state.showModal = true;
        },
        hideModal(state) {
            state.showModal = false;
            state.editContact = null;
        },
        showEditModal(state, contact) {
            state.modalTitle = editContactTitle;
            state.contact = contact;
            state.showModal = true;
        },
        setEditContact(state, contact) {
            state.contact = contact;
        },
        setErrors(state, errors) {
            state.postErrors = errors;
        },
        clearErrors(state) {
            state.postErrors = [];
        },
    },
    actions: {
        async postContact({ commit, state }, contact) {
            commit('setLoading', true);
            
            const response = await setContact(contact);
            if (!response || response.data) {
                commit('setErrors', response ? response.data.errors : ['Непредвиденная ошибка']);
            }  else {
                const contactId = response.contactId;
                commit('setEditContact', {...state.contact, id: contactId });
            }

            commit('setLoading', false);
        },
        async postContactImage({ commit }, formData) {
            commit('setLoading', true);

            const response = await setContactImage(formData);
            if (!response || response.data) {
                commit('setErrors', response ? response.data.errors : ['Непредвиденная ошибка']);
            } 

            commit('setLoading', false);
        }
    }
}