
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import VueRouter from 'vue-router';
import router from './router';


Vue.use(ElementUI);
Vue.use(VueRouter);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('user-login', require('./components/Login.vue'));
Vue.component('top-header', require('./components/common/Header.vue'));
Vue.component('food-diary', require('./components/food-diary/Index.vue'));
Vue.component('food-list', require('./components/food-list/Index.vue'));
Vue.component('profile', require('./components/profile/Index.vue'));

const app = new Vue({
  el: '#app',
  router,
  methods: {
    moveTo: function (link) {
      router.push(link);
    },
  }
});
