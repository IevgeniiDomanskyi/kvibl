<template>
  <app-button
    icon="fas fa-arrow-left"
    round
    @click="onBack"
  />
</template>

<script>
  import { mapActions } from 'vuex'
  import AppButton from './AppButton'
  import tabs from '../constants/tabs'
  import Game from '../mixins/game'

  export default {
    name: 'TheHeaderBackButton',

    mixins: [Game],

    components: {
      AppButton,
    },

    methods: {
      ...mapActions([
        'tabs/back',
      ]),

      onBack() {
        // If user is in the game then change current tab to LOADING
        // In this case user will be redirected to right screen of the game
        if (this.game.id) {
          this['tabs/back']()
        } else {
          // If user not in the game then redirect him on Home screen
          this.$router.replace('/')
        }
      },
    },
  }
</script>