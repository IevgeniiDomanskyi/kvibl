<template>
  <div>
    <div
      v-for="(p, index) in parts"
      :key="index"
      :class="className(index)"
      :style="style"
    >
      {{ p }}
    </div>
  </div>
</template>

<script>
  export default {
    name: 'AppText',

    props: {
      text: {
        type: String,
        default: '',
      },

      // To-Do
      // Type was changed to just title prop
      // Need remove this after change everywhere
      type: {
        type: String,
        default: 'default',
      },

      title: {
        type: Boolean,
        default: false,
      },

      size: {
        type: String,
        default: 'normal',
      },

      align: {
        type: String,
        default: 'left',
      },

      color: {
        type: String,
        default: '',
      },

      stroked: {
        type: Boolean,
        default: false,
      },

      inverse: {
        type: Boolean,
        default: false,
      },

      bottomSpace: {
        type: Boolean,
        default: false,
      },
    },

    computed: {
      className() {
        return (index = 0) => {
          let result = ['app-text', this.align]

          if (this.type) {
            result.push(this.type)
          }

          if (this.title) {
            result.push('title')
          }

          if (this.size) {
            result.push(this.size)
          }

          if (this.stroked) {
            result.push('stroked')
          }

          if (this.inverse) {
            result.push('inverse')
          }

          if (this.bottomSpace || (index < (this.parts.length - 1))) {
            result.push('bottom-space')
          }

          return result.join(' ')
        }
      },

      style() {
        let result = []

        if (this.color) {
          result.push('color: ' + this.color)
        }

        return result.join(';')
      },

      parts() {
        return (this.text || '').split('||')
      },
    },
  }
</script>

<style lang="scss">
  @import '../../../sass/_variables.scss';

  .app-text {
    color: $color-text;
    font-family: $font-text;
    font-size: 14px;
    font-weight: 600;
    line-height: 1.4;

    &.inverse {
      color: $color-text-inverse;
    }

    &.title {
      font-family: $font-title;
      color: $color-primary;
      font-size: 24px;
      text-shadow:
        -2px -2px 0 $color-light,
        2px -2px 0 $color-light,
        -2px 2px 0 $color-light,
        2px 2px 0 $color-light,
        0 1px 3px $shadow-2;
    }

    &.small {
      font-size: 12px;
    }

    &.medium {
      font-size: 18px;
    }

    &.large {
      font-size: 24px;
    }

    &.xxxlarge {
      font-size: 60px;
    }

    &.stroked {
      text-shadow:
        -1px -1px 0 $color-light,
        1px -1px 0 $color-light,
        -1px 1px 0 $color-light,
        1px 1px 0 $color-light,
        0 1px 2px $shadow-2;
    }

    &.left {
      text-align: left;
    }

    &.center {
      text-align: center;
    }

    &.right {
      text-align: right;
    }

    &.bottom-space {
      margin-bottom: 15px;
    }
  }
</style>