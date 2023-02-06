<template>
  <div class="logo">
    <img
      :style="style"
      :src="$p_image('logo-text')"
    />
    
    <app-text
      v-if="text"
      :text="text"
      size="medium"
      align="center"
      stroked
    />
  </div>
</template>

<script>
  import AppText from './AppText'

  export default {
    name: 'KvLogoText',

    components: {
      AppText,
    },

    props: {
      width: {
        type: [String, Number],
        default: 200,
      },

      text: {
        type: String,
        default: null,
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
  @import '../../../sass/_variables.scss';

  .logo {
    width: 100%;
    text-align: center;
  }
</style>