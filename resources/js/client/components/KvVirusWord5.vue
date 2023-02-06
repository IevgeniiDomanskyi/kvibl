<template>
  <div class="virus-5">
    <app-text
      :text="word"
      class="virus-5-word"
      size="large"
      align="center"
    />

    <div class="virus-5-watch" />
  </div>
</template>

<script>
  import AppText from "./AppText"

  export default {
    name: 'KvVirusWord5',

    components: {
      AppText,
    },

    props: {
      word: {
        type: String,
        required: true,
      }
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .virus-5 {
    position: relative;
    z-index: 0;
    overflow: hidden;

    &-word {
      position: relative;
      z-index: 0;
      text-transform: lowercase;
    }
    
    &-watch {
      position: absolute;
      z-index: 2;
      height: 64px;
      border: solid 30px $virus-bg;
      border-left: 0;
      border-right: 0;
      left: -30px;
      right: 0;
      top: -30px;
      animation: move 2s infinite alternate linear;
    }
  }

  @keyframes move {
    0% {
      top: -30px;
    }

    100% {
      top: calc(100% - 30px);
    }
  }
</style>