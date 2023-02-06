<template>
  <div>
    <kv-players-item
      v-for="player in list"
      :key="player.id"
      :player="player"
      :is-me="me.player_id == player.player_id"
      :is-owner="!! me.is_owner"
      :with-add="withAdd"
    />
  </div>
</template>

<script>
  import KvPlayersItem from './KvPlayersItem'
  import Game from '../mixins/game'

  export default {
    name: 'KvPlayers',

    mixins: [Game],

    components: {
      KvPlayersItem,
    },

    props: {
      list: {
        type: Array,
        default: [],
      },

      withAdd: {
        type: Boolean,
        default: false,
      },
    },
  }
</script>
