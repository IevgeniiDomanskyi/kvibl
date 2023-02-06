<template>
  <div
    :class="{ visible: visible }"
    class="sidemenu"
  >
    <div
      class="sidemenu__menu"
    >
      <kv-locales-home
        class="sidemenu__menu_langs"
      />

      <div class="sidemenu__menu-main">
        <the-sidemenu-item
          :text="$t('game.sidemenu.profile')"
          icon="fas fa-user"
          @click="onTab(tabs.PROFILE)"
        />

        <the-sidemenu-item
          :text="$t('game.sidemenu.rules')"
          icon="fas fa-question"
          @click="onHelpShow"
        />

        <the-sidemenu-item
          :text="$t('game.sidemenu.support')"
          icon="fas fa-envelope-open-text"
          @click="onSupportShow"
        />

        <the-sidemenu-item
          v-if="user.is_registered"
          :text="$t('game.sidemenu.logout')"
          icon="fas fa-door-open"
          color="danger"
          @click="onLogout"
        />

        <the-sidemenu-item
          v-else
          :text="$t('game.sidemenu.login')"
          icon="fas fa-door-closed"
          color="success"
          @click="onLogin"
        />
      </div>

      <div class="sidemenu__menu-bottom">
        <app-button
          :icon="'fas fa-volume-' + (mute ? 'mute' : 'up')"
          :role="mute ? 'disabled' : 'success'"
          round
          @click="onMuteToogle"
        />

        <app-text
          :text="$t('game.home.version', { version })"
        />
      </div>
    </div>

    <div
      class="sidemenu__backdrop"
      @click="onClose"
    />

    <kv-login-modal
      :visible="isLoginModalVisible"
      @close="onLoginModalClose"
    />
  </div>
</template>

<script>
  import { mapState, mapMutations, mapActions } from 'vuex'
  import KvLocalesHome from './KvLocalesHome'
  import KvLoginModal from './KvLoginModal'
  import TheSidemenuItem from './TheSidemenuItem'
  import AppButton from './AppButton'
  import AppText from './AppText'
  import tabs from '../constants/tabs'
  import Game from '../mixins/game'

  export default {
    name: 'TheSidemenu',

    mixins: [Game],

    components: {
      KvLocalesHome,
      KvLoginModal,
      TheSidemenuItem,
      AppButton,
      AppText,
    },

    props: {
      visible: {
        type: Boolean,
        default: false,
      },
    },

    data: () => ({
      tabs: {},
      isLoginModalVisible: false,
    }),

    computed: {
      ...mapState({
        version: state => state.app.version,
        mute: state => state.app.mute,
      }),
    },

    created() {
      this.tabs = tabs
    },

    methods: {
      ...mapMutations([
        'app/muteSet',
      ]),

      ...mapActions([
        'tabs/set',
        'auth/logout',
        'players/get',
        'players/push',
      ]),

      onClose() {
        this.$emit('close')
      },

      onMuteToogle() {
        this['app/muteSet']( ! this.mute)
      },

      onLogout() {
        if (this.$kvibl.isApp()) {
          this.onLogoutGoogle()
        } else {
          this.loggedOut()
        }
      },

      onLogoutGoogle() {
        this.$kvibl.logout(this.loggedOut)
      },

      loggedOut() {
        this['auth/logout']().then(data => {
          if (data) {
            this['players/get']().then(data => {
              this['players/push']()
            })
          }
        })
      },

      onLogin() {
        if (this.$kvibl.isApp()) {
          this.isLoginModalVisible = true
        } else {
          this['tabs/set'](tabs.LOGIN)
        }
      },

      onLoginModalClose() {
        this.isLoginModalVisible = false
      },

      onHelpShow() {
        this['app/helpSet'](true)
      },

      onSupportShow() {
        console.log('Support Modal Show')
      },

      onTab(tab) {
        this['tabs/set'](tab)
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .sidemenu {
    position: absolute;
    z-index: 10;
    width: 100%;
    top: 0;
    bottom: 0;
    left: -100%;
    transition: all 0.1s linear 0s;

    &__menu {
      position: absolute;
      z-index: 1;
      width: 85%;
      top: 0;
      bottom: 0;
      left: 0;
      padding: 100px 10px 14px;
      background: $color-secondary-light;
      box-shadow: 0 0 10px $shadow-5;
      display: flex;
      flex-direction: column;
      justify-content: space-between;

      &_langs {
        position: absolute;
        z-index: 0;
        top: 10px;
        right: 10px;
      }

      &-bottom {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
      }
    }

    &__backdrop {
      position: absolute;
      z-index: 0;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      background: $shadow-3;
      opacity: 0;
      transition: all 0.1s linear 0s;
    }

    &.visible {
      left: 0;

      .sidemenu__backdrop {
        opacity: 1;
      }
    }
  }
</style>