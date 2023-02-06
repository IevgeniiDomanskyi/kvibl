import { request, params } from './index'

const upload = {
  image(data) {
    return request(`upload_image`, data)
  },
}

export default upload