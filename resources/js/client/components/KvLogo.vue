<template>
  <div
    :style="style"
    class="logo"
  >
    <img
      :src="$p_image('logo' + (viruses ? '-virus' : ''))"
    />
  </div>
</template>

<script>
  export default {
    name: 'KvLogo',

    props: {
      viruses: {
        type: Boolean,
        default: false,
      },

      width: {
        type: [Number, String],
        default: '100%',
      },
    },

    computed: {
      style() {
        let result = []

        if (this.width) {
          result.push('width: ' + this.$p_size(this.width))
        }

        return result.join(';')
      },
    },
  }
</script>

<style lang="scss" scoped>
  .logo {
    img {
      width: 100%;
    }
  }
</style>