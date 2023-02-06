import { request } from './index'

const users = {
  all(payload) {
    return request('users', {}, 'GET')
  },

  add(payload) {
    return request('users/add', payload)
  },

  update(payload) {
    return request('users', payload, 'PUT')
  },

  delete(payload) {
    return request('users', payload, 'DELETE')
  },
}

export default users
