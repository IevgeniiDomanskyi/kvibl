import Vue from 'vue'
import VueCookie from 'vue-cookie'
import api from '../api'

const auth = {
  namespaced: true,

  state: {
    token: VueCookie.get('token') || null,
    cookies: VueCookie.get('cookies') || null,
    me: {},
    permissions: {
      app: {
        camera: false,
      },

      browser: {
        camera: false,
      },
    },
  },

  getters: {
    permissionApp(state) {
      return (type) => {
        return state.permissions.app[type]
      }
    },

    permissionBrowser(state) {
      return (type) => {
        return state.permissions.browser[type]
      }
    },
  },

  mutations: {
    tokenSet(state, payload) {
      state.token = payload
      if (payload) {
        Vue.cookie.set('token', payload, { expires: '1Y' })
      } else {
        Vue.cookie.delete('token')
      }
    },

    cookiesSet(state, payload) {
      state.cookies = payload
      if (payload) {
        Vue.cookie.set('cookies', payload * 1, { expires: '1Y' })
      } else {
        Vue.cookie.delete('cookies')
      }
    },

    meSet(state, payload) {
      state.me = payload
    },

    permissionAppSet(state, payload) {
      state.permissions.app[payload.type] = payload.permission
    },

    permissionBrowserSet(state, payload) {
      state.permissions.browser[payload.type] = payload.permission
    },

    meUpdate(state, payload) {
      state.me = { ...state.me, ...payload }
    },
  },

  actions: {
    me({ commit }, payload) {
      return api.auth.me(payload).then(data => {
        if (data) {
          commit('meSet', data)

          if (data.token) {
            commit('tokenSet', data.token)
          }
        }

        return data
      })
    },

    preregister({ commit }, payload) {
      return api.auth.preregister(payload).then(data => {
        if (data) {
          commit('meSet', data)

          if (data.token) {
            commit('tokenSet', data.token)
          }
        }

        return data
      })
    },

    login({ commit }, payload) {
      return api.auth.login(payload).then(data => {
        if (data) {
          commit('meSet', data)

          if (data.token) {
            commit('tokenSet', data.token)
          }
        }

        return data
      })
    },

    register({ commit }, payload) {
      return api.auth.register(payload).then(data => {
        if (data) {
          commit('meSet', data)

          if (data.token) {
            commit('tokenSet', data.token)
          }
        }

        return data
      })
    },

    activate() {
      return api.auth.activate().then(data => {
        return data
      })
    },

    recovery({ commit }, payload) {
      return api.auth.recovery(payload).then(data => {
        return data
      })
    },

    hash() {
      return api.auth.hash().then(data => {
        return data
      })
    },

    password({ commit }, payload) {
      return api.auth.password(payload).then(data => {
        if (data) {
          commit('meSet', data)

          if (data.token) {
            commit('tokenSet', data.token)
          }
        }

        return data
      })
    },

    update({ commit }, payload) {
      return api.auth.update(payload).then(data => {
        if (data) {
          commit('meSet', data)
        }

        return data
      })
    },

    logout({ commit }) {
      return api.auth.logout().then(data => {
        if (data) {
          commit('meSet', data)

          if (data.token) {
            commit('tokenSet', data.token)
          }
        }

        return data
      })
    },
  },
}

export default auth