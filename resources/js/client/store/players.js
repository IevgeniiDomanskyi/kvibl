import api from '../api'

const players = {
  namespaced: true,

  state: {
    list: [],
    me: {},
    modals: {},
    name: '',
    isLoaded: false,
  },

  getters: {
    byId(state) {
      return (id) => {
        for (const player of state.list) {
          if (player.player_id == id) {
            return player
          }
        }

        return {}
      }
    },

    teamPlayers(state) {
      return (team_id) => {
        let players = []
        for (const player of state.list) {
          if (player.team_id == team_id) {
            players.push(player)
          }
        }

        return players
      }
    },
  },

  mutations: {
    loadedSet(state, payload) {
      state.isLoaded = payload
    },

    playersSet(state, payload) {
      state.list = payload
    },

    meSet(state, payload) {
      state.me = payload
    },

    modalSet(state, payload) {
      state.modals[payload] = true
    },

    nameSet(state, payload) {
      state.name = payload
    },
  },

  actions: {
    get({ commit, dispatch }, payload) {
      return api.players.get(payload).then(data => {
        if (data) {
          commit('playersSet', data)
          dispatch('me', data)
        }

        commit('loadedSet', true)
        return data
      })
    },

    me({ rootState, commit }, players) {
      if (rootState.auth.me.id && players && players.length) {

        for (let player of players) {
          if (player.user_id == rootState.auth.me.id) {
            return commit('meSet', player)
          }
        }
      }
      
      commit('meSet', {})
    },

    profile({ commit }, payload) {
      return api.players.profile(payload).then(data => {
        if (data) {
          commit('meSet', data)
        }

        return data
      })
    },

    online({ state }, payload) {
      if (state.me.player_id) {
        return api.players.online({ online: payload })
      }
    },

    leave({ dispatch }) {
      return api.players.leave().then(data => {
        return data
      })
    },

    remove({ }, payload) {
      return api.players.remove(payload).then(data => {
        return data
      })
    },

    add({ }, payload) {
      return api.players.add(payload).then(data => {
        return data
      })
    },

    prepare({ }) {
      return api.players.prepare()
    },

    finish({ }) {
      return api.players.finish()
    },

    confirm({ }) {
      return api.players.confirm()
    },

    awards({ }) {
      return api.players.awards()
    },

    push({ }) {
      return api.players.push()
    },

    reset({ commit }) {
      commit('loadedSet', false)
      commit('playersSet', [])
      commit('meSet', {})
      commit('nameSet', '')
    },
  },
}

export default players