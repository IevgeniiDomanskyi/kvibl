<template>
  <div
    :class="{ full: full }"
    class="players-item"
  >
    <div
      :class="{ current: isCurrent }"
      class="players-item__avatar"
      @click="onClick"
    >
      <app-avatar
        :image="player.avatar"
        :color="color"
        size="medium"
      />

      <i
        v-if="player.is_captain"
        class="fas fa-crown"
      />
    </div>

    <div
      v-if="full"
      class="players-item__name"
    >
      <app-text
        :text="player.name"
        size="medium"
      />

      <div class="players-item__name-actions">
        <app-text
          :text="player.score.toString()"
          size="medium"
        />

        <app-button
          v-if="isOwner"
          :class="{ hidden: isMe }"
          icon="fas fa-times"
          round
          small
          role="danger"
          class="players-item__name-actions_button"
          @click="onPlayerRemove"
        />
      </div>
    </div>

    <app-modal-confirm
      v-if="isOwner && ! isMe"
      :title="$t('game.modal.remove_player.title')"
      :text="$t('game.modal.remove_player.text' + (willGameClose ? '_close' : ''), { name: player.name })"
      :visible="isRemoveModalVisible"
      @close="onRemoveClose"
      @confirm="onRemoveConfirm"
    />

    <kv-main-viruses-modal
      :visible="isVirusesModalVisible"
      :player="player"
      @close="onVirusesModalClose"
    />
  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  import AppAvatar from './AppAvatar'
  import AppText from './AppText'
  import AppButton from './AppButton'
  import AppModalConfirm from './AppModalConfirm'
  import KvMainVirusesModal from './KvMainVirusesModal'
  import Game from '../mixins/game'

  export default {
    name: 'KvMapPlayersItem',

    mixins: [Game],

    components: {
      AppAvatar,
      AppText,
      AppButton,
      AppModalConfirm,
      KvMainVirusesModal,
    },

    props: {
      player: {
        type: Object,
        required: true,
      },

      color: {
        type: String,
        default: null,
      },

      full: {
        type: Boolean,
        default: false,
      },

      viruses: {
        type: Boolean,
        default: false,
      },

      isMe: {
        type: Boolean,
        default: false,
      },

      isCurrent: {
        type: Boolean,
        default: false,
      },

      isOwner: {
        type: Boolean,
        default: false,
      },
    },

    data() {
      return {
        isRemoveModalVisible: false,
        isVirusesModalVisible: false,
      }
    },

    computed: {
      ...mapGetters([
        'players/teamPlayers',
      ]),

      willGameClose() {
        const teamPlayers = this['players/teamPlayers'](this.player.team_id)
        return teamPlayers.length == 2
      },
    },

    methods: {
      ...mapActions([
        'players/remove',
      ]),

      onClick() {
        if (this.viruses) {
          if (this.player.team_id != this.me.team_id) {
            this.isVirusesModalVisible = true
          }
        }
      },

      onVirusesModalClose() {
        this.isVirusesModalVisible = false
      },

      onPlayerRemove() {
        if (this.isOwner) {
          this.isRemoveModalVisible = true
        }
      },

      onRemoveClose() {
        this.isRemoveModalVisible = false
      },

      onRemoveConfirm() {
        this.isRemoveModalVisible = false
        this['players/remove'](this.player.hash)
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .players-item {
    position: relative;
    z-index: 0;
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    align-items: center;

    &:not(:last-child) {
      margin-right: 10px;
    }

    &__avatar {
      position: relative;
      z-index: 0;

      i {
        position: absolute;
        z-index: 1;
        right: 0;
        bottom: 0;
        color: $gold;
        font-size: 15px;
        text-shadow: 0 0 2px rgba(0, 0, 0, 1);
      }

      &.current {
        animation: pulse 0.5s infinite alternate;
      }
    }

    &__name {
      flex: 1;
      margin-left: 10px;
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      align-items: center;

      &-actions {
        display: flex;
        flex-direction: row;
        justify-content: flex-end;
        align-items: center;

        &_button {
          margin-left: 10px;

          &.hidden {
            opacity: 0;
          }
        }
      }
    }

    &__status {
      color: $white;
    }

    &.full {
      margin: 0;

      &:not(:last-child) {
        margin-bottom: 10px;
      }
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