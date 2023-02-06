/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue'
import VueCookie from 'vue-cookie'
import App from './App.vue'
import router from './routes'
import store from './store'
import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/ua'
import VueFlags  from '@growthbunker/vueflags'
import 'element-ui/lib/theme-chalk/index.css';
import 'element-ui/lib/theme-chalk/display.css';
import 'propdoc/style.scss';

Vue.use(ElementUI, { locale })
Vue.use(VueCookie)
Vue.use(VueFlags, {
  iconPath: '/images/flags/',
})

const app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App),
});
