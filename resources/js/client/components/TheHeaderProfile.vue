<template>
  <div
    class="header-profile"
  >
    <div
      class="header-profile__inner"
    >
      <tasty-burger-button
        :active="isSidemenuVisible"
        size="s"
        type="elastic"
      />

      <app-avatar
        :key="'avatar' + user.avatar"
        :image="user.avatar"
        size="medium"
        class="header-profile__avatar"
      />

      <app-text
        :key="'name' + user.avatar"
        :text="user.name"
        title
        class="header-profile__name"
      />

      <div
        class="header-profile__overlay"
        @click="onSidemenuToggle"
      />
    </div>

    <the-sidemenu
      :visible="isSidemenuVisible"
      @close="onSidemenuToggle"
    />
  </div>
</template>

<script>
  import { mapActions } from 'vuex'
  import { TastyBurgerButton } from 'vue-tasty-burgers'
  import TheSidemenu from './TheSidemenu'
  import AppAvatar from './AppAvatar'
  import AppText from './AppText'
  import Game from '../mixins/game'

  export default {
    name: 'TheHeaderProfile',

    mixins: [Game],

    components: {
      TastyBurgerButton,
      TheSidemenu,
      AppAvatar,
      AppText,
    },

    data: () => ({
      isSidemenuVisible: false,
    }),

    methods: {
      onSidemenuToggle() {
        this.isSidemenuVisible = ! this.isSidemenuVisible
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .header-profile {
    &__inner {
      position: relative;
      z-index: 11;
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      align-items: center;
      cursor: pointer;

      & > * {
        z-index: 0;
      }
    }

    &__overlay {
      position: absolute;
      z-index: 1;
      top: 0;
      left: 0;
      bottom: 0;
      right: 0;
    }

    &__avatar {
      margin: 0 10px;
    }
  }
</style>