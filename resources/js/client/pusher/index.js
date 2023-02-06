import Echo from 'laravel-echo'
import VueCookie from 'vue-cookie'

window.io = require('socket.io-client')

const pusher = {
  echo: null,
  gameChannel: null,

  init(token = null, connectCallback) {
    if ( ! token) {
      token = VueCookie.get('token')
    }

    if (token) {
      if ( ! this.echo) {
        const port = (window.location.hostname.indexOf('staging') + 1) ? 6002 : 6001
        this.echo = new Echo({
          broadcaster: "socket.io",
          host: `${window.location.hostname}:${port}`,
          auth: {
            headers: {
              Authorization: "Bearer " + token,
            },
          },
        })

        this.log(this.echo, 'Echo init')

        this.echo.connector.socket.on('connect', () => {
          this.log(this.echo.socketId(), 'Connected Event')
          connectCallback({
            type: 'connected',
          })
        })

        this.echo.connector.socket.on('disconnect', () => {
          this.log('Disconnected Event')
          connectCallback({
            type: 'disconnected',
          })
        })

        this.echo.connector.socket.on('reconnecting', (attempts) => {
          this.log(attempts, 'Reconnecting Event')
          connectCallback({
            type: 'reconnected',
            attempts,
          })
        })

        return this.echo
      } else {
        this.log('Echo already inited')
      }
    } else {
      this.log('Token in null during Echo init')
    }

    return false
  },

  openGameChannel(gameId) {
    this.closeGameChanel()

    if (this.echo) {
      this.gameChannel = this.echo.join(`game.${gameId}`)
      this.log(this.gameChannel, 'Game Channel was open')
      return this.gameChannel
    } else {
      this.log('Echo is undefined during Open Game Channel')
    }

    return false
  },

  listenOnlineChange(callback) {
    if (this.gameChannel) {
      this.gameChannel
        .joining((data) => {
          this.log(data, 'Joining during listen Online Change Event')

          callback(true)
        })
        .leaving((data) => {
          this.log(data, 'Leaving during listen Online Change Event')

          callback(false)
        })

      window.onblur = () => {
        this.log('Window onBlur during listen Online Change Event')

        callback(false)
      }

      window.onfocus = () => {
        this.log('Window onFocus during listen Online Change Event')

        callback(true)
      }
    } else {
      this.log('Game Channel is undefined during listen Online Change Event')
    }
  },

  listenGameChange(callback) {
    if (this.gameChannel) {
      this.gameChannel.listen('Api.Game.GameChange', (e) => {
        this.log(e.game, 'Listen Game Change Event')

        callback(e.game)
      })

      const event = this.gameChannel.events[(this.gameChannel.eventFormatter.namespace + '.Api.Game.GameChange').replace(/\./gi, '\\')]
      if (event) {
        this.log(event, 'Subscribe to Game Change Event')
        return event
      }

      this.log('Faild Subscribe to Game Change Event')
    } else {
      this.log('Game Channel is undefined during listen Game Change Event')
    }

    return false
  },

  listenGameRemove(callback) {
    if (this.gameChannel) {
      this.gameChannel.listen('Api.Game.GameRemove', (e) => {
        this.log('Listen Game Remove Event')

        callback()
      })

      const event = this.gameChannel.events[(this.gameChannel.eventFormatter.namespace + '.Api.Game.GameRemove').replace(/\./gi, '\\')]
      if (event) {
        this.log(event, 'Subscribe to Game Remove Event')
        return event
      }

      this.log('Faild Subscribe to Game Remove Event')
    } else {
      this.log('Game Channel is undefined during listen Game Remove Event')
    }

    return false
  },

  listenPlayersChange(callback) {
    if (this.gameChannel) {
      this.gameChannel.listen('Api.Game.PlayersChange', (e) => {
        this.log(e.players, 'Listen Players Change Event')

        callback(e.players)
      })

      const event = this.gameChannel.events[(this.gameChannel.eventFormatter.namespace + '.Api.Game.PlayersChange').replace(/\./gi, '\\')]
      if (event) {
        this.log(event, 'Subscribe to Players Change Event')
        return event
      }

      this.log('Faild Subscribe to Players Change Event')
    } else {
      this.log('Game Channel is undefined during listen Players Change Event')
    }

    return false
  },

  listenTeamsChange(callback) {
    if (this.gameChannel) {
      this.gameChannel.listen('Api.Team.TeamChange', (e) => {
        this.log(e.teams, 'Listen Teams Change Event')

        callback(e.teams)
      })

      const event = this.gameChannel.events[(this.gameChannel.eventFormatter.namespace + '.Api.Team.TeamChange').replace(/\./gi, '\\')]
      if (event) {
        this.log(event, 'Subscribe to Teams Change Event')
        return event
      }

      this.log('Faild Subscribe to Teams Change Event')
    } else {
      this.log('Game Channel is undefined during listen Teams Change Event')
    }

    return false
  },

  listenWordsChange(callback) {
    if (this.gameChannel) {
      this.gameChannel.listen('Api.Word.WordChange', (e) => {
        this.log(e.words, 'Listen Words Change Event')

        callback(e.words)
      })

      const event = this.gameChannel.events[(this.gameChannel.eventFormatter.namespace + '.Api.Word.WordChange').replace(/\./gi, '\\')]
      if (event) {
        this.log(event, 'Subscribe to Words Change Event')
        return event
      }

      this.log('Faild Subscribe to Words Change Event')
    } else {
      this.log('Game Channel is undefined during listen Words Change Event')
    }

    return false
  },

  listenVirusRandom(callback) {
    if (this.gameChannel) {
      this.gameChannel.listen('Api.Virus.VirusRandom', (e) => {
        this.log(e.virus, 'Virus', 'Listen Virus Random Event')
        this.log(e.position, 'Position', 'Listen Virus Random Event')

        callback({virus: e.virus, position: e.position})
      })

      const event = this.gameChannel.events[(this.gameChannel.eventFormatter.namespace + '.Api.Virus.VirusRandom').replace(/\./gi, '\\')]
      if (event) {
        this.log(event, 'Subscribe to Virus Random Event')
        return event
      }

      this.log('Faild Subscribe to Virus Random Event')
    } else {
      this.log('Game Channel is undefined during listen Virus Random Event')
    }

    return false
  },

  closeGameChanel() {
    if (this.echo) {
      if (this.gameChannel) {
        this.echo.leave(this.gameChannel.name)
        this.gameChannel = null

        this.log('Game Channel was closed')
        return true
      } else {
        this.log('Game Channel is undefined during Close Game Channel')
      }
    } else {
      this.log('Echo is undefined during Close Game Channel')
    }

    return false
  },

  log(data, title = false) {
    if (process.env.MIX_APP_ENV == 'local') {
      // if (title) {
      //   console.log(title, data)
      // } else {
      //   console.log(data)
      // }
    }
  },
}

export default pusher