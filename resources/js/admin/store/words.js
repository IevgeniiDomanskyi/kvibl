import api from '../api'

const words = {
  namespaced: true,

  state: {
    words: [],
  },

  mutations: {    
    setWords(state, payload) {
      state.words = payload
    },
  },

  actions: {
    all({ commit }, payload) {
      return api.words.all(payload).then(response => {
        commit('setWords', response)
      })
    },
    
    add({ commit }, payload) {
      return api.words.add(payload).then(response => {
        commit('setWords', response)
      })
    },
    
    update({ commit }, payload) {
      return api.words.update(payload).then(response => {
        commit('setWords', response)
      })
    },
    
    delete({ commit }, payload) {
      return api.words.delete(payload).then(response => {
        commit('setWords', response)
      })
    },
    
    reset({ commit }, payload) {
      return api.words.reset(payload).then(response => {
        commit('setWords', response)
      })
    },
    
    clear({ commit }) {
      commit('setWords', [])
    },
  },
}

export default words