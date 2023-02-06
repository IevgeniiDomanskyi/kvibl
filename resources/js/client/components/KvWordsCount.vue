<template>
  <div class="words-count">
    <app-text
      :text="confirmed + ' / ' + max"
      size="large"
      inverse
    />
  </div>
</template>

<script>
  import AppText from './AppText'
  export default {
    name: 'KvWordsCount',

    components: {
      AppText,
    },

    props: {
      max: {
        type: Number,
        default: 0,
      },

      confirmed: {
        type: Number,
        default: 0,
      },
    }
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .words-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0 15px;
    height: 50px;
    border-radius: 40px 40px 10px 10px/10px 10px 40px 40px;
    border-width: 5px;
    border-style: solid;
    border-color: $input-border;
    background: $input-bg;
    box-shadow: inset 0 2px 5px $input-shadow, 0 1px 5px $input-shadow;
  }
</style>