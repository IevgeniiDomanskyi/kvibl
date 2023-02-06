<template>
  <div
    class="header"
  >
    <the-header-back-button
      v-if="isBackVisible"
    />

    <the-header-profile
      v-else
    />

    <the-header-menu />
  </div>
</template>

<script>
  import { mapState } from 'vuex'
  import TheHeaderBackButton from './TheHeaderBackButton'
  import TheHeaderProfile from './TheHeaderProfile'
  import TheHeaderMenu from './TheHeaderMenu'
  import tabs from '../constants/tabs'
  import Game from '../mixins/game'

  export default {
    name: 'TheHeader',

    mixins: [Game],

    components: {
      TheHeaderBackButton,
      TheHeaderProfile,
      TheHeaderMenu,
    },

    computed: {
      ...mapState({
        tab: state => state.tabs.current,
      }),

      isBackVisible() {
        // Checking if back button should be visible
        // If not then profile component will be shown
        return (this.tab != tabs.LOADING) || ! this.game.id
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .header {
    height: 66px;
    padding: 10px;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
  }
</style>