<template>
  <div
    class="lobby"
  >
    <kv-lobby-code
      :code="game.code"
    />

    <kv-lobby-loader
      :size="100"
      :border="5"
      :text="$t('game.lobby.wait')"
    />

    <div class="lobby-bottom">
      <div
        v-if="isNameEmpty"
      >
        <app-text
          :text="$t('game.lobby.profile_text')"
          align="center"
          bottom-space
        />

        <app-button
          :label="$t('game.lobby.profile')"
          role="primary"
          pulse
          @click="onProfile"
        />
      </div>

      <div
        v-else
      >
        <div v-if="me.is_owner">
          <app-text
            :text="$t('game.lobby.dereban_text')"
            align="center"
            type="title"
          />

          <kv-lobby-settings-teams
            :min="2"
            :max="5"
            :available="availableTeams"
            :active="teamsCount"
            @click="onTeams"
          />

          <app-button
            :label="$t('game.lobby.dereban')"
            :role="(playersCount >= 4 ? 'primary' : 'disabled')"
            :pulse="playersCount >= 4"
            block
            @click="onDereban"
          />
        </div>

        <div v-else>
          <div
            v-if="me.status == 2"
          >
            <app-text
              :text="$t('game.lobby.player_text')"
              align="center"
              bottom-space
            />

            <app-button
              :label="$t('game.lobby.player')"
              role="primary"
              block
              @click="onPlayer"
            />
          </div>

          <div
            v-else
          >
            <app-text
              :text="$t('game.lobby.wait_text')"
              align="center"
              bottom-space
            />

            <app-button
              :label="$t('game.lobby.spectator')"
              role="secondary"
              block
              @click="onSpectator"
            />
          </div>
        </div>
      </div>
    </div>

    <!-- <kv-profile-empty-modal
      :visible="isProfileEmptyModalVisible"
      @close="onProfileEmptyModalClose"
    /> -->
  </div>
</template>

<script>
  import { mapMutations, mapActions } from 'vuex'
  import { AppButton, AppText, KvProfileEmptyModal, KvLobbyCode, KvLobbyLoader, KvLobbySettingsTeams } from '../components'
  import tabs from '../constants/tabs'
  import Game from '../mixins/game'

  export default {
    name: 'GameLobby',

    mixins: [Game],

    components: {
      AppButton,
      AppText,
      KvProfileEmptyModal,
      KvLobbyCode,
      KvLobbyLoader,
      KvLobbySettingsTeams,
    },

    data() {
      return {
        teamsCount: 2,
        isProfileEmptyModal: true,
      }
    },

    computed: {
      playersCount() {
        return this.players.filter(item => {
          return item.status == 1
        }).length
      },

      availableTeams() {
        return Math.floor(this.playersCount / 2)
      },

      isNameEmpty() {
        return this.me.player_id && this.me.name == '' && this.me.lastname == ''
      },

      isProfileEmptyModalVisible() {
        return (this.user.name == '' || this.user.avatar == '') && this.isProfileEmptyModal
      },
    },

    methods: {
      ...mapMutations([
        'messages/set',
      ]),

      ...mapActions([
        'game/start',
        'players/profile',
        'tabs/set',
      ]),

      onTeams(count) {
        if (count == 0) {
          this['messages/set']({
            text: this.$t('game.lobby.teams_count'),
            type: 'warning',
          })
        } else {
          this.teamsCount = count
        }
      },

      onDereban() {
        if (this.playersCount >= 4) {
          this['game/start']({
            teams: this.teamsCount,
          })
        } else {
          this['messages/set']({
            text: this.$t('game.lobby.players_count'),
            type: 'warning',
          })
        }
      },

      onSpectator() {
        this['players/profile']({
          status: 2,
        })
      },

      onPlayer() {
        this['players/profile']({
          name: this.me.name,
          status: 1,
        })
      },

      onProfile() {
        this['tabs/set'](tabs.PROFILE)
      },

      onProfileEmptyModalClose() {
        this.isProfileEmptyModal = false
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .lobby {
    height: 100%;
    padding: 15px 20px 30px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;

    .lobby-bottom {
      text-align: center;
    }
  }
</style>