<template>
  <div class="lobby-code">
    <app-text
      :text="$t('game.lobby.code_title')"
      align="center"
      type="title"
    />

    <div class="lobby-code__box">
      <div class="lobby-code__box-text">
        {{ code }}
      </div>
    </div>
  </div>
</template>

<script>
  import AppText from './AppText'

  export default {
    name: 'KvLobbyCode',

    components: {
      AppText,
    },

    props: {
      code: {
        type: Number,
        required: true,
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .lobby-code {
    text-align: center;

    &__box {
      &-text {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-family: $font-title;
        line-height: 1;
        font-size: 80px;
        padding: 20px 30px 0;
        height: 100px;
        border-radius: 40px 40px 10px 10px/10px 10px 40px 40px;
        border-width: 5px;
        border-style: solid;
        border-color: $input-border;
        background: $input-bg;
        color: $input-color;
        box-shadow: inset 0 2px 5px $input-shadow, 0 1px 5px $input-shadow;
        letter-spacing: 5px;
      }

      @media (max-width: 768px) {
        &-text {
          padding-top: 0;
        }
      }
    }
  }
</style>