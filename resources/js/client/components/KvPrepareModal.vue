<template>
  <app-modal
    :title="$t('game.modal.prepare.title')"
    :visible="true"
    :closeable="false"
  >
    <app-text
      :text="$t('game.prepare.time', { time: game.config.round_time })"
      bottom-space
    />

    <app-text
      :text="$t('game.prepare.team')"
    />

    <div
      class="players-list"
    >
      <kv-map-players-item
        v-for="player in teamPlayers(me.team_id)"
        :key="player.id"
        :player="player"
        :color="currentTeam.color"
        :full="false"
        :class="{ hide: me.player_id == player.player_id }"
      />
    </div>

    <template slot="footer">
      <app-button
        v-if="isButtonVisible"
        :label="$t('game.prepare.ready')"
        role="primary"
        pulse
        small
        @click="onStart"
      />

      <kv-round-time
        v-else
        start
        :duration="wait"
        :current="wait"
        @complete="onComplete"
      />
    </template>
  </app-modal>
</template>

<script>
  import { mapGetters } from 'vuex'
  import AppModal from './AppModal'
  import AppText from './AppText'
  import AppButton from './AppButton'
  import KvRoundTime from './KvRoundTime'
  import KvMapPlayersItem from './KvMapPlayersItem'
  import Game from '../mixins/game'

  export default {
    name: 'KvPrepareModal',

    mixins: [Game],

    components: {
      AppModal,
      AppText,
      AppButton,
      KvRoundTime,
      KvMapPlayersItem,
    },

    data() {
      return {
        isButtonVisible: false,
        wait: 5,
      }
    },

    computed: {
      ...mapGetters([
        'players/teamPlayers',
        'game/currentTeam',
      ]),

      currentTeam() {
        return this['game/currentTeam']
      },
    },

    methods: {
      teamPlayers(teamId) {
        return this['players/teamPlayers'](teamId)
      },

      onComplete() {
        this.isButtonVisible = true
      },

      onStart() {
        this.$emit('start')
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

    .hide {
      display: none;
    }
  }
</style>