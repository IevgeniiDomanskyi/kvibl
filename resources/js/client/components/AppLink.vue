<template>
  <a
    :class="className"
    @click="onClick"
  >
    {{ text }}
  </a>
</template>

<script>
  export default {
    name: 'AppLink',

    props: {
      text: {
        type: String,
        default: '',
      },

      bottomSpace: {
        type: Boolean,
        default: false,
      },
    },

    computed: {
      className() {
        let result = ['app-link']

        if (this.bottomSpace) {
          result.push('bottom-space')
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

  .app-link {
    color: $color-primary;
    font-family: $font-text;
    font-size: 14px;
    font-weight: 600;
    line-height: 1.4;
    text-decoration: none;
    cursor: pointer;
    border-bottom: dashed 1px;

    &.bottom-space {
      display: inline-block;
      margin-bottom: 15px;
    }

    &:hover {
      border-color: transparent;
    }
  }
</style>