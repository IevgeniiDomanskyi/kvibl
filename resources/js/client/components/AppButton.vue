<template>
  <div
    :class="{ block: block }"
    class="button-parent"
  >
    <button
      :class="className"
      :style="styles"
      type="default"
      v-touch:tap="onSound"
      @click="onClick"
    >
      <i
        v-if="icon != ''"
        :class="[icon, { 'with-text': label != '' }]"
      />

      <span
        v-if="label != ''"
      >
        {{ label }}
      </span>
    </button>

    <span
      v-if="badge"
      class="button-parent__badge"
    >
      {{ badge }}
    </span>
  </div>
</template>

<script>
  export default {
    name: 'AppButton',

    props: {
      label: {
        type: String,
        default: '',
      },

      icon: {
        type: String,
        default: '',
      },

      bg: {
        type: String,
        default: null,
      },

      role: {
        type: String,
        default: 'default',
      },

      block: {
        type: Boolean,
        default: false,
      },

      round: {
        type: Boolean,
        default: false,
      },

      small: {
        type: Boolean,
        default: false,
      },

      large: {
        type: Boolean,
        default: false,
      },

      pulse: {
        type: Boolean,
        default: false,
      },

      active: {
        type: Boolean,
        default: false,
      },

      width: {
        type: Number,
        default: null,
      },

      badge: {
        type: Number,
        default: 0,
      },

      bottomSpace: {
        type: Boolean,
        default: false,
      },

      sound: {
        type: String,
        default: 'click',
      },
    },

    computed: {
      className() {
        let result = ['button']

        if (this.block) {
          result.push('block')
        }

        if (this.round) {
          result.push('round')
        }

        if (this.small) {
          result.push('small')
        }

        if (this.large) {
          result.push('large')
        }

        if (this.role) {
          result.push(this.role)
        }

        if (this.pulse) {
          result.push('pulse')
        }

        if (this.active) {
          result.push('active')
        }

        if (this.bg) {
          result.push('no-flare')
        }

        if (this.bottomSpace) {
          result.push('bottom-space')
        }

        return result.join(' ')
      },

      styles() {
        let result = []

        if (this.width) {
          result.push('min-width: ' + this.$p_size(this.width))
        }

        if (this.bg) {
          result.push('background: url(' + this.bg + ') center no-repeat')
        }

        return result.join(';')
      },
    },

    methods: {
      onSound() {
        this.$play(this.sound)
      },

      onClick() {
        this.$emit('click')
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .button-parent {
    display: inline-block;
    vertical-align: middle;
    position: relative;
    z-index: 0;

    &.block {
      display: block;
      width: 100%;
    }

    &__badge {
      width: 24px;
      height: 24px;
      font-size: 13px;
      font-weight: 900;
      color: $color-text-inverse;
      border-radius: 50%;
      background-color: $color-danger;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
      position: absolute;
      z-index: 1;
      right: -8px;
      top: -2px;
      border: solid $color-light 2px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
    }
  }

  .button {
    border-radius: 15px;
    border: solid $color-light 3px;
    box-shadow:
      0 6px 0 darken($color-default, 10%),
      0 5px 8px $shadow-5;
    text-shadow:
      -2px 0 darken($color-default, 10%),
      0 2px darken($color-default, 10%),
      2px 0 darken($color-default, 10%),
      0 -2px darken($color-default, 10%);
    background-color: $color-default;
    padding: 0 25px;
    position: relative;
    z-index: 0;
    color: $color-text-inverse;
    overflow: hidden;
    user-select: none;
    outline: none;
    cursor: pointer;
    height: 60px;
    display: inline-flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;

    i {
      position: relative;
      z-index: 3;
      font-size: 24px;
      font-weight: 600;
      vertical-align: middle;

      &.with-text {
        margin-right: 10px;
      }
    }

    span {
      position: relative;
      z-index: 3;
      font-family: $font-title;
      font-size: 24px;
      font-weight: 600;
    }

    &:not(.no-flare):after {
      content: "";
      position: absolute;
      z-index: 0;
      left: 0;
      right: 0;
      top: 4px;
      bottom: 45%;
      background-color: $color-default-light;
      border-radius: 6px;
      box-shadow: 0 -4px 0 lighten($color-default-light, 10%);
    }

    &:before {
      content: "";
      position: absolute;
      z-index: 1;
      top: -7px;
      left: -7px;
      background-color: $glow-5;
      display: block;
      width: 20px;
      height: 20px;
      border-radius: 50%;
    }

    &:hover {
      background: lighten($color-default, 5%);

      &:after {
        background-color: lighten($color-default-light, 5%);
        box-shadow: 0 -4px 0 lighten($color-default-light, 15%);
      }
    }

    &.bottom-space {
      margin-bottom: 15px;
    }

    &.block {
      display: block;
      width: 100%;
      margin-left: 0;
    }

    &.small {
      font-size: 18px;
      padding: 0 20px;
      height: 46px;
      box-shadow:
        0 4px 0 darken($color-default, 10%),
        0 3px 5px $shadow-5;

      span {
        font-size: 18px;
      }
    }

    &.pulse {
      animation: pulse 0.5s infinite alternate;
    }

    &.large {
      text-shadow:
        -4px 0 darken($color-default, 10%),
        0 4px darken($color-default, 10%),
        4px 0 darken($color-default, 10%),
        0 -4px darken($color-default, 10%);

      &:before {
        width: 34px;
        height: 34px;
      }
    }

    &.round {
      border-radius: 50%;
      height: 46px;
      width: 46px;
      padding: 0;
      box-shadow:
        0 4px 0 darken($color-default, 10%),
        0 3px 5px $shadow-5;

      &.small {
        height: 34px;
        width: 34px;

        i {
          font-size: 20px;
        }
      }

      &.large {
        height: 100px;
        width: 100px;
        box-shadow:
          0 6px 0 darken($color-default, 10%),
          0 5px 8px $shadow-5;

        i {
          font-size: 50px;
        }
      }
    }
  }

  $roles: (
    primary: (regular: $color-primary, light: $color-primary-light),
    danger: (regular: $color-danger, light: $color-danger-light),
    success: (regular: $color-success, light: $color-success-light),
    warning: (regular: $color-warning, light: $color-warning-light),
    disabled: (regular: $color-disabled, light: $color-disabled-light),
  );

  @each $role, $colors in $roles {
    .button.#{$role} {
      box-shadow:
        0 6px 0 darken(map-get($colors, regular), 10%),
        0 5px 8px $shadow-5;
      text-shadow:
        -2px 0 darken(map-get($colors, regular), 10%),
        0 2px darken(map-get($colors, regular), 10%),
        2px 0 darken(map-get($colors, regular), 10%),
        0 -2px darken(map-get($colors, regular), 10%);
      background-color: map-get($colors, regular);

      &:after {
        background-color: map-get($colors, light);
        box-shadow: 0 -4px 0 lighten(map-get($colors, light), 10%);
      }

      &:hover {
        background: lighten(map-get($colors, regular), 5%);

        &:after {
          background-color: lighten(map-get($colors, light), 5%);
          box-shadow: 0 -4px 0 lighten(map-get($colors, light), 15%);
        }
      }

      &.large {
        text-shadow:
          -4px 0 darken(map-get($colors, regular), 10%),
          0 4px darken(map-get($colors, regular), 10%),
          4px 0 darken(map-get($colors, regular), 10%),
          0 -4px darken(map-get($colors, regular), 10%);
      }

      &.small {
        box-shadow:
          0 4px 0 darken(map-get($colors, regular), 10%),
          0 3px 5px $shadow-5;

        &.active,
        &:active {
          box-shadow: 0 1px 4px $shadow-3;
          top: 4px;
        }
      }

      &.round {
        box-shadow:
          0 4px 0 darken(map-get($colors, regular), 10%),
          0 3px 5px $shadow-5;

        &.active,
        &:active {
          box-shadow: 0 1px 4px $shadow-3;
          top: 4px;
        }

        &.large {
          box-shadow:
            0 6px 0 darken(map-get($colors, regular), 10%),
            0 5px 8px $shadow-5;

          &.active,
          &:active {
            box-shadow: 0 1px 4px $shadow-3;
            top: 6px;
          }
        }
      }
    }
  }

  .button {
    &.active,
    &:active {
      box-shadow: 0 1px 4px $shadow-3;
      top: 6px;
    }

    &.round.active,
    &.small.active
    &.round:active,
    &.small:active {
      top: 4px;
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