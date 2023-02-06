import api from '../api'

const categories = {
  namespaced: true,

  state: {
    categories: [],
    category: [],
  },

  mutations: {    
    setCategories(state, payload) {
      state.categories = payload
    },
    
    setCategory(state, payload) {
      state.category = payload
    },
  },

  actions: {    
    import({ commit }, payload) {
      return api.categories.import(payload).then(response => {
        commit('setCategories', response)
      })
    },
    
    all({ commit }) {        
      return api.categories.all().then(response => {
        commit('setCategories', response)
      })
    },
    
    get({ commit }, payload) {        
      return api.categories.get(payload).then(response => {
        commit('setCategory', response)
      })
    },
    
    add({ commit }, payload) {        
      return api.categories.add(payload).then(response => {
        commit('setCategories', response)
      })
    },
    
    delete({ commit }, payload) {        
      return api.categories.delete(payload).then(response => {
        commit('setCategories', response)
      })
    },
  },
}

export default categories