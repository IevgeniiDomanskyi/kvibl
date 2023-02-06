import api from '../api'

const words = {
  namespaced: true,

  state: {
    list: [],
  },

  mutations: {
    wordsSet(state, payload) {
      state.list = payload
    },

    currentSet(state, payload) {
      for (const key in state.list) {
        if (state.list[key].id == payload.id) {
          state.list[key].is_current = true
        } else {
          state.list[key].is_current = false
        }
      }
    },

    wordSet(state, payload) {
      for (const key in state.list) {
        if (state.list[key].id == payload.id) {
          state.list[key] = payload
        }
      }
    },
  },

  actions: {
    get({ commit }, payload) {
      return api.words.get(payload).then(data => {
        if (data) {
          commit('wordsSet', data)
        }

        return data
      })
    },

    view({ }, payload) {
      return api.words.view(payload)
    },

    approve({ commit }, payload) {
      return api.words.approve(payload).then(data => {
        commit('wordSet', data)
      })
    },

    confirm({ commit }, payload) {
      return api.words.confirm(payload)
    },

    reset({ commit }) {
      commit('wordsSet', [])
    },
  },
}

export default words