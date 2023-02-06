import api from '../api'

const langs = {
  namespaced: true,

  state: {
    langs: [],
  },

  mutations: {    
    setLangs(state, payload) {
      state.langs = payload
    },
  },

  actions: {    
    all({ commit }) {        
      return api.langs.all().then(response => {
        commit('setLangs', response)
      })
    },
  },
}

export default langs