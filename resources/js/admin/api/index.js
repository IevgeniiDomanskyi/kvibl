import store from '../store'
import auth from './auth'
import categories from './categories'
import langs from './langs'
import locales from './locales'
import words from './words'
import users from './users'

const API_URL = '/admin/v1/'

const responseHandler = (response) => {
  const promise = response.json()
  const { ok } = response

  if (response.status === 401) {
    //store.commit('loggedOut')
    return false
  }

  promise.then((resp) => {
    if (resp.messages && resp.messages.length) {
      for (const message of resp.messages) {
        store.commit('alerts/alertSet', message)
      }
    }
  })

  return promise.then(response => response.data)
}

const errorHandler = (reason) => {
  console.error('Error Handler', reason)
}

export const request = (uri, data = {}, method = 'POST', withAbort = false) => {
  const controller = new AbortController();
  const { signal } = controller;

  const params = {
    method,
    headers: {
      Accept: 'application/json',
      'Content-Type': 'application/json',
    },
    signal,
  }

  if (method !== 'GET') {
    params.body = JSON.stringify(data)
  }

  const { token } = store.state.auth
  if (token) {
    params.headers.Authorization = `Bearer ${token}`
  }

  let url = API_URL + uri

  if ((uri.indexOf('@') + 1) !== 0) {
    url = uri.replace('@','')
  }

  const promise = fetch(url, params)
    .then(responseHandler, errorHandler)
    .catch(errorHandler)

  return withAbort ? [promise, controller.abort.bind(controller)] : promise
}

export default {
  auth,
  categories,
  langs,
  locales,
  words,
  users,
}
