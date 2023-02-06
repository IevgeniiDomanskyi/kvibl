import api from '../api'

const actions = {
  namespaced: true,

  state: {
    list: [],
    temp: [],
    isLoaded: false,
  },

  getters: {
    byCode(state) {
      return (code) => {
        for (const row of state.list) {
          if (row.action == code) {
            return true
          }
        }
        
        for (const item of state.temp) {
          if (item == code) {
            return true
          }
        }

        return false
      }
    },
  },

  mutations: {
    loadedSet(state, payload) {
      state.isLoaded = payload
    },

    actionsSet(state, payload) {
      state.list = payload
    },

    tempSet(state, payload) {
      state.temp = [...state.temp, payload]
    },

    tempClear(state) {
      state.temp = []
    },
  },

  actions: {
    get({ commit }) {
      return api.actions.get().then(data => {
        if (data) {
          commit('actionsSet', data)
        }

        commit('loadedSet', true)
        return data
      })
    },

    add({ commit }, payload) {
      commit('tempSet', payload)
      return api.actions.add({ action: payload }).then(data => {
        return data
      })
    },

    reset({ commit }) {
      commit('loadedSet', false)
      commit('actionsSet', [])
      commit('tempClear')
    },
  },
}

export default actions