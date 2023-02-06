import { request, params } from './index'

const players = {
  get(gameHash) {
    gameHash = gameHash || params().gameHash
    return request(`game/${gameHash}/player`, {}, 'GET')
  },

  tab(data) {
    return request(`game/${params().gameHash}/player/${params().playerHash}/tab`, data, 'POST')
  },

  profile(data) {
    return request(`game/${params().gameHash}/player/${params().playerHash}/update`, data, 'POST')
  },

  online(data) {
    return request(`game/${params().gameHash}/player/${params().playerHash}/online`, data, 'POST')
  },

  leave() {
    return request(`game/${params().gameHash}/player/${params().playerHash}/leave`, {}, 'DELETE')
  },

  remove(data) {
    return request(`game/${params().gameHash}/player/${params().playerHash}/remove/${data}`, {}, 'DELETE')
  },

  add(data) {
    return request(`game/${params().gameHash}/player/${params().playerHash}/add/${data.hash}`, data, 'POST')
  },

  prepare() {
    return request(`game/${params().gameHash}/player/${params().playerHash}/prepare`, {}, 'POST')
  },

  finish() {
    return request(`game/${params().gameHash}/player/${params().playerHash}/finish`, {}, 'GET')
  },

  confirm() {
    return request(`game/${params().gameHash}/player/${params().playerHash}/confirm`, {}, 'GET')
  },

  awards() {
    return request(`game/${params().gameHash}/player/${params().playerHash}/awards`, {}, 'GET')
  },

  push() {
    return request(`game/${params().gameHash}/player/${params().playerHash}/push`, {}, 'GET')
  },
}

export default players