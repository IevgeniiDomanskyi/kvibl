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
      v-if="user.id"
      class="password-content"
    >
      <app-avatar
        :image="user.avatar"
      />

      <app-text
        :text="user.name"
        title
        align="center"
      />

      <app-input
        v-model="password"
        :placeholder="$t('game.password.password')"
        type="password"
        icon="fas fa-lock"
        @submit="onPassword"
      />
    </div>

    <div
      v-else
      class="password-content"
    >
      <i
        class="far fa-exclamation-circle i-error"
      />

      <app-text
        :text="$t('game.password.error')"
      />
    </div>

    <div class="home-bottom">
      <app-button
        v-if="user.id"
        :label="$t('game.password.save')"
        :width="200"
        role="primary"
        @click="onPassword"
      />

      <app-button
        v-else
        :label="$t('game.password.home')"
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
  import { mapState, mapMutations, mapActions } from 'vuex'
  import { AppAvatar, AppText, AppInput, AppButton, KvLocalesHome, KvLogo, KvLogoText } from '../components'

  export default {
    name: 'Password',

    components: {
      AppAvatar,
      AppText,
      AppInput,
      AppButton,
      KvLocalesHome,
      KvLogo,
      KvLogoText,
    },

    data: () => ({
      isLoaded: false,
      user: {},
      password: '',
    }),

    computed: {
      ...mapState({
        version: state => state.app.version,
      }),
    },

    created() {
      this['auth/hash']().then(me => {
        this.isLoaded = true
        if (me) {
          this.user = me
        }
      })
    },

    methods: {
      ...mapMutations([
        'messages/set',
      ]),

      ...mapActions([
        'auth/hash',
        'auth/password',
        'tabs/set',
      ]),

      onHelp() {
        this['app/helpSet'](true)
      },

      onPassword() {
        if (this.password.trim() == '') {
          this['messages/set']({
            type: 'error',
            text: this.$t('validation.required', { 'attribute': this.$t('game.password.field') }),
          })
        } else {
          this['auth/password']({
            password: this.password,
          }).then(data => {
            if (data) {
              this.$router.replace('/')
            }
          })
        }
      },

      onHome() {
        this.$router.replace('/')
      },
    }
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .password-content {
    padding: 0 30px 50px;
    width: 100%;
    text-align: center;

    i {
      font-size: 50px;
      margin-bottom: 15px;

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