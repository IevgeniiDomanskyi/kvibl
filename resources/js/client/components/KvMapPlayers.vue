<template>
  <div
    :class="className"
    class="players-list"
  >
    <kv-map-players-item
      v-for="player in list"
      :key="player.id"
      :player="player"
      :color="color"
      :full="full"
      :viruses="viruses"
      :is-me="me.player_id == player.player_id"
      :is-current="player.player_id == currentPlayer.player_id"
      :is-owner="!! me.is_owner"
    />
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import KvMapPlayersItem from './KvMapPlayersItem'
  import Game from '../mixins/game'

  export default {
    name: 'KvMapPlayers',

    mixins: [Game],

    components: {
      KvMapPlayersItem,
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

      viruses: {
        type: Boolean,
        default: false,
      },

      align: {
        type: String,
        default: 'left',
      },
    },

    computed: {
      ...mapGetters([
        'game/currentPlayer',
      ]),

      currentPlayer() {
        return this['game/currentPlayer']
      },

      className() {
        let result = []

        if (this.full) {
          result.push('full')
        }

        if (this.align) {
          result.push(this.align)
        }

        return result.join(' ')
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

    &.full {
      flex-direction: column;
    }

    &.center {
      justify-content: center;
    }

    &.right {
      justify-content: flex-end;
    }
  }
</style>