import Vue from 'vue';
import { Plugin } from 'vue-fragment';
import Vuelidate from 'vuelidate';
import App from './App.vue';
import store from './store/store';
import router from './router/router';

Vue.config.productionTip = false;
Vue.use(Plugin);
Vue.use(Vuelidate);

new Vue({
  store,
  router,
  render: h => h(App)
}).$mount('#app');