<template>
  <el-checkbox
    v-model="checked"
    :class="className"
    @change="onChange"
  >
    <slot />
  </el-checkbox>
</template>

<script>
  export default {
    name: 'AppCheckbox',

    props: {
      value: {
        type: Boolean,
        default: false,
      },

      bottomSpace: {
        type: Boolean,
        default: false,
      },
    },

    computed: {
      checked: {
        get() {
          return this.value
        },

        set(val) {
          this.$emit('input', val)
        },
      },

      className() {
        let result = ['app-checkbox']

        if (this.bottomSpace) {
          result.push('bottom-space')
        }

        return result.join(' ')
      },
    },

    methods: {
      onChange(val) {
        this.$emit('change', val)
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .app-checkbox {
    &.bottom-space {
      margin-bottom: 15px;
    }
  }
</style>

<style lang="scss">
  @import '../../../sass/_variables.scss';

  .app-checkbox.el-checkbox {
    white-space: normal;
    display: inline-flex;
    justify-content: flex-start;
    align-items: center;

    .el-checkbox__inner {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      border: 3px solid $color-secondary-dark;

      &::after {
        height: 14px;
        width: 6px;
        left: 7px;
        border-width: 3px;
      }
    }

    .el-checkbox__input.is-checked {
      .el-checkbox__inner {
        background: $color-secondary;
      }
    }
  }
</style>