<template>
  <div
    :class="className"
  >
    <a
      @click="onClick"
    >
      <i
        v-if="icon"
        :class="icon"
      />

      {{ text }}
    </a>
  </div>
</template>

<script>
  export default {
    name: 'TheSidemenuItem',

    props: {
      text: {
        type: String,
        default: '',
      },
      
      icon: {
        type: String,
        default: '',
      },

      active: {
        type: Boolean,
        default: false,
      },

      color: {
        type: String,
        default: null,
      },
    },

    computed: {
      className() {
        let result = ['sidemenu-item']

        if (this.active) {
          result.push('active')
        }

        if (this.color) {
          result.push(this.color)
        }

        return result.join(' ')
      },
    },

    methods: {
      onClick() {
        this.$emit('click')
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .sidemenu-item {
    margin-bottom: 20px;

    a {
      font-family: $font-title;
      font-size: 20px;
      font-weight: 600;
      color: $color-text;
      text-decoration: none;
      cursor: pointer;
      text-shadow:
        -1px -1px 0 $color-light,
        1px -1px 0 $color-light,
        -1px 1px 0 $color-light,
        1px 1px 0 $color-light,
        0 1px 3px $shadow-5;

      i {
        width: 30px;
        font-size: 24px;
        margin-right: 5px;
        text-align: center;
      }
    }

    &.active {
      a {
        color: $color-primary;
      }
    }

    &.danger {
      a {
        color: $color-danger;
      }
    }

    &.success {
      a {
        color: $color-success;
      }
    }
  }
</style>