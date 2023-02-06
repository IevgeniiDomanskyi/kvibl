<template>
  <div
    class="loader-box start"
  >
    <div
      v-if=" ! newPlayer"
      class="loader"
      :style="'width: ' + size + 'px; height: ' + size + 'px;'"
      :class="'border-' + border"
    >
      <span></span>
    </div>

    <app-text
      v-if="text && ! newPlayer"
      :style="'height: ' + size + 'px;'"
      :text="text"
      align="center"
      class="loader-text"
    />

    <div
      v-if="newPlayer"
      :style="'width: ' + size + 'px; height: ' + size + 'px;'"
      class="loader-player"
    >
      <app-avatar
        :image="newPlayer.avatar"
        size="fade"
      />

      <app-text
        :style="'height: ' + size + 'px;'"
        :text="newPlayer.name"
        align="center"
        type="title"
        class="loader-player__name"
      />
    </div>
  </div>
</template>

<script>
  import Game from '../mixins/game'
  import AppAvatar from './AppAvatar'
  import AppText from './AppText'

  export default {
    name: 'KvLobbyLoader',

    mixins: [Game],

    components: {
      AppAvatar,
      AppText,
    },

    props: {
      size: {
        type: Number,
        default: 40,
      },

      border: {
        type: Number,
        default: 2,
      },

      text: {
        type: String,
        default: null,
      },
    },

    data() {
      return {
        newPlayer: null,
      }
    },

    watch: {
      players(val, oldVal) {
        if (val.filter(item => item.status == 1).length > oldVal.filter(item => item.status == 1).length) {
          let newPlayer = null
          for (const player of val) {
            let check = true
            for (const oldPlayer of oldVal) {
              if (player.player_id == oldPlayer.player_id && player.status == oldPlayer.status) {
                check = false
              }
            }

            if (check) {
              newPlayer = player
            }
          }

          if (newPlayer && newPlayer.status == 1) {
            this.newPlayer = newPlayer
            setTimeout(() => {
              this.newPlayer = null
            }, 3000)
          }
        }
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .loader-box {
    text-align: center;
    position: relative;
    z-index: 0;

    .loader-text {
      position: absolute;
      z-index: 1;
      top: 0;
      width: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .loader-player {
      display: inline-block;
      position: relative;
      z-index: 0;

      &__name {
        position: absolute;
        z-index: 3;
        top: 0;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        margin: 0;
      }
    }
  }

  .loader {
    display: inline-block;
    position: relative;
    z-index: 0;
  }

  .loader span {
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    margin: auto;
    height: inherit;
    width: inherit;
  }

  .loader span::before,
  .loader span::after {
    content: "";
    display: block;
    position: absolute;
    top: 0; left: 0;
    bottom: 0; right: 0;
    margin: auto;
    height: inherit;
    width: inherit;
    border: 2px solid $default;
    border-radius: 50%;
    opacity: 0;
  }

  .loader.border-3 span::before,
  .loader.border-3 span::after {
    border-width: 3px;
  }

  .loader.border-4 span::before,
  .loader.border-4 span::after {
    border-width: 4px;
  }

  .loader.border-5 span::before,
  .loader.border-5 span::after {
    border-width: 5px;
  }

  .loader.border-10 span::before,
  .loader.border-10 span::after {
    border-width: 10px;
  }

  @-webkit-keyframes loader-1 {
    0%   { -webkit-transform: translate3d(0, 0, 0) scale(0); opacity: 1; }
    100% { -webkit-transform: translate3d(0, 0, 0) scale(1.5); opacity: 0; }
  }

  @keyframes loader-1 {
    0%   { transform: translate3d(0, 0, 0) scale(0); opacity: 1; }
    100% { transform: translate3d(0, 0, 0) scale(1.5); opacity: 0; }
  }

  @-webkit-keyframes loader-2 {
    0%   { -webkit-transform: translate3d(0, 0, 0) scale(0); opacity: 1; }
    100% { -webkit-transform: translate3d(0, 0, 0) scale(1); opacity: 0; }
  }

  @keyframes loader-2 {
    0%   { transform: translate3d(0, 0, 0) scale(0); opacity: 1; }
    100% { transform: translate3d(0, 0, 0) scale(1); opacity: 0; }
  }

  .loader-box.start {
    .loader-player {
      animation-name: loader-1;
      animation-duration: 3.5s;
      animation-timing-function: cubic-bezier(0.075, 0.820, 0.165, 1.000);
    }

    .loader span::before,
    .loader span::after {
      animation-name: loader-1;
      animation-duration: 1.5s;
      animation-timing-function: cubic-bezier(0.075, 0.820, 0.165, 1.000);
      animation-iteration-count: infinite;
    }

    .loader span::after {
      animation-name: loader-2;
      animation-duration: 1.5s;
      animation-timing-function: cubic-bezier(0.075, 0.820, 0.165, 1.000);
      animation-iteration-count: infinite;
      animation-delay: .25s;
    }
  }
</style>