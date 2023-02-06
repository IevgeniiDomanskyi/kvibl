<template>
  <div
    class="players"
  >
    <div
      class="players-inner"
    >
      <div
        v-if="confirmed.length"
        class="kv-container players-box"
      >
        <div class="players-box__header">
          <app-text
            :text="$t('game.players.all')"
            type="title"
          />

          <app-text
            :text="confirmed.length.toString()"
            type="title"
          />
        </div>

        <kv-players
          :list="confirmed"
        />
      </div>

      <div
        v-if="spectators.length"
        class="kv-container players-box"
      >
        <div class="players-box__header">
          <app-text
            :text="$t('game.players.spectators')"
            type="title"
          />

          <app-text
            :text="spectators.length.toString()"
            type="title"
          />
        </div>

        <kv-players
          :list="spectators"
        />
      </div>
    </div>
  </div>
</template>

<script>
  import { AppText, KvPlayers } from '../components'
  import Game from '../mixins/game'

  export default {
    name: 'GamePlayers',

    mixins: [Game],

    components: {
      AppText,
      KvPlayers,
    },

    computed: {
      spectators() {
        return this.players.filter(item => {
          return item.status != 1
        })
      },

      confirmed() {
        return this.players.filter(item => {
          return item.status == 1
        })
      }
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .players {
    height: 100%;
    padding: 15px 20px 30px;
    overflow: auto;

    &-box__header {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      align-items: center;

      .text {
        margin: 0;
      }
    }

    .players-box + .players-box {
      margin-top: 40px;
    }
  }
</style>