import store from '../store'
import router from '../routes'
import app from './app'
import auth from './auth'
import locales from './locales'
import game from './game'
import players from './players'
import teams from './teams'
import upload from './upload'
import words from './words'
import viruses from './viruses'
import actions from './actions'

const API_URL = '/api/v1/'

const responseHandler = (response) => {
  const promise = response.json()
  const { ok } = response

  if (response.status === 401) {
    store.dispatch('auth/logout')
    return false
  }
  
  promise.then((resp) => {
    if (resp.message && resp.message == 'class_parents(): object or string expected') {
      // TO-DO (hot fix for Sanctum bug)
      store.dispatch('auth/logout')
      return false
    }
    
    // Reload website if version is not match
    if (resp.version) {
      if (resp.version != store.state.app.version) {
        window.location.reload()
      }
    }

    if (resp.messages && resp.messages.length) {
      for (const message of resp.messages) {
        store.commit('messages/set', message)
      }
    }
  })

  return promise.then(response => response.data)
}

const errorHandler = (reason) => {
  store.commit('messages/set', reason)
}

export const params = () => {
  return router.history.current.params
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

  const promise = fetch(`${API_URL}${uri}`, params)
    .then(responseHandler, errorHandler)
    .catch(errorHandler)

  return withAbort ? [promise, controller.abort.bind(controller)] : promise
}

export default {
  app,
  auth,
  locales,
  game,
  players,
  teams,
  upload,
  words,
  viruses,
  actions,
}
