import { request, params } from './index'

const actions = {
  get() {
    return request(`action/${params().playerHash}`, {}, 'GET')
  },

  add(data) {
    return request(`action/${params().playerHash}`, data, 'POST')
  },
}

export default actions