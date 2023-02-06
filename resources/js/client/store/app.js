import api from '../api'

const app = {
  namespaced: true,

  state: {
    version: '0.0.0',
    url: 'https://kvibl.com',
    connection: {
      sockets: 1, // 1 - connected; 2 - pending (try to reconnect); 0 - sockets were lost (need refresh the app)
      network: 1, // 1 - online, 0 - offline
    },
    help: false,
    mute: false,
  },

  mutations: {
    versionSet(state, payload) {
      state.version = payload
    },

    socketsSet(state, payload) {
      state.connection.sockets = payload
    },

    networkSet(state, payload) {
      state.connection.network = payload
    },

    helpSet(state, payload) {
      state.help = payload
    },

    muteSet(state, payload) {
      state.mute = payload
    },
  },

  actions: {
    version({ commit }) {
      return api.app.version().then(data => {
        commit('versionSet', data)
      })
    },

    sockets({ commit }, payload) {
      // Sockets connected and working well
      if (payload.type == 'connected') {
        commit('socketsSet', 1)
      }

      // Sockets disconnected or try reconnected less then 4 times
      if (payload.type == 'disconnected' || (payload.type == 'reconnected' && payload.attempts <= 3)) {
        commit('socketsSet', 2)
      }

      // Sockets were lost after 3 times reconnection
      // To-Do
      // Need to inform administrators
      if (payload.type == 'reconnected' && payload.attempts > 3) {
        commit('socketsSet', 0)
      }
    },

    network({ commit }, payload) {
      commit('networkSet', payload)
    },
  },
}

export default app