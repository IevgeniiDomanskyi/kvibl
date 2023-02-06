<template>
  <div :class="className">
    <p
      v-if="$slots.title"
      class="message__title"
    >
      <slot name="title" />
    </p>

    <p class="message__body">
      <slot />
    </p>
  </div>
</template>

<script>
  export default {
    name: 'KvMessageBox',

    props: {
      type: {
        type: String,
        default: 'default',
        validator: function (value) {
          return ['default', 'success', 'error'].indexOf(value) !== -1
        },
      },

      align: {
        type: String,
        default: 'center',
        validator: function (value) {
          return ['center', 'left', 'right'].indexOf(value) !== -1
        },
      },

      bottomSpace: {
        type: Boolean,
        default: false,
      },
    },

    computed: {
      className() {
        let result = ['message'];

        if (this.type) {
          result.push(this.type)
        }

        if (this.align) {
          result.push(this.align)
        }

        if (this.bottomSpace) {
          result.push('bottom-space')
        }

        return result.join(' ')
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .message {
    border-radius: 4px;
    padding: 15px;
    border: solid 1px;
    color: $white;

    &.default {
      border-color: $white-border;
      background: $white-bg;
    }

    &.success {
      border-color: $green-border;
      background: $green-bg;
    }

    &.error {
      border-color: $red-border;
      background: $red-bg;
    }

    &.left {
      text-align: left;
    }

    &.right {
      text-align: right;
    }

    &.center {
      text-align: center;
    }

    &.bottom-space {
      margin-bottom: 15px;
    }

    &__title {
      font-size: 22px;
      font-weight: 900;
      margin: 0 0 10px 0;
    }

    &__body {
      font-size: 16px;
      margin: 0;
    }
  }
</style>