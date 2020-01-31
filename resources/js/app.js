require('./bootstrap');

window.Vue = require('vue');
window.Eventbus = new Vue();

Vue.prototype.$http = window.axios;

Vue.component('search', require('./components/Search.vue').default);

const app = new Vue({
    el: '#app'
});
