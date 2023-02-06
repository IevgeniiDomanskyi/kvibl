import api from '../api'

const upload = {
  namespaced: true,

  actions: {
    image({ }, payload) {
      return api.upload.image({ base64: payload }).then(data => {
        return data
      })
    },
  },
}

export default upload