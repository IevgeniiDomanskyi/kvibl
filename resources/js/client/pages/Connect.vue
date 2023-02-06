<template>
  <div
    :class="{ isReady: m_isUnfinishedGameChecked }"
    class="connect"
  >
    <the-header />

    <div
      v-if="cookies"
      class="connect-content"
    >
      <div class="connect-top">
        <app-text
          :text="$t('game.connect.connect.title')"
          title
          align="center"
        />

        <app-text
          :text="$t('game.connect.connect.description')"
          align="center"
          bottom-space
        />

        <code-input
          :fields="5"
          :autoFocus="true"
          type="number"
          className="connect-top__inputs"
          @complete="onConnectGame"
        />
      </div>

      <div class="connect-or">
        <app-text
          :text="$t('game.connect.or')"
          align="center"
          size="large"
        />
      </div>

      <div class="connect-bottom">
        <app-text
          :text="$t('game.connect.create.title')"
          title
          align="center"
        />

        <app-text
          :text="$t('game.connect.create.description')"
          align="center"
          bottom-space
        />

        <app-button
          :label="$t('game.connect.create.button')"
          role="primary"
          @click="onCreateGame"
        />
      </div>
    </div>

    <kv-cookies-modal
      :visible="isCookiesModalVisible"
      @close="onCookiesModalClose"
    />
  </div>
</template>

<script>
  import { mapState, mapActions } from 'vuex'
  import CodeInput from "vue-verification-code-input";
  import { TheHeader, AppText, AppButton, KvCookiesModal } from '../components'
  import UnfinishedGame from '../mixins/unfinished-game'

  export default {
    name: 'Connect',

    mixins: [UnfinishedGame],

    components: {
      CodeInput,
      TheHeader,
      AppText,
      AppButton,
      KvCookiesModal,
    },

    data: () => ({
      isCookiesModalVisible: false,
    }),

    computed: {
      ...mapState({
        cookies: state => state.auth.cookies,
        locale: state => state.locales.current,
      }),
    },

    created() {
      // Checking if user already accepted using browser cookies
      if (this.cookies) {
        // If user accepted cookies show connect screen
        this.connect()
      } else {
        // Show cookies modal if user did not accept using browser cookies
        this.isCookiesModalVisible = true
      }
    },

    methods: {
      ...mapActions([
        'auth/preregister',
        'game/connect',
        'game/create',
      ]),

      connect() {
        // Hiding cookies modal and showing screen content
        this.isCookiesModalVisible = false

        if (this.token) {
          // Checking if user has unfinished game and redirect to game if he has
          this.m_getUnfinishedGame()
        } else {
          this['auth/preregister']({
            locale: this.locale,
          }).then(user => {
            // If user was registered show content of this screen
            if (user) {
              this.m_isUnfinishedGameChecked = true
            } else {
              // To-Do
              // If user did nor registered show some message...
              console.log('*** Register', 'Not registered')
            }
          })
        }
      },

      onCookiesModalClose(result) {
        // If user accepted using browser cookies (he always should accept it) show connect screen
        if (result) {
          this.connect()
        } else {
          // If user did not accept using browser cookies (somehow) redirect to home screen
          this.$router.replace('/')
        }
      },

      onConnectGame(code) {
        // Trying connect to excisting game
        this['game/connect']({
          code,
        }).then(game => {
          if (game && game.hash) {
            // Redirect to excisting game
            this.m_redirectToGame(game.hash)
          } else {
            // Should came error message from server
            console.log('*** Connect to game', 'Wrong connection code')
          }
        })
      },

      onCreateGame() {
        // Trying create new game
        this['game/create']().then(game => {
          if (game && game.hash) {
            // Redirect to created game
            this.m_redirectToGame(game.hash)
          } else {
            // Should came error message from server
            console.log('*** Create game', 'Some errors while create new game')
          }
        })
      },
    },
  }
</script>

<style lang="scss" scoped>
  .connect {
    height: 100%;
    opacity: 0;
    transition: all 0.3s linear 0s;

    &.isReady {
      opacity: 1;
    }

    &-content {
      padding: 15px 20px 30px;
      position: relative;
      z-index: 0;
      height: calc(100% - 66px);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    &-bottom {
      text-align: center;
      padding-bottom: 24px;
    }
  }
</style>

<style lang="scss">
  @import '../../../sass/_variables.scss';

  .connect-top__inputs {
    width: auto !important;
    text-align: center;
    margin-bottom: 15px;

    .react-code-input {
      margin: 0 -3px;

      input {
        font-family: $font-title;
        font-size: 300%;
        border: 0;
        border-radius: $radius-rect !important;
        border-width: 5px !important;
        border-style: solid !important;
        border-color: $color-secondary !important;
        background: $color-secondary-dark !important;
        color: $color-text-inverse !important;
        width: 18% !important;
        height: 60px !important;
        margin: 3px;
        padding: 15px 0 0 0 !important;
        caret-color: $color-text-inverse !important;
        box-shadow:
          inset 0 2px 5px $shadow-2,
          0 1px 5px $shadow-2;

        &:focus {
          border: 0;
          caret-color: $color-text-inverse !important;
        }
      }

      @media(max-width: 768px) {
        input {
          padding: 0 !important;
        }
      }
    }
  }
</style>