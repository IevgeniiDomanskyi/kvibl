<template>
  <div
    :class="{ ready: isReady }"
    class="main"
  >
    <div
      class="main-map"
    >
      <kv-map
        :steps="game.config.win_score"
        :lap="game.lap"
        :teams="teams"
      />
    </div>

    <div
      class="main-bottom"
    >
      <kv-main-next-player />
    </div>

    <kv-main-init-modal
      :visible="isInitModalVisible"
      @close="onInitModalClose"
    />

    <kv-main-captain-modal
      :visible="isCaptainModalVisible"
      @close="onCaptainModalClose"
    />
  </div>
</template>

<script>
  import { mapState, mapGetters, mapMutations, mapActions } from 'vuex'
  import tabs from '../constants/tabs'
  import { KvMap, KvMainNextPlayer, KvMainInitModal, KvMainCaptainModal } from '../components'
  import Game from '../mixins/game'

  export default {
    name: 'GameMain',

    mixins: [Game],

    components: {
      KvMap,
      KvMainNextPlayer,
      KvMainInitModal,
      KvMainCaptainModal,
    },

    data: () => ({
      readyTimer: 0,
      isReady: false,
    }),

    computed: {
      ...mapGetters([
        'game/currentTeam',
        'game/currentPlayer',
        'players/teamPlayers',
        'actions/byCode',
      ]),

      currentTeam() {
        return this['game/currentTeam']
      },

      currentPlayer() {
        return this['game/currentPlayer']
      },

      isInitModalVisible() {
        return !!  (this.isReady && this.actionsIsLoaded && this.me.team_id && ! this['actions/byCode']('init-modal'))
      },

      isCaptainModalVisible() {
        return !! (this.isReady && this.actionsIsLoaded && this.me.is_captain && this.me.team_id && this['actions/byCode']('init-modal') && ! this['actions/byCode']('captain-modal'))
      },
    },

    mounted() {
      this.$nextTick(() => {
        this.isReady = true
      })
    },

    methods: {
      ...mapActions([
        'tabs/set',
        'actions/add',
      ]),

      teamPlayers(team_id) {
        return this['players/teamPlayers'](team_id)
      },

      onInitModalClose() {
        this['actions/add']('init-modal')
      },

      onCaptainModalClose() {
        this['actions/add']('captain-modal')
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .main {
    opacity: 0;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: all 0.3s linear 0s;

    &.ready {
      opacity: 1;
    }

    &-map {
      padding: 15px 20px 15px;
      overflow: auto;
    }

    &-bottom {
      padding: 0 20px 30px;
    }
  }
</style>