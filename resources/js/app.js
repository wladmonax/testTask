require('./bootstrap');
import VModal from 'vue-js-modal'
import Vue from 'vue';
import VeeValidate from 'vee-validate';


import VueGoodTablePlugin from 'vue-good-table';

// import the styles
import 'vue-good-table/dist/vue-good-table.css'


window.Vue = require('vue');
Vue.component('home', require('./components/Home.vue').default);
Vue.component('create',require('./components/Modals/Notification.vue').default);

Vue.use(VueGoodTablePlugin);
Vue.use(VModal,{ dialog: true })
Vue.use(VeeValidate);

const app = new Vue({
    el:'#app'
})
