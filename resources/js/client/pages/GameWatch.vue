<template>
  <div
    class="watch"
  >
    <div class="watch-top">
      <div
        class="watch-top__inner"
      >
        <kv-words-count
          :max="10"
          :confirmed="confirmedCount"
        />

        <kv-round-time
          :start="game.status == 3"
          :duration="game.config.round_time"
          :current="currentTime"
          :danger="10"
          :stop="isStop"
        />
      </div>
    </div>

    <kv-words-list />

    <div class="watch-bottom">
      <app-button
        v-if="isCaptain()"
        :label="$t('game.watch.confirm')"
        :role="buttonActive ? 'primary' : 'disabled'"
        :pulse="buttonActive"
        block
        @click="onConfirm"
      />
    </div>
  </div>
</template>

<script>
  import { mapState, mapGetters, mapMutations, mapActions } from 'vuex'
  import { AppButton, KvWordsCount, KvRoundTime, KvWordsList } from '../components'
  import Game from '../mixins/game'

  export default {
    name: 'GameWatch',

    mixins: [Game],

    components: {
      AppButton,
      KvWordsCount,
      KvRoundTime,
      KvWordsList,
    },

    data() {
      return {
        isStop: false,
      }
    },

    computed: {
      ...mapState({
        words: state => state.words.list,
        time: state => state.game.time,
      }),

      currentTime() {
        const delta = Math.round(((new Date()).getTime() - this.time.getTime()) / 1000)
        return this.game.status == 3 ? (this.game.time - delta) : 0
      },

      confirmedCount() {
        let count = 0
        for (const key in this.words) {
          if (this.isAllApproved(this.words[key])) {
            count++
          }
        }

        return count
      },

      buttonActive() {
        return this.game.status == 4
      },
    },

    watch: {
      game(val) {
        if (val.status == 4) {
          this.isStop = true
        }
      },
    },

    methods: {
      ...mapMutations([
        'messages/set',
      ]),

      ...mapActions([
        'players/confirm',
      ]),

      onConfirm() {
        if (this.buttonActive) {
          this['players/confirm']()
        } else {
          this['messages/set']({
            text: this.$t('game.watch.confirm_disabled'),
            type: 'warning',
          })
        }
      }
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .watch {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;

    &-top {
      padding: 15px 20px 0;

      &__inner {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 15px;
      }
    }

    &-bottom {
      text-align: center;
      padding: 15px 20px 30px;
    }
  }
</style>