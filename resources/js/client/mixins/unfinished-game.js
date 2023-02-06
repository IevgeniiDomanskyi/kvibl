import { mapState, mapActions } from "vuex"

const UnfinishedGame = {
  data: () => ({
    m_isUnfinishedGameChecked: false,
  }),

  computed: {
    ...mapState({
      token: state => state.auth.token,
      me: state => state.players.me,
    }),
  },

  methods: {
    ...mapActions([
      'game/last',
      'players/get',
    ]),

    m_getUnfinishedGame() {
      // If user is authorized then check if he has unfinished game
      if ( !! this.token) {
        this['game/last']().then(game => {
          // If user has unfinished game
          if (game.hash) {
            // then redirect to game url
            this.m_redirectToGame(game.hash)
          } else {
            this.m_isUnfinishedGameChecked = true
          }
        })
      } else {
        this.m_isUnfinishedGameChecked = true
      }
    },

    m_redirectToGame(gameHash) {
      // Need to get hash of current player which is need in game url
      // So get all players of the game
      this['players/get'](gameHash).then(players => {
        if (players.length) {
          // In players/get action was dispached me() action
          // me() action selected from all players current player
          // So this.me contains info about current player of the last unfinished game
          if (this.me.hash) {
            const path = `/${gameHash}/${this.me.hash}`

            // Checking if we are not on game url already (vue-router can fire warning)
            if (this.$router.history.current.path != path) {
              // Redirecting to game url using replace method
              // In this case if user click on back button in browser he didn't came to Home or Connect page
              this.$router.replace(path)
            }
          } else {
            // To-Do
            // If you are not in the game need to show something
            console.log('*** Redirect to Unfinished game', 'I\'m not in the last game')
          }
        } else {
          // To-Do
          // If there are no players at the game need to show something
          console.log('*** Redirect to Unfinished game', 'No players at the game')
        }
      })
    },
  }
}

export default UnfinishedGame