import Vue from 'vue'
import VueRouter from 'vue-router'
import pages from '../pages'

Vue.use(VueRouter)

const routes = [
  {
    name: 'home',
    path: '/',
    component: pages.Home,
  }, {
    name: 'connect',
    path: '/connect',
    component: pages.Connect,
  }, {
    name: 'activate',
    path: '/activate/:hash',
    component: pages.Activate,
  }, {
    name: 'password',
    path: '/password/:hash',
    component: pages.Password,
  }, {
    name: 'game',
    path: '/:gameHash/:playerHash',
    component: pages.Game,
  },
];

const router = new VueRouter({
    mode: 'history',
    routes,
})

export default router