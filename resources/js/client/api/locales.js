import { request } from './index'

const locales = {
  get() {
    return request('locale', {}, 'GET')
  },

  update(data) {
    return request(`locale/${data}`)
  },

  text(data) {
    return request('text' + (data ? ('/' + data) : ''), {}, 'GET')
  },
}

export default locales