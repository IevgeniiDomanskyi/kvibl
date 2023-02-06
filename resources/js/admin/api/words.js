import { request } from './index'

const words = {  
  all(payload) {
    return request('words/' + payload, {}, 'GET')
  },
  
  add(payload) {
    return request('words/add', payload)
  },
  
  update(payload) {
    return request('words', payload, 'PUT')
  },
  
  delete(payload) {
    return request('words', payload, 'DELETE')
  },
  
  reset(payload) {
    return request('words/reset/' + payload, {})
  },
}

export default words