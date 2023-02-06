<template>
  <div
    :class="{ isReady: isLoaded }"
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

    <div
      class="activate-content"
    >
      <i
        v-if="result"
        class="far fa-thumbs-up i-success"
      />

      <i
        v-else
        class="far fa-exclamation-circle i-error"
      />

      <app-text
        :text="$t('game.activate.' + (result ? 'success' : 'error'))"
      />
    </div>

    <div class="home-bottom">
      <app-button
        :label="$t('game.activate.' + (result ? 'continue' : 'home'))"
        :width="200"
        role="primary"
        @click="onHome"
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
  import { mapState, mapActions } from 'vuex'
  import { AppText, AppButton, KvLocalesHome, KvLogo, KvLogoText } from '../components'

  export default {
    name: 'Activate',

    components: {
      AppText,
      AppButton,
      KvLocalesHome,
      KvLogo,
      KvLogoText,
    },

    data: () => ({
      isLoaded: false,
      result: false,
    }),

    computed: {
      ...mapState({
        version: state => state.app.version,
      }),
    },

    created() {
      this['auth/activate']().then(me => {
        this.isLoaded = true
        if (me.id) {
          this.result = true
        }
      })
    },

    methods: {
      ...mapActions([
        'auth/activate',
      ]),

      onHelp() {
        this['app/helpSet'](true)
      },

      onHome() {
        this.$router.replace('/')
      },
    }
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .activate-content {
    padding: 0 30px 50px;
    text-align: center;

    i {
      font-size: 50px;
      margin-bottom: 15px;

      &.i-success {
        color: $color-success;
      }

      &.i-error {
        color: $color-danger;
      }
    }
  }

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