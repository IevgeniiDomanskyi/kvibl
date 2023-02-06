<template>
  <div
    v-show="game.code"
    class="guests"
  >
    <div class="guests-top">
      <kv-lobby-code
        :code="game.code"
      />
    </div>

    <div class="guests-bottom">
      <div
        v-if="spectators.length"
        class="kv-container guests-bottom_box"
      >
        <div class="guests-bottom__box-header">
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
          withAdd
        />
      </div>
    </div>
  </div>
</template>

<script>
  import { mapMutations, mapActions } from 'vuex'
  import { AppText, KvLobbyCode, KvPlayers } from '../components'
  import tabs from '../constants/tabs'
  import Game from '../mixins/game'

  export default {
    name: 'GameGuests',

    mixins: [Game],

    components: {
      AppText,
      KvLobbyCode,
      KvPlayers,
    },

    computed: {
      spectators() {
        return this.players.filter(item => {
          return item.team_id == 0
        })
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .guests {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;

    &-top {
      padding: 15px 20px 0;
    }

    &-bottom {
      padding: 30px 20px 30px;
      overflow: auto;

      &__box {
        &-header {
          display: flex;
          flex-direction: row;
          justify-content: space-between;
        }
      }
    }
  }
</style>