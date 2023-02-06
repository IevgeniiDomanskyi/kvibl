import api from '../api'

const users = {
  namespaced: true,

  state: {
    users: [],
  },

  mutations: {
    setUsers(state, payload) {
      state.users = payload
    },
  },

  actions: {
    all({ commit }, payload) {
      return api.users.all(payload).then(response => {
        commit('setUsers', response)
      })
    },

    add({ commit }, payload) {
      return api.users.add(payload).then(response => {
        commit('setUsers', response)
      })
    },

    update({ commit }, payload) {
      return api.users.update(payload).then(response => {
        commit('setUsers', response)
      })
    },

    delete({ commit }, payload) {
      return api.users.delete(payload).then(response => {
        commit('setUsers', response)
      })
    },
  },
}

export default users
