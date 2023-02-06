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
      :text="myTeam.name"
      :color="myTeam.color"
      type="title"
      align="center"
      bottom-space
    />

    <app-text
      :text="$t('game.main.init_team_team')"
      align="center"
    />

    <kv-map-players
      :list="teamPlayers(myTeam.team_id)"
      align="center"
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
    name: 'KvMainInitModal',

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
        'teams/byId',
      ]),

      myTeam() {
        if (this.me.team_id) {
          return this['teams/byId'](this.me.team_id)
        }

        return {}
      },
    },

    methods: {
      teamPlayers(teamId) {
        return this['players/teamPlayers'](teamId).filter(item => {
          return item.player_id != this.me.player_id
        })
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