import { request, params } from './index'

const auth = {
  me(data) {
    return request(`me`, data)
  },

  preregister(data) {
    return request(`preregister`, data)
  },

  login(data) {
    return request(`game/${params().gameHash}/player/${params().playerHash}/login`, data)
  },

  register(data) {
    return request(`game/${params().gameHash}/player/${params().playerHash}/register`, data)
  },

  logout() {
    return request(`game/${params().gameHash}/player/${params().playerHash}/logout`, {}, 'GET')
  },

  activate() {
    return request(`activate/${params().hash}`, {}, 'GET')
  },

  hash() {
    return request(`hash/${params().hash}`, {}, 'GET')
  },

  password(data) {
    return request(`password/${params().hash}`, data)
  },

  recovery(data) {
    return request(`recovery`, data)
  },

  update(data) {
    return request(`update`, data)
  },
}

export default auth