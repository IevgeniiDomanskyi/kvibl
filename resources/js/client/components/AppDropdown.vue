<template>
  <el-dropdown
    :trigger="trigger"
  >
    <slot />

    <el-dropdown-menu
      slot="dropdown"
      class="app-dropdown"
    >
      <el-dropdown-item
        v-for="(item, index) in items"
        :key="index"
        :icon="item.icon"
      >
        <span
          v-if="item.html"
          v-html="item.html"
        />
        <span
          v-else
        >{{ item.text }}</span>
      </el-dropdown-item>
    </el-dropdown-menu>
  </el-dropdown>
</template>

<script>
  export default {
    name: 'AppDropdown',

    props: {
      trigger: {
        type: String,
        default: 'click'
      },

      items: {
        type: Array,
        default: () => [],
      },
    },
  }
</script>

<style lang="scss">
  @import '../../../sass/_variables.scss';

  .app-dropdown {
    &.el-dropdown-menu {
      background: $color-secondary-light;
      border-color: $color-secondary-light;

      &.el-popper[x-placement^=bottom] {
        .popper__arrow {
          border-bottom-color: $color-secondary-light;

          &::after {
            border-bottom-color: $color-secondary-light;
          }
        }
      }
    }

    .el-dropdown-menu__item {
      color: $color-secondary-dark;

      span {
        font-family: $font;
        font-size: 16px;
      }

      i {
        font-size: 20px;
        top: 2px;
        position: relative;
        z-index: 0;
        margin-right: 10px;
      }

      &:hover {
        background-color: $color-secondary;
        color: $color-dark;
      }
    }
  }
</style>