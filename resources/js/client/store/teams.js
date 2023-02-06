import api from '../api'

const teams = {
  namespaced: true,

  state: {
    showTeams: false,
    list: [],
    isLoaded: false,
  },

  getters: {
    byId(state) {
      return (id) => {
        for (const team of state.list) {
          if (team.team_id == id) {
            return team
          }
        }

        return {}
      }
    },
  },

  mutations: {
    loadedSet(state, payload) {
      state.isLoaded = payload
    },

    teamsSet(state, payload) {
      state.list = payload
    },

    showTeamsSet(state, payload) {
      state.showTeams = payload
    },
  },

  actions: {
    get({ commit }, payload) {
      return api.teams.get(payload).then(data => {
        if (data) {
          commit('teamsSet', data)
        }
        
        commit('loadedSet', true)
        return data
      })
    },

    reset({ commit }) {
      commit('loadedSet', false)
      commit('teamsSet', [])
    },
  },
}

export default teams