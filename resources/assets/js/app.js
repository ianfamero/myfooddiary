
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.moment = require('moment');
require('moment/locale/en-gb');

import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/en';
import 'element-ui/lib/theme-chalk/index.css';
import VueRouter from 'vue-router';
import router from './router';
import VueRecaptcha from 'vue-recaptcha';


Vue.use(ElementUI, { size: 'small', locale });
Vue.use(VueRouter);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('vue-recaptcha', VueRecaptcha);

Vue.component('user-login', require('./components/Login.vue'));
Vue.component('top-header', require('./components/common/Header.vue'));
Vue.component('login-header', require('./components/common/LoginHeader.vue'));
Vue.component('food-diary', require('./components/food-diary/Index.vue'));
Vue.component('food-list', require('./components/food-list/Index.vue'));
Vue.component('food-list-form-modal', require('./components/food-list/Form.vue'));
Vue.component('profile', require('./components/profile/Index.vue'));

const app = new Vue({
  el: '#app',
  router,
  methods: {
    showMessage: function(type, message) {
      this.$notify({
        title: type == 'success' ? 'Success' : 'Oops!',
        dangerouslyUseHTMLString: true,
        showClose: true,
        message: message,
        type: type,
        duration: 4000,
      });
    },
    destroyMessage: function (id, code, isMany, functionName, otherMessage) {
      let record = isMany == true ? ' records?' : ' record?';
      let message = 'Are you sure you want to delete <strong style="color:#c83a2a">' + code + '</strong>' + record;
      if (!_.isUndefined(otherMessage)) {
        message += '<br><br>' + otherMessage;
      }
      this.$confirm(message, 'Confirmation', {
        dangerouslyUseHTMLString: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        type: 'warning',
        closeOnClickModal: false,
      }) .then(() => {
        if (_.isUndefined(functionName)) {
          if (isMany) {
            this.$emit('destroySelected');
          }
          else {
            this.$emit('destroy', id);
          }
        } else {
          this.$emit(functionName, id);
        }
      }) .catch(() => {
        // do nothing
      });
    },
    moveTo: function (link) {
      router.push(link);
    },
    linkTo: function (link) {
      window.open(link, "_self");
    },
  }
});
