<template>
  <div
    class="header-menu"
  >
    <the-header-menu-item
      icon="fas fa-users"
      :visible="isPlayersVisible"
      :active="isPlayersActive"
      :badge="playersCount"
      @click="onPlayers"
    />

    <the-header-menu-item
      icon="fas fa-virus"
      :visible="isVirusesVisible"
      :active="isVirusesActive"
      :badge="virusesCount"
      @click="onViruses"
    />

    <the-header-menu-item
      icon="fas fa-glasses-alt"
      :visible="isGuestsVisible"
      :active="isGuestsActive"
      :badge="guestsCount"
      @click="onGuests"
    />

    <the-header-menu-item
      icon="fas fa-sign-out-alt"
      quit
      @click="onQuit"
    />

    <app-modal-confirm
      :title="$t('game.modal.quit.title')"
      :text="$t('game.modal.quit.text')"
      :visible="isQuitModalVisible"
      @close="onQuitClose"
      @confirm="onQuitConfirm"
    />
  </div>
</template>

<script>
  import { mapState, mapActions } from 'vuex'
  import TheHeaderMenuItem from './TheHeaderMenuItem'
  import AppModalConfirm from './AppModalConfirm'
  import tabs from '../constants/tabs'
  import Game from '../mixins/game'

  export default {
    name: 'TheHeaderMenu',

    mixins: [Game],

    components: {
      TheHeaderMenuItem,
      AppModalConfirm,
    },

    data() {
      return {
        isQuitModalVisible: false,
      }
    },

    computed: {
      ...mapState({
        tab: state => state.tabs.current,
      }),

      isPlayersVisible() {
        // Checking if game is not started yet then show Players menu item
        return this.game.status == 0
      },

      isPlayersActive() {
        // Checking if user is at Players screen or not
        return this.game.status == 0 && this.tab == tabs.PLAYERS
      },

      playersCount() {
        // Count only registered users or users with name and avatar filled
        let count = 0
        for (const player of this.players) {
          if (player.status == 1) {
            count++
          }
        }
        return count
      },

      isVirusesVisible() {
        // Checking if game is already started and not finished then show Viruses menu item
        return this.game.status > 0 && this.game.status != 6
      },

      isVirusesActive() {
        // Checking if user is at Viruses screen or not
        return this.game.status > 0 && this.tab == tabs.VIRUSES
      },

      virusesCount() {
        // Count viruses of current user
        let count = 0
        if (this.me && this.me.viruses) {
          for (const virus of this.me.viruses) {
            count += virus.count
          }
        }
        return count
      },

      isGuestsVisible() {
        // Checking if game is already started and not finished then show Guests menu item
        return this.game.status > 0 && this.game.status != 6
      },

      isGuestsActive() {
        // Checking if user is at Guests screen or not
        return this.game.status > 0 && this.tab == tabs.GUESTS
      },

      guestsCount() {
        // Count guests (users without team) of the game
        let count = 0
        for (const player of this.players) {
          if (player.team_id == 0) {
            count++
          }
        }
        return count
      },
    },

    methods: {
      ...mapActions([
        'players/leave',
        'tabs/set',
      ]),

      onQuit() {
        // Checking if user is already at the game
        if (this.game.id) {
          // If in the game then show confirmation modal to quit
          this.isQuitModalVisible = true
        } else {
          // If not just redirect to Home screen
          this.$router.replace('/')
        }
      },

      onQuitClose() {
        this.isQuitModalVisible = false
      },

      onQuitConfirm() {
        // If user confirmed quit from game send it to backend
        this['players/leave']().then(response => {
          if (response) {
            // If all were fine reset user's store
            this.m_resetGame()
          } else {
            // To-Do
            // If there is some error, show some message
            console.log('*** Quit game', 'Some server error')
          }
        })
      },

      onPlayers() {
        this['tabs/set'](tabs.PLAYERS)
      },

      onViruses() {
        this['tabs/set'](tabs.VIRUSES)
      },

      onGuests() {
        this['tabs/set'](tabs.GUESTS)
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .header-menu {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
  }
</style>