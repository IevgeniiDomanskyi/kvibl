import Vue from 'vue'
import VueCookie from 'vue-cookie'
import ElementUI from 'element-ui'
import Vue2TouchEvents from 'vue2-touch-events'
import { i18n } from './plugins/i18n'
import Audio from './plugins/audio'
import Helpers from './plugins/helpers'
import KviblApp from './plugins/kvibl-app'
import store from './store'
import router from './routes'
import App from './App.vue'

Vue.config.productionTip = false

Vue.use(VueCookie)
Vue.use(ElementUI)
Vue.use(Vue2TouchEvents)
Vue.use(Audio, { store })
Vue.use(Helpers)
Vue.use(KviblApp)

new Vue({
  el: '#app',
  router,
  store,
  i18n,
  render: h => h(App),
})
