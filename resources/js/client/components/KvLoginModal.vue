<template>
  <app-modal
    :visible="visible"
    :title="$t('game.start.modal_title')"
    role="default"
    no-footer
    @close="onClose"
  >
    <app-text
      :text="$t('game.start.modal_text')"
      bottom-space
    />

    <app-button
      :label="$t('game.start.google')"
      icon="fab fa-google"
      role="primary"
      block
      small
      bottom-space
      @click="onLoginGoogle"
    />

    <app-text
      :text="$t('game.start.or')"
      align="center"
      bottom-space
    />

    <div class="kv-center">
      <app-link
        :text="$t('game.start.login')"
        bottom-space
        @click="onLogin"
      />
    </div>
  </app-modal>
</template>

<script>
  import { mapActions } from 'vuex'
  import AppModal from './AppModal'
  import AppText from './AppText'
  import AppLink from './AppLink'
  import AppButton from './AppButton'
  import tabs from '../constants/tabs'
  import Game from '../mixins/game'

  export default {
    name: 'KvLoginModal',

    mixins: [Game],

    components: {
      AppModal,
      AppText,
      AppLink,
      AppButton,
    },

    props: {
      visible: {
        type: Boolean,
        default: false,
      },
    },

    methods: {
      ...mapActions([
        'tabs/set',
        'auth/register',
        'players/get',
        'players/push',
      ]),

      onClose() {
        this.$emit('close')
      },

      onLogin() {
        this['tabs/set'](tabs.LOGIN)
      },

      onLoginGoogle() {
        this.$kvibl.login(this.loggedInGoogle)
      },

      loggedInGoogle(data) {
        data.is_registered = true
        this['auth/register'](data).then(me => {
          if (me) {
            this['players/get']().then(data => {
              if (data) {
                this['players/push']()
                this['tabs/set'](tabs.STATUS)
              }
            })
          } else {
            console.log('*** Register user', 'Something went wrong')
          }

          this.onClose()
        })
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

</style>