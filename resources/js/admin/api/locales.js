import { request } from './index'

const locales = {
  all() {
    return request('locale', {}, 'GET')
  },
}

export default locales