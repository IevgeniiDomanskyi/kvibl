<template>
  <div class="next-player">
    <div
      v-if="me.player_id == currentPlayer.player_id"
      class="next-player__button"
    >
      <app-text
        :text="$t('game.message.next_you')"
        align="center"
        bottom-space
      />

      <app-button
        :label="$t('game.main.start')"
        pulse
        role="primary"
        block
        @click="onStartRound"
      />
    </div>

    <template
      v-else
    >
      <app-avatar
        :image="currentPlayer.avatar"
        :color="currentTeam.color"
        :class="{ pulse: currentTeam.team_id == me.team_id }"
        size="fade"
      />

      <div class="next-player__info">
        <app-text
          :text="currentPlayer.name"
          :color="currentTeam.color"
          type="title"
          align="center"
        />

        <app-text
          :text="$t('game.message.from_team' + (currentTeam.team_id == me.team_id ? '_yours' : ''))"
          align="center"
        />

        <app-text
          :text="currentTeam.name"
          :color="currentTeam.color"
          type="title"
          align="center"
        />

        <app-text
          :text="$t('game.message.prepare_to')"
          align="center"
        />
      </div>
    </template>
  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  import AppButton from './AppButton'
  import AppAvatar from './AppAvatar'
  import AppText from './AppText'
  import Game from '../mixins/game'

  export default {
    name: 'KvMainNextPlayer',

    mixins: [Game],

    components: {
      AppButton,
      AppAvatar,
      AppText,
    },

    computed: {
      ...mapGetters([
        'game/currentTeam',
        'game/currentPlayer',
      ]),

      currentTeam() {
        return this['game/currentTeam']
      },

      currentPlayer() {
        return this['game/currentPlayer']
      },
    },

    methods: {
      ...mapActions([
        'players/prepare',
      ]),

      onStartRound() {
        this['players/prepare']()
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .next-player {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    padding-top: 15px;

    &__button {
      width: 100%;
      text-align: center;
    }

    &__info {
      text-align: center;
      color: $white;

      &-name {
        font-size: 18px;
        font-weight: 600;
      }

      &-team {
        font-size: 18px;
        font-weight: 600;
      }
    }

    .pulse {
      animation: pulse 0.5s infinite alternate;
    }
  }

  @keyframes pulse
  {
    0% {
      transform: scale(1, 1);
    }
    100% {
      transform: scale(1.1, 1.1);
    }
  }
</style>