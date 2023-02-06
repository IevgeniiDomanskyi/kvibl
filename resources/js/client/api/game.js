import { request, params } from './index'

const game = {
  get() {
    return request(`game/${params().gameHash}`, {}, 'GET')
  },

  last() {
    return request(`game/last`, {}, 'GET')
  },

  create() {
    return request('game', {}, 'POST')
  },

  connect(data) {
    return request(`game/connect`, data, 'POST')
  },

  start(data) {
    return request(`game/${params().gameHash}/start`, data, 'POST')
  },
}

export default game