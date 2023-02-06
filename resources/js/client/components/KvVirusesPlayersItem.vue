<template>
  <div
    :class="{ selected: isSelected, full: full }"
    class="players-item"
    @click="onClick"
  >
    <div
      class="players-item__info"
    >
      <div
        class="players-item__info-avatar"
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

      <div class="players-item__info-name">
        <app-text
          v-if="full"
          :text="player.name"
          size="medium"
        />
      </div>
    </div>

    <div
      v-if="full"
      class="players-item__status"
    >
      <app-text
        :text="player.score.toString()"
        size="medium"
      />
    </div>
  </div>
</template>

<script>
  import AppAvatar from './AppAvatar'
  import AppText from './AppText'

  export default {
    name: 'KvVirusesPlayersItem',

    components: {
      AppAvatar,
      AppText,
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

      isSelected: {
        type: Boolean,
        default: false,
      },

      isCurrent: {
        type: Boolean,
        default: false,
      },
    },

    methods: {
      onClick() {
        this.$emit('click', this.player.player_id)
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
    justify-content: space-between;
    align-items: center;

    margin-bottom: 2px;
    padding: 3px 10px;
    margin: 0 -10px;
    border-radius: 10px;
    border: solid transparent 1px;
    cursor: pointer;

    &.selected {
      background: $warning-second;
      border-color: $warning;
      box-shadow: inset 0 1px 2px $virus-shadow; 
    }

    &__info {
      display: flex;
      flex-direction: row;
      align-items: center;

      &-avatar {
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
      }

      &-name {
        flex: 1;
        margin-left: 10px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
      }
    }
  }
</style>