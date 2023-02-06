<template>
  <div class="kv-container map">
    <div
      v-for="team in teams"
      :key="team.team_id"
      class="map-team"
    >
      <div
        class="map-team__top"
        @click="onToggleTeam(team.team_id)"
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

      <div class="map-team__progress">
        <div
          v-for="item in range()"
          :key="item"
          :style="'width: calc(' + width() + '% - 1px); ' + (team.score >= item ? ('background-color: ' + team.color) : '')"
          :class="{ active: team.score >= item }"
          class="map-team__progress-item"
        />
      </div>

      <kv-map-players
        :list="teamPlayers(team.team_id)"
        :color="team.color"
        :full="openTeamId == team.team_id"
        viruses
      />
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import AppText from './AppText'
  import KvMapPlayers from './KvMapPlayers'

  export default {
    name: 'KvMap',

    components: {
      AppText,
      KvMapPlayers,
    },

    props: {
      steps: {
        type: Number,
        default: 50,
      },

      lap: {
        type: Number,
        default: 1,
      },

      teams: {
        type: Array,
        default: [],
      },
    },

    data() {
      return {
        openTeamId: 0,
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
      width() {
        return 100 / this.steps
      },

      range() {
        let items = []
        for (let i = 1; i <= this.steps; i++) {
          items.push(i)
        }
        return items
      },

      teamPlayers(teamId) {
        return this['players/teamPlayers'](teamId)
      },

      onToggleTeam(teamId) {
        if (teamId == this.openTeamId) {
          this.openTeamId = 0
        } else {
          this.openTeamId = teamId
        }
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .map {
    &-team:not(:last-child) {
      margin-bottom: 20px;
    }

    &-team {
      &__top {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
      }

      &__players {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: flex-start;
      }

      &__progress {
        display: flex;
        flex-direction: row;
        justify-content: space-between;

        &-item {
          background: rgba(0, 0, 0, 0.1);
          height: 10px;
          
          &:not(:last-child) {
            margin-right: 1px;
          }
        }
      }
    }
  }
</style>