<template>
  <div
    class="register"
  >
    <div>
      <app-text
        :text="$t('game.register.title')"
        title
        align="center"
        bottom-space
      />

      <app-text
        :text="$t('game.register.text')"
        bottom-space
      />
    
      <app-input
        v-model="auth.name"
        :placeholder="$t('game.register.name')"
        icon="fas fa-user"
        bottom-space
        @submit="onRegister"
      />

      <app-input
        v-model="auth.email"
        :placeholder="$t('game.register.email')"
        type="email"
        icon="fas fa-at"
        bottom-space
        @submit="onRegister"
      />

      <app-input
        v-model="auth.password"
        :placeholder="$t('game.register.password')"
        type="password"
        icon="fas fa-lock"
        bottom-space
        @submit="onRegister"
      />

      <app-checkbox
        v-model="auth.confirm"
        bottom-space
      >
        <app-link
          :text="$t('game.register.privacy')"
        />
      </app-checkbox>

      <div class="kv-center">
        <app-button
          :label="$t('game.register.button')"
          role="primary"
          small
          bottom-space
          @click="onRegister"
        />
      </div>
    </div>

    <div
      class="kv-center"
    >
      <app-link
        :text="$t('game.register.login')"
        @click="onLogin"
      />
    </div>
  </div>
</template>

<script>
  import { mapMutations, mapActions } from 'vuex'
  import { AppButton, AppInput, AppCheckbox, AppText, AppLink } from '../components'
  import tabs from '../constants/tabs'
  import Game from '../mixins/game'

  export default {
    name: 'GameRegister',

    mixins: [Game],

    components: {
      AppButton,
      AppInput,
      AppCheckbox,
      AppText,
      AppLink,
    },

    data: () => ({
      auth: {
        name: '',
        email: '',
        password: '',
        confirm: false,
        link: `${window.location.protocol}//${window.location.host}/activate/{hash}`,
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
        'auth/register',
        'players/get',
        'players/push',
      ]),

      onRegister() {
        if (this.auth.name.trim() == '') {
          this['messages/set']({
            type: 'error',
            text: this.$t('validation.required', { 'attribute': this.$t('game.register.name') }),
          })
        } else {
          if (this.auth.email.trim() == '') {
            this['messages/set']({
              type: 'error',
              text: this.$t('validation.required', { 'attribute': this.$t('game.register.email') }),
            })
          } else {
            if (this.auth.password.trim() == '') {
              this['messages/set']({
                type: 'error',
                text: this.$t('validation.required', { 'attribute': this.$t('game.register.password') }),
              })
            } else {
              if ( ! this.auth.confirm) {
                this['messages/set']({
                  type: 'error',
                  text: this.$t('validation.required', { 'attribute': this.$t('game.register.confirm') }),
                })
              } else {
                this['auth/register'](this.auth).then(data => {
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
          }
        }
      },

      onLogin() {
        this['tabs/set'](tabs.LOGIN)
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .register {
    height: 100%;
    padding: 15px 20px 30px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
</style>