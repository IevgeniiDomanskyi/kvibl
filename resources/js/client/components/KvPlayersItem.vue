<template>
  <div class="players-item">
    <div
      class="players-item__name"
    >
      <app-avatar
        :image="player.avatar"
        size="medium"
      />

      <app-text
        :text="player.name"
        size="medium"
        class="players-item__name-text"
      />
    </div>

    <div
      class="players-item__action"
    >
      <app-button
        v-if="isOwner && ! isMe && ! withAdd"
        icon="fas fa-times"
        round
        small
        role="danger"
        @click="onPlayerRemove"
      />

      <app-button
        v-if="isOwner && ! isMe && withAdd"
        :role="player.status == 1 ? 'success' : 'disabled'"
        :active="player.status != 1"
        icon="fas fa-plus"
        round
        small
        @click="onPlayerAdd"
      />
    </div>

    <app-modal-confirm
      v-if="isOwner && ! isMe && ! withAdd"
      :title="$t('game.modal.remove_player.title')"
      :text="$t('game.modal.remove_player.text', { name: player.name })"
      :visible="isRemoveModalVisible"
      @close="onRemoveClose"
      @confirm="onRemoveConfirm"
    />

    <kv-players-add-modal
      v-if="isOwner && ! isMe && withAdd"
      :visible="isAddModalVisible"
      @close="onAddClose"
      @confirm="onAddConfirm"
    />
  </div>
</template>

<script>
  import { mapMutations, mapActions } from 'vuex'
  import AppModalConfirm from './AppModalConfirm'
  import AppAvatar from './AppAvatar'
  import AppText from './AppText'
  import AppButton from './AppButton'
  import KvPlayersAddModal from './KvPlayersAddModal'

  export default {
    name: 'KvPlayersItem',

    components: {
      AppModalConfirm,
      AppAvatar,
      AppText,
      AppButton,
      KvPlayersAddModal,
    },

    props: {
      player: {
        type: Object,
        required: true,
      },

      isMe: {
        type: Boolean,
        default: false,
      },

      isOwner: {
        type: Boolean,
        default: false,
      },

      withAdd: {
        type: Boolean,
        default: false,
      },
    },

    data() {
      return {
        isRemoveModalVisible: false,
        isAddModalVisible: false,
      }
    },

    methods: {
      ...mapMutations([
        'messages/set',
      ]),

      ...mapActions([
        'players/add',
        'players/remove',
      ]),

      onPlayerRemove() {
        this.isRemoveModalVisible = true
      },

      onRemoveClose() {
        this.isRemoveModalVisible = false
      },

      onRemoveConfirm() {
        this.isRemoveModalVisible = false
        this['players/remove'](this.player.hash)
      },

      onPlayerAdd() {
        if (this.player.status == 1) {
          this.isAddModalVisible = true
        } else {
          this['messages/set']({
            text: this.$t('game.guests.status'),
            type: 'warning',
          })
        }
      },

      onAddClose() {
        this.isAddModalVisible = false
      },

      onAddConfirm(team_id) {
        this.isAddModalVisible = false
        this['players/add']({
          hash: this.player.hash,
          team_id,
        })
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .players-item {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 5px;

    &__name {
      display: flex;
      flex-direction: row;
      align-items: center;

      &-text {
        margin-left: 10px;
      }
    }

    &__icon {
      display: inline-block;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      background: $danger;
      border: solid 3px $text-border;
      box-shadow: 0 0 4px $text-shadow;

      &.online {
        background: $success;
      }
    }
  }
</style>