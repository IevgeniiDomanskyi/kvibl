<template>
  <div
    :class="{ isReady: m_isUnfinishedGameChecked }"
    class="home"
  >
    <div class="home-top">
      <div class="home-top__settings">
        <kv-locales-home />

        <app-button
          icon="fas fa-question"
          round
          @click="onHelp"
        />
      </div>

      <kv-logo-text
        :text="$t('game.home.subtitle')"
      />
    </div>

    <kv-logo
      width="80%"
      viruses
    />

    <div class="home-bottom">
      <app-button
        :label="$t('game.home.create')"
        :width="200"
        role="primary"
        pulse
        @click="onConnectGame"
      />

      <app-text
        :text="$t('game.home.version', { version })"
        align="center"
        class="home-bottom__version"
      />
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex'
  import { AppText, AppButton, KvLocalesHome, KvLogo, KvLogoText } from '../components'
  import UnfinishedGame from '../mixins/unfinished-game'

  export default {
    name: 'Home',

    mixins: [UnfinishedGame],

    components: {
      AppText,
      AppButton,
      KvLocalesHome,
      KvLogo,
      KvLogoText,
    },

    computed: {
      ...mapState({
        version: state => state.app.version,
      }),
    },

    created() {
      // Checking if user has unfinished game and redirect to game if he has
      this.m_getUnfinishedGame()
    },

    methods: {
      onHelp() {
        this['app/helpSet'](true)
      },

      onConnectGame() {
        this.$router.replace('/connect')
      },
    }
  }
</script>

<style lang="scss" scoped>
  .home {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    opacity: 0;
    transition: all 0.3s linear 0s;

    &.isReady {
      opacity: 1;
    }

    &-top {
      width: 100%;
      
      &__settings {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
      }
    }

    &-bottom {
      width: 100%;
      text-align: center;
      padding-bottom: 5px;
      
      &__version {
        padding-top: 30px;
      }
    }
  }
</style>