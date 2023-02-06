<template>
  <app-modal
    :visible="visible"
    :title="$t('game.main.init_team_title')"
    role="default"
    @close="onClose"
  >
    <app-text
      :text="$t('game.main.init_team_text')"
      align="center"
    />

    <app-text
      :text="currentTeam.name"
      :color="currentTeam.color"
      type="title"
      align="center"
      bottom-space
    />

    <app-text
      :text="$t('game.main.init_team_team')"
      align="center"
    />

    <kv-map-players
      :list="teamPlayers(currentTeam.id)"
    />

    <template slot="footer">
      <app-button
        :label="$t('game.main.got_it')"
        role="primary"
        small
        @click="onClose"
      />
    </template>
  </app-modal>
</template>

<script>
  import { mapGetters, mapMutations, mapActions } from 'vuex'
  import AppModal from './AppModal'
  import AppText from './AppText'
  import AppButton from './AppButton'
  import KvMapPlayers from './KvMapPlayers'
  import Game from '../mixins/game'

  export default {
    name: 'KvMainTeamModal',

    mixins: [Game],

    components: {
      AppModal,
      AppText,
      AppButton,
      KvMapPlayers,
    },

    props: {
      visible: {
        type: Boolean,
        default: false,
      },
    },

    computed: {
      ...mapGetters([
        'players/teamPlayers',
        'game/currentTeam',
      ]),
    },

    methods: {
      ...mapMutations([
        'messages/set',
      ]),

      ...mapActions([
        'viruses/apply',
      ]),

      currentTeam() {
        console.log(123, this['game/currentTeam'])
        return this['game/currentTeam']
      },

      teamPlayers(teamId) {
        return this['players/teamPlayers'](teamId)
      },

      onClose() {
        this.$emit('close')
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

</style>