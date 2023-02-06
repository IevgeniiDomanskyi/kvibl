import api from '../api'
import { setTexts, setLocale } from '../plugins/i18n'

const locales = {
  namespaced: true,

  state: {
    current: 'en',
    list: [],
    text: {},
  },

  getters: {
    byCode: state => (code) => {
      for (const locale of state.list) {
        if (locale.code == code) {
          return locale
        }
      }

      return {}
    }
  },

  mutations: {
    currentSet(state, payload) {
      state.current = payload
    },

    localesSet(state, payload) {
      state.list = payload
    },

    textSet(state, payload) {
      state.text = { ...state.text, ...payload }
    },
  },

  actions: {
    get({ commit }) {
      return api.locales.get().then(data => {
        if (data) {
          commit('localesSet', data)
        }

        return data
      })
    },

    update({ dispatch }, payload) {
      dispatch('set', payload.code)

      if (payload.user) {
        return api.locales.update(payload.code).then(data => {
          return data
        })
      }
    },

    set({ commit }, payload) {
      commit('currentSet', payload)
      setLocale(payload)
    },

    text({ state, commit }, payload) {
      // Check if texts for current locale already loaded
      if ( ! state.text[payload]) {

        // Get texts for current locale
        return api.locales.text(payload).then(data => {
          if (data) {
            const locale = Object.keys(data)[0]

            let texts = {}
            texts[locale] = data[locale]
            commit('textSet', texts)

            setTexts(locale, data[locale])
          }

          return data
        })
      }

      // Return texts for current locale as a Promise
      return new Promise((resolve, reject) => {
        resolve(state.text)
      })
    },
  }
}

export default locales