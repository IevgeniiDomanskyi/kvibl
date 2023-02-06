<template>
  <div
    :class="{ isReady }"
    class="game"
  >
    <the-header
      v-if="isHeaderVisible"
    />

    <div
      :class="{'full-height': ! isHeaderVisible}"
      class="game-content"
    >
      <component :is="gameComponent" />
    </div>
  </div>
</template>

<script>
  import { mapMutations, mapActions } from 'vuex'
  import { TheHeader } from '../components'

  import GameStart from './GameStart'
  import GameLogin from './GameLogin'
  import GameRegister from './GameRegister'
  import GameRecovery from './GameRecovery'
  import GameAwards from './GameAwards'
  import GameGuests from './GameGuests'
  import GameLoading from './GameLoading'
  import GameLobby from './GameLobby'
  import GameMain from './GameMain'
  import GameNotFound from './GameNotFound'
  import GamePlayers from './GamePlayers'
  import GamePrepare from './GamePrepare'
  import GameProfile from './GameProfile'
  import GameRound from './GameRound'
  import GameTeams from './GameTeams'
  import GameViruses from './GameViruses'
  import GameWatch from './GameWatch'
  import GameWinner from './GameWinner'

  import pusher from '../pusher'
  import tabs from '../constants/tabs'
  import Game from '../mixins/game'

  export default {
    name: 'Game',

    mixins: [Game],

    components: {
      TheHeader,
      GameStart,
      GameLogin,
      GameRegister,
      GameRecovery,
      GameProfile,
      GameLoading,
      GameLobby,
      GameMain,
      GameNotFound,
      GamePlayers,
      GamePrepare,
      GameRound,
      GameTeams,
      GameWatch,
      GameAwards,
      GameGuests,
      GameViruses,
      GameWinner,
    },

    data() {
      return {
        isReady: false,
      }
    },

    computed: {
      isHeaderVisible() {
        // Hide header when player prepare to explain or explaining words to his team
        if ((this.game.status == 2 || this.game.status == 3) && this.me.player_id == this.currentPlayer.player_id) {
          return false
        }

        return true
      },

      gameComponent() {
        // Select component which should be visible based on game status and player active tab

        // Checking pages which can be visible at any game status
        if (this.tab == tabs.PROFILE) {
          return 'GameProfile'
        }

        if (this.tab == tabs.LOGIN) {
          return 'GameLogin'
        }

        if (this.tab == tabs.REGISTER) {
          return 'GameRegister'
        }

        if (this.tab == tabs.RECOVERY) {
          return 'GameRecovery'
        }

        if (this.game.status == 0) {
          // Checking player active tab first for game status 0 (when game is not start yet)
          if (this.tab == tabs.START) {
            return 'GameStart'
          }

          if (this.tab == tabs.PLAYERS) {
            return 'GamePlayers'
          }
          
          // If no tabs for this game status then clear tabs to prevent errors
          this.clearTabs()

          // If player has not active tab for this game status show him Lobby screen
          return 'GameLobby'
        }
        
        if (this.game.status > 0) {
          // If game status not equal 0 then game already started
          // So checking if there are teams in game and if not get them from server
          if (this.teams.length == 0) {
            this['teams/get']().then(teams => {
              if (teams) {
                // If teams are in game update information for players (team_id should appears for each player)
                this['players/get']()
              } else {
                // To-Do
                // If there are no teams in game show some message
                console.log('*** Get teams', 'No teams in game')
              }
            })
          }

          // Checking player active tab first for game status not equal 0 (when game is already started)
          if (this.tab == tabs.VIRUSES) {
            return 'GameViruses'
          }

          if (this.tab == tabs.GUESTS) {
            return 'GameGuests'
          }
          
          // If no tabs for this game status then clear tabs to prevent errors
          this.clearTabs()

          // If player has not active tab for this game status show him next screens

          // Game was finished and all users are at Winner screen
          if (this.game.status == 6) {
            return'GameWinner'
          }

          // All users are at Awards screen but only current user can choose awards
          if (this.game.status == 5) {
            return'GameAwards'
          }

          // Show Watch screen for all users except current user when user explain words
          // Or show this screen for all users with current user when user finished explain words
          if (this.game.status == 4 || (this.game.status == 3 && this.me.player_id != this.currentPlayer.player_id)) {
            return'GameWatch'
          }

          // Show Round screen only for current user when he explain words
          if (this.game.status == 3 && this.me.player_id == this.currentPlayer.player_id) {
            return'GameRound'
          }

          // Show Prepare screen only for current user when he prepare to explain words
          if (this.game.status == 2 && this.me.player_id == this.currentPlayer.player_id) {
            return'GamePrepare'
          }

          // Show Main screen for all users between rounds
          // Or show Main screen for all users except current user when current user preapre to explain words
          if (this.game.status == 1 || (this.game.status == 2 && this.me.player_id != this.currentPlayer.player_id)) {
            return'GameMain'
          }
        }

        // If any of these conditions was not success show Not Found screen
        return 'GameNotFound'
      },
    },

    watch: {
      game(val, oldVal) {
        // To-Do
        // Need to check if we need this
        this.changeGameStatus(val.status, oldVal.status)

        if ( ! val.id) {
          // To-Do
          // Maybe need call this.onGameRemoved() but check if it is not calling two times
          // If there is no game anymore close socket channel for it
          pusher.closeGameChanel()
        }
      },

      me(val) {
        if ( ! val.player_id) {
          // If there is no player anymore remove game and clear store
          this.onGameRemoved()
        }
      },
    },

    created() {
      // Checking if game already exists (in case if user reload the page or came by direct link)
      if ( ! this.game.id) {
        // If game is not in store go and get it from server
        this['game/get']().then(game => {
          if (game) {
            // If game exists run initialization
            this.initGame()
          } else {
            // To-Do
            // Show some message if game is not at server
            console.log('*** Game get by hash', 'No game with this url')
          }
        })
      } else {
        // If game exists run initialization
        this.initGame()
      }
    },

    methods: {
      ...mapMutations([
        'messages/set',
        'players/playersSet',
        'teams/teamsSet',
        'game/gameSet',
        'words/wordsSet',
        'viruses/selectedSet',
        'tabs/historyUpdate',
      ]),

      ...mapActions([
        'game/get',
        'teams/get',
        'players/get',
        'actions/get',
        'players/me',
        'tabs/set',
        'tabs/current',

        'players/online', // To-Do Remove after disable online option
      ]),

      onPlayersUpdate(players) {
        // Dispatch me action and commit playersSet mutation
        // Need this to update players store when receive players by sockets
        this['players/me'](players)
        this['players/playersSet'](players)
      },

      onGameRemoved() {
        // Reset game store to initial value
        this.m_resetGame()

        // Inform user that he quit the game
        this['messages/set']({
          text: this.$t('game.message.remove_player'),
          type: 'info',
        })

        // Close game channel for current user
        pusher.closeGameChanel()

        // Redirect user to Home screen
        this.$router.replace('/')
      },

      initGame() {
        // Open game channel and subscribe to all game events
        pusher.openGameChannel(this.game.id)
        pusher.listenOnlineChange(this['players/online']) // To-Do Need to disable online option
        pusher.listenPlayersChange(this.onPlayersUpdate)
        pusher.listenTeamsChange(this['teams/teamsSet'])
        pusher.listenGameChange(this['game/gameSet'])
        pusher.listenGameRemove(this.onGameRemoved)
        pusher.listenWordsChange(this['words/wordsSet'])
        pusher.listenVirusRandom(this['viruses/selectedSet'])

        // Checking if game has players and user is one o them (in case if user reload the page or came by direct link)
        if ( ! this.me.player_id) {
          // If players are not in store go and get them from server
          this['players/get']().then(players => {
            if (players) {
              // If players exist run initialization
              this.initMe()
            } else {
              // To-Do
              // Show some message if players are not at server
              console.log('*** Players get by game hash', 'No players for this url')
            }
          })
        } else {
          // If players exist run initialization
          this.initMe()
        }
      },

      initMe() {
        // Get all player's actions
        this['actions/get']().then(data => {
          // Check if player has routing history and set it to player
          if (this['actions/byCode']('history')) {
            this['tabs/historyUpdate'](this['actions/byCode']('history'))
          }

          // If game and players already exists then show game screen
          if (this.me.player_id && this.game.id) {
            // Check if player is at specific screen
            this.initTabs()

            this.isReady = true
          }
        })
      },

      initTabs() {
        // Set tab where player was at last time
        this['tabs/current'](this.me.tab)

        // Check if user play game for first time and change current tab to Start
        if (this.me.tab == tabs.STATUS && ! this.user.is_registered) {
          // Check if player saw this page and selected to be unregistered
          if ( ! this['actions/byCode']('start')) {
            this['tabs/set'](tabs.START)
          }
        }
      },

      clearTabs() {
        if (this.tab != tabs.STATUS) {
          // Reset tabs only if player is at some tab
          return this['tabs/set'](tabs.STATUS)
        }
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .game {
    height: 100%;
    background: $color-back;
    opacity: 0;
    transition: all 0.3s linear 0s;

    &.isReady {
      opacity: 1;
    }

    &-content {
      height: calc(100% - 66px);
      display: flex;
      flex-direction: column;
      justify-content: space-between;

      &.full-height {
        height: 100%;
      }
    }
  }
</style>