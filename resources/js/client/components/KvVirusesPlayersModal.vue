<template>
  <app-modal
    :visible="visible"
    :title="$t('game.viruses.choose_player_title')"
    role="default"
    @close="onClose"
  >
    <div
      v-for="team in enemyTeams"
      :key="team.team_id"
      class="viruses-team"
    >
      <div
        v-for="team in enemyTeams"
        :key="team.team_id"
        class="viruses-team__head"
      >
        <app-text
          :text="team.name"
          :color="team.color"
          type="title"
        />

        <app-text
          :text="team.score.toString()"
          :color="team.color"
          type="title"
        />
      </div>

      <div
        class="viruses-team__players"
      >
        <kv-viruses-players
          :list="teamPlayers(team.team_id)"
          :color="team.color"
          :selectedId="selectedPlayerId"
          full
          @click="onPlayerClick"
        />
      </div>
    </div>

    <template slot="footer">
      <div class="virus">
        <div>
          <div class="virus-info">
            <img :src="image(virus.image)" />
          </div>
        </div>

        <app-button
          :label="$t('game.viruses.infect')"
          :role="selectedPlayerId > 0 ? 'primary' : 'disabled'"
          :pulse="selectedPlayerId > 0"
          small
          @click="onInfect"
        />
      </div>
    </template>
  </app-modal>
</template>

<script>
  import { mapGetters, mapMutations, mapActions } from 'vuex'
  import AppModal from './AppModal'
  import AppText from './AppText'
  import AppButton from './AppButton'
  import KvVirusesPlayers from './KvVirusesPlayers'
  import Game from '../mixins/game'

  export default {
    name: 'KvVirusesPlayersModal',

    mixins: [Game],

    components: {
      AppModal,
      AppText,
      AppButton,
      KvVirusesPlayers,
    },

    props: {
      visible: {
        type: Boolean,
        default: false,
      },

      virus: {
        type: Object,
        required: true,
      },
    },

    data() {
      return {
        selectedPlayerId: 0,
      }
    },

    computed: {
      ...mapGetters([
        'players/teamPlayers',
      ]),

      enemyTeams() {
        let result = []
        for (const team of this.teams) {
          if (team.team_id != this.me.team_id) {
            result.push(team)
          }
        }

        return result
      },
    },

    methods: {
      ...mapMutations([
        'messages/set',
      ]),

      ...mapActions([
        'viruses/apply',
      ]),

      image(file) {
        if (file) {
          const image = require.context('../assets/', false, /\.png$/)
          return image('./' + file)
        }

        return null
      },

      teamPlayers(teamId) {
        return this['players/teamPlayers'](teamId)
      },

      onPlayerClick(player_id) {
        if (this.selectedPlayerId == player_id) {
          this.selectedPlayerId = 0
        } else {
          this.selectedPlayerId = player_id
        }
      },

      onInfect() {
        if (this.selectedPlayerId > 0) {
          this['viruses/apply']({
            virus_id: this.virus.id,
            id: this.selectedPlayerId,
          }).then(data => {
            this['messages/set']({
              text: this.$t('game.viruses.apply'),
              type: 'success',
            })
            
            this.onClose()
          })
        } else {
          this['messages/set']({
            text: this.$t('game.viruses.empty_player'),
            type: 'warning',
          })
        }
      },

      onClose() {
        this.$emit('close')
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .viruses-team__head {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
  }

  .virus {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;

    &-info {
      display: flex;
      flex-direction: row;
      justify-content: center;
      align-items: center;
      width: 70px;
      height: 70px;
      position: absolute;
      z-index: 2;
      left: -10px;
      bottom: -10px;
      border-radius: 50%;
      background: $virus-bg;
      border: solid $virus-border 5px;
      box-shadow: 0 0 8px $virus-shadow;

      img {
        max-width: 85px;
        max-height: 85px;
      }
    }
  }
</style>