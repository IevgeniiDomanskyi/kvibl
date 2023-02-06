import { request } from './index'

const app = {
  version() {
    return request(`version`, {}, 'GET')
  },
}

export default app