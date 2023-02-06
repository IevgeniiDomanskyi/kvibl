import { request, params } from './index'

const words = {
  get() {
    return request(`game/${params().gameHash}/player/${params().playerHash}/word`, {}, 'GET')
  },

  view(word_id) {
    return request(`game/${params().gameHash}/player/${params().playerHash}/word/${word_id}/view`, {}, 'GET')
  },

  approve(word_id) {
    return request(`game/${params().gameHash}/player/${params().playerHash}/word/${word_id}/approve`, {}, 'GET')
  },

  confirm(data) {
    const value = data.value * 1
    return request(`game/${params().gameHash}/player/${params().playerHash}/word/${data.word.id}/confirm/${value}`, {}, 'GET')
  },
}

export default words