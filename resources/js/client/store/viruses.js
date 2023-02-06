import api from '../api'

const viruses = {
  namespaced: true,

  state: {
    list: [],
    selected: {},
  },

  mutations: {
    virusesSet(state, payload) {
      state.list = payload
    },

    selectedSet(state, payload) {
      state.selected = payload
    },
  },

  actions: {
    get({ commit }) {
      return api.viruses.get().then(data => {
        if (data) {
          commit('virusesSet', data)
        }

        return data
      })
    },

    random({ }, payload) {
      return api.viruses.random(payload).then(data => {
        return data
      })
    },

    apply({  }, payload) {
      return api.viruses.apply(payload).then(data => {
        return data
      })
    },

    reset({ commit }) {
      commit('virusesSet', [])
      commit('selectedSet', {})
    },
  },
}

export default viruses