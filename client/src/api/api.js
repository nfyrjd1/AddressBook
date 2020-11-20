import Axios from 'axios';

const api = Axios.create({
    baseURL: 'http://localhost/addressbook/api/'
});

export const getContacts = async (page = 1, pageSize = 10, search = null) => {
    try {
        const response = await api.get(`contacts?page=${page}&size=${pageSize}` + (search ? `&search=${search}` : ''));
        return response.data;
    } catch (error) {
        return error.response;
    }
}

export const getContact = async (id) => {
    try {
        const response = await api.get(`contacts/${id}`);
        return response.data;
    } catch (error) {
        return error.response;
    }
}

export const setContact = async (contact) => {
    try {
        const response = await api.post(`contacts/`, contact);
        return response.data;
    } catch (error) {
        return error.response;
    }
}

export const setContactImage = async (formData) => {
    try {
        const response = await api.post(`contacts/image`, formData);
        return response.data;
    } catch (error) {
        return error.response;
    }
}