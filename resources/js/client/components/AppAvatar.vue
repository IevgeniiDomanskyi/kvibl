<template>
  <div
    :style="'border-color: ' + color"
    :class="className"
    @click="onClick"
  >
    <img
      v-if="image"
      :src="image"
    />

    <i
      v-else
      class="fas fa-user"
    />
  </div>
</template>

<script>
  export default {
    name: 'AppAvatar',

    props: {
      size: {
        type: String,
        default: 'normal',
      },

      image: {
        type: String,
        default: null,
      },

      color: {
        type: String,
        default: null,
      },

      pulse: {
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
        let result = ['avatar']

        if (this.size) {
          result.push(this.size)
        }

        if (this.pulse) {
          result.push('pulse')
        }

        if (this.bottomSpace) {
          result.push('bottom-space')
        }

        return result.join(' ')
      },
    },

    methods: {
      onClick() {
        this.$emit('click')
      }
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .avatar {
    display: inline-flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    width: 150px;
    height: 150px;
    color: $avatar;
    border: solid $avatar-border 5px;
    background-color: $avatar-bg;
    // border-radius: 33% 67% 72% 28% / 56% 67% 33% 44%;
    border-radius: 50%;
    font-size: 75px;
    overflow: hidden;
    box-shadow: inset 0 2px 5px $avatar-shadow, 0 1px 5px $avatar-shadow;
    text-shadow: -2px 0 darken($avatar-border, 10%), 0 2px darken($avatar-border, 10%), 2px 0 darken($avatar-border, 10%), 0 -2px darken($avatar-border, 10%);

    img {
      width: 90%;
      height: 90%;
      // border-radius: 33% 67% 72% 28% / 56% 67% 33% 44%;
      border-radius: 50%;
      box-shadow: 0 0 2px $avatar-shadow;
    }

    &.medium {
      width: 46px;
      height: 46px;
      font-size: 20px;
      border-width: 3px;
      box-shadow: inset 0 1px 3px $avatar-shadow, 0 1px 3px $avatar-shadow;
    }

    &.small {
      width: 35px;
      height: 35px;
      font-size: 16px;
      border-width: 2px;
      box-shadow: inset 0 0 1px $avatar-shadow, 0 1px 2px $avatar-shadow;
    }

    &.fade {
      width: 100px;
      height: 100px;
      font-size: 65px;
      border-width: 3px;
    }

    &.semi {
      width: 60px;
      height: 60px;
      line-height: 56px;
      font-size: 40px;
      border-width: 3px;
    }

    &.bottom-space {
      margin-bottom: 15px;
    }

    &.pulse {
      animation: pulse 1s infinite;
    }
  }

  @keyframes pulse
  {
    0% {
      box-shadow: 0 0 0 0px $white;
    }
    100% {
      box-shadow: 0 0 0 15px rgba(255, 255, 255, 0);
    }
  }
</style>