const messages = {
  namespaced: true,

  state: {
    list: [],
  },

  mutations: {
    set(state, payload) {
      state.list.push(payload)
    },

    clear(state) {
      state.list = []
    },
  },
}

export default messages