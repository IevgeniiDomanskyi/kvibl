import Vue from 'vue'
import VueCookie from 'vue-cookie'
import api from '../api'
import router from '../routes'

const auth = {
  namespaced: true,

  state: {
    isLoaderShow: true,
    token: VueCookie.get('admin-token') || null,
    me: {},
  },

  mutations: {
    loaderShowSet(state) {
      state.isLoaderShow = false
    },

    meSet(state, payload) {
      state.me = payload
    },

    tokenSet(state, payload) {      
      state.token = payload
      Vue.cookie.set('admin-token', payload, { expires: '1Y' })
    },

    logout(state) { 
      Vue.cookie.delete('admin-token')  
      state.token = null
      state.me = null   
      
      if (router.history.current.path != '/admin') {
        router.push('/admin')
      }
    },
    
    showDocs(state) {
      state.isLoaderShow = false
    },
  },

  actions: {    
    me({ commit }) {
      return api.auth.me().then(response => {
        commit('loaderShowSet')        
        commit('meSet', response)
        
        if (response.token) {
          commit('tokenSet', response.token)
        }
      })
    },

    login({ commit }, payload) {
      return api.auth.login(payload).then(response => {
        commit('meSet', response)
        
        if (response.token) {
          commit('tokenSet', response.token)
        }
      })
    },
    
    logout({ commit }) {
      return api.auth.logout().then(response => {        
        commit('logout')
      })
    },
  },
}

export default auth