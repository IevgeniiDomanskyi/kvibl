import api from '../api'

const tabs = {
  namespaced: true,

  state: {
    current: 0,
    history: [],
  },

  getters: {
    last(state) {
      if (state.history.length) {
        return state.history[state.history.length - 1]
      }

      return 0
    },
  },
  
  mutations: {
    currentSet(state, payload) {
      state.current = payload
    },

    historyAdd(state, payload) {
      state.history = [ ...state.history, payload ]
    },

    historyUpdate(state, payload) {
      if (typeof payload == 'string') {
        payload = JSON.parse(payload)
      }

      state.history = payload
    },

    historyClear(state) {
      state.history = []
    },
  },

  actions: {
    set({ commit, dispatch }, payload) {
      commit('currentSet', payload)
      dispatch('history', payload)
      return api.players.tab({ tab: payload })
    },

    current({ commit, dispatch }, payload) {
      commit('currentSet', payload)
      dispatch('history', payload)
    },

    history({ commit, getters }, payload) {
      if (payload) {
        if (getters.last != payload) {
          commit('historyAdd', payload)
        }
      } else {
        commit('historyClear')
      }
    },

    back({ state, commit, getters }) {
      state.history.pop()
      const prev = getters.last || 0

      commit('currentSet', prev)
      commit('historyUpdate', state.history)
      return api.players.tab({ tab: prev })
    },
  },
}

export default tabs