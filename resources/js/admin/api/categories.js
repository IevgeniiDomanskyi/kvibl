import { request } from './index'

const categories = {
  import(payload) {
    return request('category/import', payload)
  },
  
  all() {
    return request('category', {}, 'GET')
  },
  
  get(id) {
    return request(`category/${id}`, {}, 'GET')
  },
  
  add(payload) {
    return request('category/add', payload)
  },
  
  delete(payload) {
    return request('category', payload, 'DELETE')
  },
}

export default categories