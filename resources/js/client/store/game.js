import api from '../api'

const game = {
  namespaced: true,

  state: {
    time: null,
    data: {},
    isLoaded: false,
  },

  getters: {
    currentTeam(state, getters, rootState, rootGetters) {
      return rootGetters['teams/byId'](state.data.current_team_id)
    },

    currentPlayer(state, getters, rootState, rootGetters) {
      return rootGetters['players/byId'](state.data.current_player_id)
    },
  },

  mutations: {
    loadedSet(state, payload) {
      state.isLoaded = payload
    },

    gameSet(state, payload) {
      state.data = payload
      state.time = new Date()
    },
  },

  actions: {
    get({ commit }, payload) {
      return api.game.get(payload).then(data => {
        if (data) {
          commit('gameSet', data)
        }

        commit('loadedSet', true)
        return data
      })
    },

    last({ commit }) {
      return api.game.last().then(data => {
        if (data.id) {
          commit('gameSet', data)
        }

        return data
      })
    },

    create({ commit }) {
      return api.game.create().then(data => {
        if (data) {
          commit('gameSet', data)
        }

        return data
      })
    },

    connect({ commit }, payload) {
      return api.game.connect(payload).then(data => {
        if (data) {
          commit('gameSet', data)
        }

        return data
      })
    },

    start({ commit }, payload) {
      return api.game.start(payload).then(data => {
        if (data) {
          commit('gameSet', data)
        }
      })
    },

    reset({ commit }) {
      commit('loadedSet', false)
      commit('gameSet', {})
    },
  },
}

export default game