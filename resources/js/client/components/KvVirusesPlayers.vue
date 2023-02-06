<template>
  <div
    :class="{ 'players-list__full': full }"
    class="players-list"
  >
    <kv-viruses-players-item
      v-for="player in list"
      :key="player.player_id"
      :player="player"
      :color="color"
      :full="full"
      :is-selected="player.player_id == selectedId"
      :is-current="player.player_id == currentPlayer.player_id"
      @click="onClick"
    />
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import KvVirusesPlayersItem from './KvVirusesPlayersItem'
  import Game from '../mixins/game'

  export default {
    name: 'KvvirusesPlayers',

    mixins: [Game],

    components: {
      KvVirusesPlayersItem,
    },

    props: {
      list: {
        type: Array,
        default: [],
      },

      color: {
        type: String,
        default: null,
      },

      full: {
        type: Boolean,
        default: false,
      },

      selectedId: {
        type: Number,
        default: null,
      },
    },

    computed: {
      ...mapGetters([
        'game/currentPlayer',
      ]),

      currentPlayer() {
        return this['game/currentPlayer']
      },
    },

    methods: {
      onClick(player_id) {
        this.$emit('click', player_id)
      },
    },
  }
</script>

<style lang="scss" scoped>
  .players-list {
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    margin: 0 -10px;
    padding: 10px;
    overflow: auto;

    &__full {
      flex-direction: column;
    }
  }
</style>