import { request } from './index'

const auth = {
  makeCsrf() {
    return request('@/sanctum/csrf-cookie', {}, 'GET')
  },

  me() {
    return request('me', {}, 'GET')
  },

  login(data) {
    return request('login', data)
  },

  logout() {
    return request('logout', {})
  },
}

export default auth