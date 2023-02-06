import { mapState, mapGetters, mapActions, mapMutations } from 'vuex'

const Game = {
  computed: {
    ...mapState({
      token: state => state.auth.token,
      game: state => state.game.data,
      gameIsLoaded: state => state.game.isLoaded,
      status: state => state.game.status,
      me: state => state.players.me,
      players: state => state.players.list,
      playersIsLoaded: state => state.players.isLoaded,
      teams: state => state.teams.list,
      teamsIsLoaded: state => state.teams.isLoaded,
      actions: state => state.actions.list,
      actionsIsLoaded: state => state.actions.isLoaded,

      tab: state => state.tabs.current,
      user: state => state.auth.me,
    }),

    ...mapGetters([
      'actions/byCode',
      'game/currentPlayer',
      'game/currentTeam',
    ]),

    currentPlayer() {
      return this['game/currentPlayer']
    },

    currentTeam() {
      return this['game/currentTeam']
    },

    browserHasUserMedia() {
      return !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia)
    },
  },

  methods: {
    ...mapMutations([
      'viruses/selectedSet',
      'words/wordsSet',
      'auth/permissionBrowserSet',
      'app/helpSet',
    ]),

    ...mapActions([
      'players/get',
      'game/reset',
      'teams/reset',
      'players/reset',
      'words/reset',
      'actions/reset',
      'viruses/reset',
    ]),

    ucFirst(str) {
      return ( ! str) ? str : (str[0].toUpperCase() + str.slice(1))
    },

    range(end, start = 1) {
      let items = []
      for (let i = start; i <= end; i++) {
        items.push(i)
      }
      return items
    },

    isMeApproved(word) {
      for (const confirm of word.confirms) {
        if (confirm.player_id == this.me.player_id) {
          return confirm.is_approved == 1
        }
      }

      return false
    },

    isOwnerApproved(word) {
      for (const confirm of word.confirms) {
        if (confirm.is_owner) {
          return confirm.is_approved == 1
        }
      }

      return false
    },

    isAllApproved(word) {
      let count = 0
      let sum = 0
      for (const confirm of word.confirms) {
        if (!confirm.is_owner) {
          count++
          sum += confirm.is_approved == 1
        }
      }

      return count > 0 ? (Math.round(sum / count) == 1) : false
    },

    isCaptain() {
      if (this.me.is_captain && this.me.team_id != this.game.current_team_id) {
        return true
      }

      return false
    },

    cutSquareImage(src, width, height) {
      const maxSize = 500
      const canvas = document.createElement('canvas')
      let size = 0
      let offsetX = 0
      let offsetY = 0
      if (width > height) {
        size = height
        offsetX = Math.round((width - height) / 2)
      } else if (width < height) {
        size = width
        offsetY = Math.round((height - width) / 2)
      } else {
        size = width
      }
      canvas.width = maxSize
      canvas.height = maxSize
      let ctx = canvas.getContext('2d')
      ctx.translate(canvas.width, 0);
      ctx.scale(-1, 1)
      ctx.drawImage(src, offsetX, offsetY, size, size, 0, 0, maxSize, maxSize)
      return canvas.toDataURL('image/png')
    },

    browserHasPermission(type) {
      if (this.browserHasUserMedia) {
        if ( ! this.$kvibl.isApp()) {
          return navigator.permissions.query({ name: type }).then(permissionStatus => {
            this['auth/permissionBrowserSet']({
              type: type,
              permission: permissionStatus.state == 'granted',
            });
          })
        } else {
          return true
        }
      }

      return false
    },

    changeGameStatus(newStatus, oldStatus) {
      if (oldStatus == 5 && newStatus == 1) {
        this['viruses/selectedSet']({})
        this['words/wordsSet']([])
      }
    },

    m_resetGame() {
      this['game/reset']()
      this['teams/reset']()
      this['players/reset']()
      this['words/reset']()
      this['actions/reset']()
      this['viruses/reset']()
    },
  },
}

export default Game