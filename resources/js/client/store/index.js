import Vue from 'vue'
import Vuex from 'vuex'

import app from './app'
import tabs from './tabs'
import auth from './auth'
import locales from './locales'
import messages from './messages'
import game from './game'
import players from './players'
import teams from './teams'
import upload from './upload'
import words from './words'
import viruses from './viruses'
import actions from './actions'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    app,
    tabs,
    auth,
    locales,
    messages,
    game,
    players,
    teams,
    upload,
    words,
    viruses,
    actions,
  }
})

export default store