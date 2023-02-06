<template>
  <div
    class="awards"
  >
    <p class="text">
      Not Found
    </p>
  </div>
</template>

<script>
  import { mapState, mapGetters, mapMutations, mapActions } from 'vuex'
  import Game from '../mixins/game'

  export default {
    name: 'GameNotFound',

    mixins: [Game],
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .awards {
    height: 100%;
  }
</style>