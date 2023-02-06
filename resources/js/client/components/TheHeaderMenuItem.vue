<template>
  <app-button
    v-if="visible"
    :icon="icon"
    :badge="badge > 0 && ! active ? badge : null"
    :role="quit ? 'primary' : 'warning'"
    :active="active"
    round
    class="header-menu__item"
    @click="onClick"
  />
</template>

<script>
  import AppButton from './AppButton'

  export default {
    name: 'TheHeaderMenuItem',

    components: {
      AppButton,
    },

    props: {
      visible: {
        type: Boolean,
        default: true,
      },

      active: {
        type: Boolean,
        default: false,
      },

      icon: {
        type: String,
        default: null,
      },

      badge: {
        type: Number,
        default: 0,
      },

      quit: {
        type: Boolean,
        default: false,
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

  .header-menu__item {
    margin-left: 10px;
  }
</style>