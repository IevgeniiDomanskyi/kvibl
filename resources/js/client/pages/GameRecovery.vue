<template>
  <div
    class="recovery"
  >
    <div>
      <app-text
        :text="$t('game.recovery.title')"
        title
        align="center"
        bottom-space
      />

      <app-text
        :text="$t('game.recovery.text')"
        bottom-space
      />
    
      <app-input
        v-model="auth.email"
        :placeholder="$t('game.recovery.email')"
        type="email"
        icon="fas fa-at"
        bottom-space
        @submit="onRecovery"
      />

      <div class="kv-center">
        <app-button
          :label="$t('game.recovery.recovery')"
          role="primary"
          small
          bottom-space
          @click="onRecovery"
        />
      </div>
    </div>

    <div
      class="kv-center"
    >
      <app-link
        :text="$t('game.recovery.login')"
        @click="onLogin"
      />
    </div>
  </div>
</template>

<script>
  import { mapMutations, mapActions } from 'vuex'
  import { AppButton, AppInput, AppText, AppLink } from '../components'
  import tabs from '../constants/tabs'
  import Game from '../mixins/game'

  export default {
    name: 'GameRecovery',

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
        link: `${window.location.protocol}//${window.location.host}/password/{hash}`,
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
        'auth/recovery',
      ]),

      onLogin() {
        this['tabs/set'](tabs.LOGIN)
      },

      onRecovery() {
        if (this.auth.email.trim() == '') {
          this['messages/set']({
            type: 'error',
            text: this.$t('validation.required', { 'attribute': this.$t('game.recovery.email') }),
          })
        } else {
          this['auth/recovery'](this.auth).then(data => {
            if (data) {
              this['tabs/set'](tabs.LOGIN)
            }
          })
        }
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .recovery {
    height: 100%;
    padding: 15px 20px 30px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
</style>