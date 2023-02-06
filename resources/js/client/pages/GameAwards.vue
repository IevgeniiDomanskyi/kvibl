<template>
  <div
    class="awards"
  >
    <div>
      <app-text
        :text="$t('game.awards.' + (isLoaded ? ((isGuest ? 'guest_' : '') + 'loaded') : ((isGuest ? 'guest_' : '') + 'title')), {name: currentPlayer.name})"
        type="title"
        align="center"
        bottom-space
      />

      <div
        class="awards-middle"
      >
        <div
          v-if="isGuest && ! isLoaded"
          class="awards-middle__guest"
        >
          <div class="awards-middle__guest-loader">
            <div />
            <div />
          </div>

          <app-avatar
            :image="currentPlayer.avatar"
            size="fade"
            class="awards-middle__guest-avatar"
          />
        </div>

        <div
          v-if=" ! isGuest"
          class="awards-middle__button"
        >
          <app-button
            v-if=" ! isLoaded"
            :icon="clicked ? 'fas fa-virus fa-spin' : 'fas fa-question'"
            role="warning"
            round
            large
            :pulse=" ! clicked"
            :active="clicked"
            @click="onAwardsClick"
          />
        </div>

        <div
          :class="{ loaded: isLoaded }"
          class="awards-middle__virus"
        >
          <img
            :src="image(virus.image)"
            class="awards-middle__virus-image"
          />

          <div class="awards-middle__virus-hail" />
          <div class="awards-middle__virus-hail2" />
          <div class="awards-middle__virus-name">
            <app-text
              :text="virus.name"
              type="title"
              align="center"
            />
          </div>

          <app-text
            :text="virus.description"
            :class="{ loaded: isLoaded }"
            class="awards-middle__virus-description"
            align="center"
          />
        </div>

        <div
          :class="{ hide: isLoaded }"
          class="awards-middle__description"
        >
          <app-text
            v-if="isGuest"
            :text="currentPlayer.name"
            type="title"
            align="center"
          />

          <app-text
            :text="$t('game.awards.' + (isGuest ? 'guest_' : '') + 'description')"
            align="center"
          />
        </div>
      </div>
    </div>

    <div class="awards-bottom">
      <app-button
        v-if=" ! isGuest && isLoaded"
        :label="$t('game.awards.continue', { time: time })"
        role="primary"
        pulse
        @click="onAwards"
      />
    </div>
  </div>
</template>

