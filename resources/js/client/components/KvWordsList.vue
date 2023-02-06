<template>
  <div class="words-list">
    <div class="watch-list__inner">
      <kv-words-item
        v-for="(word, index) in words"
        :key="word.id"
        :word="word"
        :position="index + 1"
        :status="game.status"
      />
    </div>
  </div>
</template>

<script>
  import { mapState, mapActions } from 'vuex'
  import KvWordsItem from './KvWordsItem'
  import Game from '../mixins/game'

  export default {
    name: 'KvWordsList',

    mixins: [Game],

    components: {
      KvWordsItem,
    },

    computed: {
      ...mapState({
        words: state => state.words.list,
      }),
    },

    created() {
      if ( ! this.words.length) {
        this['words/get']()
      }
    },

    methods: {
      ...mapActions([
        'words/get',
      ]),
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .words-list {
    overflow: auto;
    padding: 0 20px;
  }
</style>