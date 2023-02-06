<template>
  <div class="lobby-teams">
    <app-button
      v-for="item in list"
      :key="item"
      :label="item.toString()"
      :role="item > available ? 'disabled' : (item == active ? 'success' : 'default')"
      :active="item == active"
      round
      class="lobby-teams__item"
      @click="onClick(item)"
    />
  </div>
</template>

<script>
  import AppButton from './AppButton'

  export default {
    name: 'KvLobbySettingsTeams',

    components: {
      AppButton,
    },

    props: {
      min: {
        type: Number,
        default: 1,
      },

      max: {
        type: Number,
        default: 1,
      },

      available: {
        type: Number,
        default: 0,
      },

      active: {
        type: Number,
        default: null,
      },
    },

    computed: {
      list() {
        let result = [];
        for (let i = this.min; i <= this.max; i++) {
          result.push(i)
        }
        return result
      },
    },

    methods: {
      onClick(item) {
        if (item <= this.available) {
          this.$emit('click', item)
        } else {
          this.$emit('click', 0)
        }
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .lobby-teams {
    display: flex;
    flex-direction: row;
    justify-content: center;
    margin-bottom: 15px;

    &__item {
      font-size: 30px;
      margin: 0 5px;
    }
  }
</style>