<template>
  <div
    class="teams"
  >
    <div class="teams-top">
      <div
        v-for="team in teams"
        :key="team.team_id"
        class="teams-item"
        :style="'border-color: ' + team.color"
      >
        <div
          class="teams-item__name"
          :style="'background-color: ' + team.color"
        >
          {{ team.name }}
        </div>

        <div
          class="teams-item__players"
        >
          <div
            v-for="player in teamPlayers(team.team_id)"
            :key="player.player_id"
            class="teams-item__players-item"
          >
            <div
              class="teams-item__players-item__name"
            >
              <div
                class="teams-item__players-item__avatar"
              >
                <app-avatar
                  :imagve="player.avatar"
                  size="small"
                />

                <i
                  v-if="player.is_captain"
                  class="fas fa-crown teams-item__players-item__captain"
                />
              </div>

              <p class="text">
                <b>{{ player.name }}</b>
              </p>
            </div>

            <div
              class="teams-item__players-item__status"
            >
              <p
                v-if="me.player_id == player.player_id"
                class="text"
              >
                {{ $t('game.players.you') }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapState, mapGetters, mapMutations, mapActions } from 'vuex'
  import { AppButton, AppAvatar } from '../components'
  import Game from '../mixins/game'

  export default {
    name: 'GameTeams',

    mixins: [Game],

    components: {
      AppButton,
      AppAvatar,
    },

    computed: {
      ...mapState({
        teams: state => state.teams.list,
      }),

      ...mapGetters([
        'players/teamPlayers',
      ]),
    },

    methods: {
      teamPlayers(team_id) {
        return this['players/teamPlayers'](team_id)
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .teams {
    height: 100%;

    &-top {
      height: 80%;

      .teams-item {
        border-radius: 4px;
        border: solid 1px;
        margin-bottom: 5%;

        &__name {
          padding: 1% 3%;
          font-size: 18px;
          color: $white;
        }

        &__players {
          padding: 3%;

          &-item {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 5px;

            &__name {
              display: flex;
              flex-direction: row;
              align-items: center;

              .text {
                margin: 0 0 0 10px;
              }
            }

            &__avatar {
              position: relative;
              z-index: 0;
            }

            &__captain {
              color: $gold;
              font-size: 13px;
              position: absolute;
              z-index: 1;
              top: 17px;
              left: 17px;
              text-shadow: 0 0 2px rgba(0, 0, 0, 1);
            }

            &__status {
              .text {
                margin: 0;
              }
            }
          }
        }
      }
    }

    &-bottom {
      height: 20%;
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
    }
  }
</style>