<template>
  <div
    class="start"
  >
    <div>
      <app-text
        :text="$t('game.start.title')"
        title
        align="center"
        bottom-space
      />

      <app-text
        :text="$t('game.start.text')"
        bottom-space
      />

      <div
        v-if="$kvibl.isApp()"
        class="kv-center"
      >
        <app-button
          :label="$t('game.start.google')"
          icon="fab fa-google"
          role="primary"
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
      </div>

      <div
        v-else
        class="kv-center"
      >
        <app-button
          :label="$t('game.start.login')"
          role="primary"
          small
          bottom-space
          @click="onLogin"
        />
      </div>
    </div>

    <div
      class="kv-center"
    >
      <app-text
        :text="$t('game.start.alternate')"
        bottom-space
      />

      <app-link
        :text="$t('game.start.continue')"
        @click="onContinue"
      />
    </div>
  </div>
</template>

<script>
  import { mapMutations, mapActions } from 'vuex'
  import { AppButton, AppText, AppLink } from '../components'
  import tabs from '../constants/tabs'
  import Game from '../mixins/game'

  export default {
    name: 'GameStart',

    mixins: [Game],

    components: {
      AppButton,
      AppText,
      AppLink,
    },

    mounted() {
      this['actions/add']('start')
    },

    methods: {
      ...mapActions([
        'tabs/set',
        'auth/register',
        'actions/add',
        'players/get',
        'players/push',
      ]),

      onContinue() {
        this['tabs/set'](tabs.STATUS)
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
        })
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .start {
    height: 100%;
    padding: 15px 20px 30px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
</style>