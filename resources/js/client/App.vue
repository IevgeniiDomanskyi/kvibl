<template>
  <div class="app">
    <div class="app-container">
      <offline
        class="app-offline"
        @detected-condition="onConnectionChange"
      >
        <div
          class="app-offline__inner"
          slot="online"
        >
          <router-view
            v-if="isAppReady"
          />
        </div>

        <div
          class="app-offline__inner"
          slot="offline"
        >
          <router-view
            v-if="isAppReady"
          />
        </div>
      </offline>

      <the-connection />
    </div>

    <app-message />

    <help-modal
      :visible="isHelpModalVisible"
      :steps="6"
      type="intro"
      @close="onHelpModalClose"
    />
  </div>
</template>

<script>
  import { mapState, mapMutations, mapActions } from 'vuex'
  import Offline from 'v-offline'
  import TheConnection from './components/TheConnection'
  import AppMessage from './components/AppMessage'
  import HelpModal from './components/HelpModal'
  import pusher from './pusher'

  export default {
    name: 'App',

    components: {
      Offline,
      TheConnection,
      AppMessage,
      HelpModal,
    },

    data() {
      return {
        isAppReady: false,
      }
    },

    computed: {
      ...mapState({
        locale: state => state.locales.current,
        token: state => state.auth.token,
        help: state => state.app.help,
      }),

      isHelpModalVisible() {
        // check if help modal should be visible
        return this.help
      },
    },

    created() {
      // Get current version of website
      this['app/version']()

      // Detecting current locale of the app (if we are not in app, detecting navigator locale)
      let locale = this.appLocale()

      // Checking if user already logged in app
      let data = {}
      if (this.$kvibl.isApp()) {
        data = this.$kvibl.isLoggedIn()
      }
      
      // Getting information about logged in user
      this['auth/me'](data).then(me => {
        // Checking if user is logged in website
        if (me.id) {
          // Open sockets
          pusher.init(this.token, this['app/sockets'])
          
          // Updating locale of the app based on user choice
          locale = me.locale.code
        }

        // Set locale as current locale of the app
        this['locales/set'](locale)

        // Get locales and texts for app based on current locale
        this['locales/get']().then(() => {
          this['locales/text'](this.locale).then(texts => {
            if (texts) {
              // If texts were loaded successfully app is ready to go
              this.onLoaded()
            } else {
              // To-Do
              // If there are no texts show some message ...
              console.log('*** Load Texts', 'No texts for locale ' + this.locale)
            }
          })
        })
      })
    },

    methods: {
      ...mapMutations([
        'app/helpSet',
      ]),

      ...mapActions([
        'app/version',
        'app/sockets',
        'app/network',
        'auth/me',
        'locales/set',
        'locales/get',
        'locales/text',
      ]),

      appLocale() {
        // Set default locale as en
        let locale = 'en'

        if (this.$kvibl.isApp()) {
          // Get locale of app
          locale = this.$kvibl.getLocale()
        } else {
          // Get locale of browser
          locale = (navigator.language || navigator.userLanguage).split('-')[0]
        }

        return locale
      },

      onLoaded() {
        // Render app content
        this.isAppReady = true

        // Delay before page will be rendered (for better effect)
        setTimeout(() => {
          // Get loader out from app (initial loader)
          let elLoader = document.getElementById('loader')
          if (elLoader) {
            // and if loader exists hide it with fade out animation
            elLoader.className = 'fadeout'

            // Remove loader after animation ends
            setTimeout(() => {
              elLoader.parentElement.removeChild(elLoader)
            }, 500)
          }
        }, 1000)
      },

      onConnectionChange(status) {
        // Change online status of the app
        this['app/network'](status)
      },

      onHelpModalClose() {
        // Close help modal
        this['app/helpSet'](false)
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../sass/_variables.scss';

  .app {
    height: 100%;
    overflow: hidden;

    &-container {
      width: 100%;
      height: 100%;
      max-width: 418px;
      max-height: 736px;
      min-height: 500px;
      margin: 10px auto;
      box-shadow: 0 0 10px rgba(0, 0, 0, .5);
      position: relative;
      z-index: 0;
      background-image: url('./assets/back.png');
      background-position: center bottom;
      background-repeat: no-repeat;
      background-size: cover;
      overflow: hidden;
    }

    &-offline {
      height: 100%;

      &__inner {
        height: 100%;
      }
    }
  }

  @media (max-width: 768px) {
    .app {
      &-container {
        height: 100%;
        width: 100%;
        max-height: none;
        max-width: none;
        margin: 0;
      }
    }
  }
</style>