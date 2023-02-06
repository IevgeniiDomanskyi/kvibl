<template>
  <div
    class="prepare"
  >
    <div class="prepare-top">
      <kv-words-count
        :max="10"
        :confirmed="0"
      />

      <kv-round-time
        :duration="game.config.round_time"
        :current="currentTime"
        :danger="10"
      />
    </div>

    <div
      class="prepare-bottom"
    >
      <app-button
        icon="fas fa-forward"
        role="default"
        round
        large
      />

      <app-button
        icon="fas fa-check"
        role="success"
        round
        large
      />
    </div>

    <kv-prepare-modal
      @start="onStart"
    />
  </div>
</template>

<script>
  import { mapState, mapGetters, mapMutations, mapActions } from 'vuex'
  import { tab } from '../store/tabs'
  import { AppButton, KvWordsCount, KvRoundTime, KvPrepareModal } from '../components'
  import Game from '../mixins/game'

  export default {
    name: 'GamePrepare',

    mixins: [Game],

    components: {
      AppButton,
      KvWordsCount,
      KvRoundTime,
      KvPrepareModal,
    },

    computed: {
      ...mapState({
        time: state => state.game.time,
      }),

      currentTime() {
        return this.game.config.round_time
      },
    },

    methods: {
      ...mapMutations([
        'words/wordsSet',
      ]),

      ...mapActions([
        'words/get',
      ]),

      onStart() {
        this['words/wordsSet']([])
        this['words/get']()
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .prepare {
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

    &-bottom {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
    }
  }
</style>