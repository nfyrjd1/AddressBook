import Vue from 'vue';
import Router from 'vue-router';
import ContactList from '../components/contact/ContactList';
import ContactCard from '../components/contact/ContactCard';
import Error404 from '../components/error/Error404';

Vue.use(Router);

export default new Router({
    base: 'addressbookv3',
    routes: [
        {
            path: '',
            redirect: '/contacts'
        },
        {
            name: 'contacts',
            path: '/contacts',
            component: ContactList
        },
        {
            name: 'contact',
            path: '/contacts/:id',
            component: ContactCard
        },
        {
            name: '404',
            path: '/404',
            component: Error404
        },
        {
            path: '*',
            component: Error404
        }
    ],
    mode: 'history'
});