<script>
  import { mapState, mapGetters, mapMutations, mapActions } from 'vuex'
  import { AppButton, AppAvatar, AppText } from '../components'
  import Game from '../mixins/game'

  export default {
    name: 'GameAwards',

    mixins: [Game],

    components: {
      AppButton,
      AppAvatar,
      AppText,
    },

    data() {
      return {
        time: 5,
        clicked: false,
        loaded: false,
      }
    },

    computed: {
      ...mapState({
        virus: state => state.viruses.selected,
      }),

      ...mapGetters([
        'actions/byCode',
      ]),

      ...mapGetters([
        'game/currentPlayer',
      ]),

      currentPlayer() {
        return this['game/currentPlayer']
      },

      isGuest() {
        return this.me.player_id != this.currentPlayer.player_id
      },

      isAwarded() {
        return this['actions/byCode']('virus-' + this.game.lap) && ! this.isGuest
      },

      isClicked() {
        return (this['actions/byCode']('virus-clicked-' + this.game.lap) && ! this.isGuest) || this.clicked
      },

      isLoaded() {
        return (this['actions/byCode']('virus-loaded-' + this.game.lap) && ! this.isGuest) || this.loaded
      },
    },

    watch: {
      virus(val) {
        if (val.virus && this.isGuest) {
          this['viruses/selectedSet'](val.virus)

          if ( ! this.isLoaded) {
            this.loaded = true
          }
        }
      },

      isAwarded(val) {
        if (val) {
          this.onAwards()
        }
      },
    },

    methods: {
      ...mapMutations([
        'viruses/selectedSet',
      ]),

      ...mapActions([
        'players/awards',
        'viruses/get',
        'viruses/random',
        'actions/add',
      ]),

      image(file) {
        if (file) {
          const image = require.context('../assets/', false, /\.png$/)
          return image('./' + file)
        }

        return null
      },

      onAwardsClick() {
        if ( ! this.isClicked) {
          this['actions/add']('virus-clicked-' + this.game.lap)
          this.clicked = true

          this['viruses/random'](1).then(virus => {
            this['viruses/selectedSet'](virus)

            this['actions/add']('virus-loaded-' + this.game.lap)
            this.loaded = true

            this.onAwardsTimer()
          })
        }
      },

      onAwardsTimer() {
        const timer = setInterval(() => {
          this.time--
          if (this.time == 0) {
            clearInterval(timer)
            this.onAwards()
          }
        }, 1000)
      },

      onAwards() {
        this['players/awards']()
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .awards {
    display: flex;
    padding: 15px 20px 30px;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;

    &-middle {
      text-align: center;
      position: relative;
      z-index: 0;
      height: 200px;

      &__guest {
        position: relative;
        z-index: 1;

        &-loader {
          display: inline-block;
          position: relative;
          z-index: 0;
          width: 200px;
          height: 200px;

          div {
            position: absolute;
            border: 5px solid $avatar-border;
            opacity: 1;
            border-radius: 33% 67% 72% 28% / 56% 67% 33% 44%;
            animation: pulsing 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;

            &:nth-child(2) {
              animation-delay: -0.2s;
            }
          }
        }

        &-avatar {
          position: absolute;
          z-index: 1;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
        }
      }

      &__button {
        position: relative;
        z-index: 1;
        padding: 50px 0;
        height: 200px;
      }

      &__virus {
        position: absolute;
        z-index: 0;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 20px;
        height: 20px;
        cursor: pointer;
        opacity: 0;

        &-image {
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          width: 200px;
          max-height: 200px;
          clip-path: circle(20px at center);
          transition: 0.5s;
          pointer-events: none;
        }
        
        &-hail {
          position: absolute;
          z-index: 0;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          background-color: $virus-bg;
          width: 40px;
          height: 40px;
          border-radius: 40px;
          transition: 0.5s;
          opacity: 0.5;
        }

        &-hail2 {
          position: absolute;
          z-index: 0;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          width: 0;
          height: 0;
          border-radius: 0;
          transition: 0.7s;
          border: 22px solid $virus-bg;
          border-radius: 20px;
          pointer-events: none;
        }

        &-name {
          min-width: 100px;
          position: absolute;
          z-index: 3;
          left: -150%;
          top: 300%;
          height: 40px;
          pointer-events: none;
          transition: 0.5s;
          opacity: 0;
          padding: 0 20px;
          display: flex;
          align-items: center;
          justify-content: center;

          &:before {
            content: '';
            box-sizing: border-box;
            width: 0;
            height: 100%;
            background-color: $virus-bg;
            border: solid $virus-border 4px;
            box-shadow: 0 0 6px $virus-shadow;
            border-radius: 10px;
            position: absolute;
            top: 0;
            left: 0;
            transition: 0.3s;
            z-index: -1;
          }
        }

        &-description {
          position: absolute;
          z-index: 3;
          left: -600%;
          right: -600%;
          top: 400%;
          transition: 0.5s;
          opacity: 0;
        }

        &.loaded {
          opacity: 1;
          z-index: 2;

          .awards-middle__virus {
            &-image {
              clip-path: circle(120px at center);
              z-index: 2;
            }

            &-hail {
              width: 180px;
              height: 180px;
              border-radius: 180px;
            }

            &-hail2 {
              width: 180px;
              height: 180px;
              border-radius: 180px;
              border: 80px solid #fff4e6;
              opacity: 0;
            }

            &-name {
              left: 50%;
              opacity: 1;

              &:before {
                width: 100%;
              }
            }

            &-description {
              top: 650%;
              opacity: 1;
            }
          }
        }
      }

      &__description {
        &.hide {
          display: none;
        }
      }
    }

    &-bottom {
      text-align: center;
    }
  }

  @keyframes pulsing {
    0% {
      top: 100px;
      left: 100px;
      width: 0;
      height: 0;
      opacity: 1;
    }

    100% {
      top: 0px;
      left: 0px;
      width: 200px;
      height: 200px;
      opacity: 0;
    }
  }
</style>