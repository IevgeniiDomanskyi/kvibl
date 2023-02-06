import api from '../api'

const locales = {
  namespaced: true,

  state: {
    locales: [],
  },

  mutations: {    
    setLocales(state, payload) {
      state.locales = payload
    },
  },

  actions: {    
    all({ commit }) {        
      return api.locales.all().then(response => {
        commit('setLocales', response)
      })
    },
  },
}

export default locales