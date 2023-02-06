import { request } from './index'

const langs = {
  all() {
    return request('langs', {}, 'GET')
  },
}

export default langs