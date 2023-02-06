import Vue from 'vue'
import Vuex from 'vuex'
import alerts from './alerts'
import auth from './auth'
import categories from './categories'
import langs from './langs'
import locales from './locales'
import words from './words'
import users from './users'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    alerts,
    auth,
    categories,
    langs,
    locales,
    words,
    users,
  }
})

export default store
