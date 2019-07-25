import VueRouter from 'vue-router';

let routes = [
  {
    path: '/',
    component: require('./components/Login'),
  },
  {
    path: '/food-diary',
    component: require('./components/food-diary/Index.vue'),
  },
  {
    path: '/food-list',
    component: require('./components/food-list/Index.vue'),
  },
  {
    path: '/profile',
    component: require('./components/profile/Index.vue'),
  },
  {
    path: '/report',
    component: require('./components/report/Index.vue'),
  },
];

export default new VueRouter({
  routes,
  linkActiveClass: 'active',
  mode: 'history',
})
