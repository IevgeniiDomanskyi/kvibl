<template>
  <div
    v-if="isTrouble"
    class="connection"
  >
    <div
      v-if="isReconnecting"
      class="connection-status"
    >
      <div class="connection-status__reconnecting">
        <svg height="48" viewBox="0 0 48 48" width="48" xmlns="http://www.w3.org/2000/svg">
          <path d="M0 0h48v48h-48z" fill="none"/>
          <path d="M47.28 14c-.9-.68-9.85-8-23.28-8-3.01 0-5.78.38-8.3.96l20.66 20.64 10.92-13.6zm-40.73-11.11l-2.55 2.55 4.11 4.11c-4.28 1.97-6.92 4.1-7.39 4.46l23.26 28.98.02.01.02-.02 7.8-9.72 6.63 6.63 2.55-2.55-34.45-34.45z"/>
        </svg>
      </div>

      <app-text
        :text="$t('game.connection.reconnecting')"
      />
    </div>

    <div
      v-if="isReload"
      class="connection-status"
    >
      <app-button
        role="danger"
        icon="fas fa-sync-alt"
        round
        class="connection-status__reload"
        @click="onClick"
      />

      <app-text
        :text="$t('game.connection.reload')"
      />
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex'
  import AppText from './AppText'
  import AppButton from './AppButton'

  export default {
    name: 'TheConnection',

    components: {
      AppText,
      AppButton,
    },

    computed: {
      ...mapState({
        sockets: state => state.app.connection.sockets,
        network: state => state.app.connection.network,
      }),

      isTrouble() {
        return (this.sockets != 1 || this.network != 1)
      },

      isReconnecting() {
        return (this.sockets == 2 || this.network == 0)
      },

      isReload() {
        return (this.sockets == 0 && this.network == 1)
      },
    },

    methods: {
      onClick() {
        window.location.reload()
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .connection {
    position: absolute;
    z-index: 15;
    padding: 10px;
    left: 0;
    top: 0;
    bottom: 0;
    right: 0;
    background: $glow-9;

    &-status {
      display: flex;
      justify-content: flex-start;
      align-items: center;

      &__reconnecting {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 20px;
        width: 46px;
        height: 46px;
        border-radius: 50%;
        border: solid $color-text-inverse 4px;
        box-shadow: 0 0 6px $shadow-5;
        background-color: $color-danger;
        margin-right: 10px;
        animation: blink 1s infinite alternate;

        svg {
          width: 60%;
          fill: $color-text-inverse;
        }
      }

      &__reload {
        margin-right: 10px;
      }
    }
  }

  @keyframes blink {
    0% {
      opacity: 1;
    }
    100% {
      opacity: 0.3;
    }
  }
</style>