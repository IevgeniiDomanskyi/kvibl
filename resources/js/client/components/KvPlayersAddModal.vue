<template>
  <app-modal
    :visible="visible"
    :title="$t('game.guests.title')"
    role="default"
    @close="onClose"
  >
    <div
      v-for="team in teams"
      :key="team.team_id"
      class="guests-team"
      @click="onTeamClick(team.team_id)"
    >
      <div
        :class="{ selected: team.team_id == selectedTeamId }"
        class="guests-team__item"
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
    </div>

    <template slot="footer">
      <app-button
        :label="$t('game.guests.add')"
        :role="selectedTeamId > 0 ? 'primary' : 'disabled'"
        :pulse="selectedTeamId > 0"
        small
        @click="onConfirm"
      />
    </template>
  </app-modal>
</template>

<script>
  import { mapGetters, mapMutations, mapActions } from 'vuex'
  import AppModal from './AppModal'
  import AppText from './AppText'
  import AppButton from './AppButton'
  import Game from '../mixins/game'

  export default {
    name: 'KvPlayersAddModal',

    mixins: [Game],

    components: {
      AppModal,
      AppText,
      AppButton,
    },

    props: {
      visible: {
        type: Boolean,
        default: false,
      },
    },

    data() {
      return {
        selectedTeamId: 0,
      }
    },

    methods: {
      ...mapMutations([
        'messages/set',
      ]),

      onTeamClick(team_id) {
        if (this.selectedTeamId == team_id) {
          this.selectedTeamId = 0
        } else {
          this.selectedTeamId = team_id
        }
      },

      onConfirm() {
        if (this.selectedTeamId > 0) {
          this.$emit('confirm', this.selectedTeamId)
        } else {
          this['messages/set']({
            text: this.$t('game.guests.empty_team'),
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

  .guests-team__item {
    display: flex;
    flex-direction: row;
    justify-content: space-between;

    margin-bottom: 2px;
    padding: 5px 10px;
    margin: 0 -10px;
    border-radius: 10px;
    border: solid transparent 1px;
    cursor: pointer;

    &.selected {
      background: $warning-second;
      border-color: $warning;
      box-shadow: inset 0 1px 2px $virus-shadow; 
    }
  }
</style>