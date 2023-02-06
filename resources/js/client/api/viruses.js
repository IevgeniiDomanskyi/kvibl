import { request, params } from './index'

const viruses = {
  get() {
    return request(`virus`, {}, 'GET')
  },

  random(data) {
    return request(`game/${params().gameHash}/player/${params().playerHash}/virus/random/${data}`, {}, 'GET')
  },

  apply(data) {
    return request(`game/${params().gameHash}/player/${params().playerHash}/virus/${data.virus_id}/apply`, data, 'POST')
  },
}

export default viruses