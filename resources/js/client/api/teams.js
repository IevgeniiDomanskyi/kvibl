import { request, params } from './index'

const teams = {
  get() {
    return request(`game/${params().gameHash}/team`, {}, 'GET')
  },
}

export default teams