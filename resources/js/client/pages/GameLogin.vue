<template>
  <div
    class="login"
  >
    <div>
      <app-text
        :text="$t('game.login.title')"
        title
        align="center"
        bottom-space
      />

      <app-text
        :text="$t('game.login.text')"
        bottom-space
      />

      <app-input
        v-model="auth.email"
        :placeholder="$t('game.login.email')"
        type="email"
        icon="fas fa-at"
        bottom-space
        @submit="onLogin"
      />

      <app-input
        v-model="auth.password"
        :placeholder="$t('game.login.password')"
        type="password"
        icon="fas fa-lock"
        bottom-space
        @submit="onLogin"
      />

      <div class="kv-center">
        <app-button
          :label="$t('game.login.button')"
          role="primary"
          small
          bottom-space
          @click="onLogin"
        />
      </div>

      <div
        class="kv-center"
      >
        <app-link
          :text="$t('game.login.recovery')"
          bottom-space
          @click="onRecovery"
        />
      </div>
    </div>

    <div>
      <app-text
        :text="$t('game.login.account')"
        bottom-space
      />

      <div class="kv-center">
        <app-button
          :label="$t('game.login.register')"
          role="default"
          small
          @click="onRegister"
        />
      </div>
    </div>
  </div>
</template>

<script>
  import { mapMutations, mapActions } from 'vuex'
  import { AppButton, AppInput, AppText, AppLink } from '../components'
  import tabs from '../constants/tabs'
  import Game from '../mixins/game'

  export default {
    name: 'GameLogin',

    mixins: [Game],

    components: {
      AppButton,
      AppInput,
      AppText,
      AppLink,
    },

    data: () => ({
      auth: {
        email: '',
        password: '',
      },
    }),

    created() {
      if (this.user.is_registered) {
        this['tabs/set'](tabs.STATUS)
      }
    },

    methods: {
      ...mapMutations([
        'messages/set',
      ]),

      ...mapActions([
        'tabs/set',
        'auth/login',
        'players/get',
        'players/push',
      ]),

      onRecovery() {
        this['tabs/set'](tabs.RECOVERY)
      },

      onRegister() {
        this['tabs/set'](tabs.REGISTER)
      },

      onLogin() {
        if (this.auth.email.trim() == '') {
          this['messages/set']({
            type: 'error',
            text: this.$t('validation.required', { 'attribute': this.$t('game.login.email') }),
          })
        } else {
          if (this.auth.password.trim() == '') {
            this['messages/set']({
              type: 'error',
              text: this.$t('validation.required', { 'attribute': this.$t('game.login.password') }),
            })
          } else {
            this['auth/login'](this.auth).then(data => {
              if (data) {
                this['players/get']().then(data => {
                  if (data) {
                    this['players/push']()
                    this['tabs/set'](tabs.STATUS)
                  }
                })
              }
            })
          }
        }
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .login {
    height: 100%;
    padding: 15px 20px 30px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
</style>