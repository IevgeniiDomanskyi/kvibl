<template>
  <div
    class="round"
  >
    <div
      class="round-top"
    >
      <kv-words-count
        :max="10"
        :confirmed="confirmedCount"
      />

      <kv-round-time
        start
        :duration="game.config.round_time"
        :current="currentTime"
        :danger="10"
        @complete="onTimerComplete"
      />
    </div>

    <div
      class="kv-container round-middle"
    >
      <kv-round-word
        v-if="currentWord.value"
        :word="currentWord.value"
        :type="currentWord.virus ? currentWord.virus.type : 0"
      />

      <div
        v-if="currentWord.virus"
        class="round-middle__virus"
      >
        <div
          class="round-middle__virus-player"
        >
          <app-avatar
            :image="currentWord.virus_player.avatar"
            size="fade"
          />

          <app-text
            :text="currentWord.virus_player.name"
            type="title"
            align="center"
            class="round-middle__virus-player_name"
          />
        </div>

        <div class="round-middle__virus-icon">
          <img
            :src="image(currentWord.virus.image)"
          />
        </div>
      </div>
    </div>

    <div
      class="round-bottom"
    >
      <app-button
        icon="fas fa-forward"
        role="default"
        round
        large
        @click="onSkip"
      />

      <app-button
        icon="fas fa-check"
        role="success"
        round
        large
        @click="onApprove"
      />
    </div>
  </div>
</template>

<script>
  import { mapState, mapGetters, mapMutations, mapActions } from 'vuex'
  import { AppButton, AppAvatar, AppText, KvRoundTime, KvWordsCount, KvRoundWord } from '../components'
  import Game from '../mixins/game'

  export default {
    name: 'GameRound',

    mixins: [Game],

    components: {
      AppButton,
      AppAvatar,
      AppText,
      KvRoundTime,
      KvWordsCount,
      KvRoundWord,
    },

    data() {
      return {
        localWords: [],
      }
    },

    computed: {
      ...mapState({
        words: state => state.words.list,
      }),

      currentTime() {
        return this.game.time
      },

      currentWord() {
        for (const key in this.localWords) {
          if (this.localWords[key].is_current) {
            return this.words[key]
          }
        }

        return {}
      },

      confirmedCount() {
        let count = 0
        for (const key in this.localWords) {
          if (this.localWords[key].is_approved) {
            count++
          }
        }

        return count
      },
    },

    created() {
      if ( ! this.words.length) {
        this['words/get']().then(words => {
          this.initWords(words)
        })
      } else {
        this.initWords(this.words)
      }
    },

    methods: {
      ...mapMutations([
        'words/currentSet',
      ]),

      ...mapActions([
        'words/get',
        'words/view',
        'words/approve',
        'players/finish',
      ]),

      image(file) {
        if (file) {
          const image = require.context('../assets/', false, /\.png$/)
          return image('./' + file)
        }

        return null
      },

      initWords(words) {
        this.localWords = []
        for (const key in words) {
          this.localWords.push({
            is_approved: this.isOwnerApproved(words[key]),
            is_current: words[key].is_current,
          })
        }

        if (this.confirmedCount == 10 || this.currentTime <= 0) {
          this.onFinish()
        }
      },

      nextWord() {
        let next = false
        let nextIndex = null

        for (const key in this.localWords) {
          if (next && nextIndex == null && ! this.localWords[key].is_approved) {
            nextIndex = key
          }

          if (this.localWords[key].is_current) {
            next = true
          }
        }

        if (nextIndex == null) {
          for (const key in this.localWords) {
            if (nextIndex == null && ! this.localWords[key].is_approved) {
              nextIndex = key
            }
          }
        }

        if (nextIndex != null && this.words[nextIndex]) {
          this['words/currentSet'](this.words[nextIndex])
          this['words/view'](this.words[nextIndex].id)
          this.currentSet(nextIndex)
        } else {
          this.onFinish()
        }
      },

      currentSet(index) {
        for (const key in this.localWords) {
          if (index == key) {
            this.localWords[key].is_current = true
          } else {
            this.localWords[key].is_current = false
          }
        }
      },

      approvedSet(id) {
        for (const key in this.words) {
          if (this.words[key].id == id) {
            this.localWords[key].is_approved = true
          }
        }
      },

      onSkip() {
        this.nextWord()
      },

      onApprove() {
        this['words/approve'](this.currentWord.id)
        this.approvedSet(this.currentWord.id)
        this.nextWord()
      },

      onTimerComplete() {
        this.onFinish()
      },

      onFinish() {
        this['players/finish']()
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .round {
    display: flex;
    flex: 1;
    padding: 15px 20px 30px;
    flex-direction: column;
    justify-content: space-between;

    &-top {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      align-items: center;
    }

    &-middle {
      height: 50%;
      display: flex;
      flex-direction: row;
      justify-content: center;
      align-items: center;
      position: relative;
      z-index: 0;

      &__virus-icon {
        display: block;
        width: 60px;
        height: 60px;
        position: absolute;
        z-index: 1;
        bottom: -20px;
        left: -20px;

        img {
          max-width: 100%;
          max-height: 100%;
        }
      }

      &__virus-player {
        display: inline-block;
        position: absolute;
        z-index: 2;
        left: 50%;
        top: 50%;
        margin: -50px 0 0 -50px;
        animation-name: loader-1;
        animation-duration: 3.5s;
        animation-timing-function: cubic-bezier(0.075, 0.820, 0.165, 1.000);
        animation-fill-mode: forwards;

        &_name {
          position: absolute;
          z-index: 3;
          top: 0;
          width: 100%;
          height: 100%;
          display: flex;
          flex-direction: column;
          justify-content: center;
        }
      }
    }

    &-bottom {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
    }
  }

  @-webkit-keyframes loader-1 {
    0%   { -webkit-transform: translate3d(0, 0, 0) scale(0); opacity: 1; }
    100% { -webkit-transform: translate3d(0, 0, 0) scale(1.5); opacity: 0; }
  }

  @keyframes loader-1 {
    0%   { transform: translate3d(0, 0, 0) scale(0); opacity: 1; }
    100% { transform: translate3d(0, 0, 0) scale(1.5); opacity: 0; }
  }
</style>