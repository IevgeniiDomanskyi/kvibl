<template>
  <div class="word-item">
    <div class="word-item__word">
      <div
        :class="{ current: (word.is_current && game.status == 3) }"
        class="word-item__word-number"
      >
        <img
          v-if="word.virus && (game.status == 3 && (word.is_current || isApproved)) || game.status == 4"
          :src="image(word.virus.image)"
        />

        <app-text
          v-if=" ! word.virus || (word.virus && game.status == 3 && ( ! word.is_current && ! isApproved))"
          :text="position.toString()"
          size="medium"
        />
      </div>

      <div
        v-if=" ! isOwnerApproved(word) && game.status == 3"
        class="word-item__word-placeholder"
      />

      <app-text
        v-else
        :text="word.value"
        size="medium"
        class="word-item__word-text"
      />
    </div>

    <div class="word-item__result">
      <el-switch
        v-if="isConfirmRequired"
        v-model="confirmed"
        active-color="#019908"
        inactive-color="#BE0007"
        class="word-item__result-switch"
        @change="onSwitch(word, confirmed)"
      />

      <div
        v-else
        class="word-item__result-icon"
        :class="className"
      >
        <i
          v-if="isApproved"
          class="fas fa-check"
        />

        <i
          v-if="isDeclined"
          class="fas fa-times"
        />

        <i
          v-if="isSkipped"
          class="fas fa-forward"
        />
      </div>
    </div>
  </div>
</template>

<script>
  import { mapActions } from 'vuex'
  import AppText from './AppText'
  import Game from '../mixins/game'

  export default {
    name: 'KvWordsItem',

    mixins: [Game],

    components: {
      AppText,
    },

    props: {
      word: {
        type: Object,
        required: true,
      },

      position: {
        type: Number,
        required: true,
      },
    },

    data() {
      return {
        confirmed: false,
      }
    },

    computed: {
      isConfirmRequired() {
        return this.isCaptain() && this.isOwnerApproved(this.word)
      },

      isApproved() {
        return this.isAllApproved(this.word) && this.isOwnerApproved(this.word)
      },

      isDeclined() {
        return ! this.isAllApproved(this.word) && this.isOwnerApproved(this.word)
      },

      isSkipped() {
        return ! this.isOwnerApproved(this.word) && this.game.status != 3
      },

      className() {
        let result = []

        if (this.isApproved) {
          result.push('approved')
        }

        if (this.isDeclined) {
          result.push('declined')
        }

        if (this.isSkipped) {
          result.push('skipped')
        }

        return result.join(' ')
      },
    },

    watch: {
      word(val) {
        this.confirmed = this.isMeApproved(val)
      },
    },

    created() {
      this.confirmed = this.isMeApproved(this.word)
    },

    methods: {
      ...mapActions([
        'words/confirm',
      ]),

      image(file) {
        if (file) {
          const image = require.context('../assets/', false, /\.png$/)
          return image('./' + file)
        }

        return null
      },

      onSwitch(word, value) {
        this['words/confirm']({word, value})
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .word-item {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 5px;

    &__word {
      display: flex;
      flex-direction: row;
      justify-content: flex-start;
      align-items: center;
      flex: 1;

      &-number {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: solid transparent 1px;

        &.current {
          border-color: $text;
        }

        img {
          max-width: 90%;
          max-height: 90%;
        }
      }

      &-placeholder {
        height: 20px;
        width: 60%;
        margin-left: 10px;
        background-color: rgba(0, 0, 0, 0.1);
        border-radius: 40px 40px 10px 10px/10px 10px 40px 40px;
      }

      &-text {
        margin-left: 10px;
      }
    }

    &__result {
      &-icon {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 20px;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: solid $body-bg 3px;
        margin: 0;
        float: right;
        box-shadow: 0 0 5px $input-shadow;

        &.approved {
          border-color: $text-inverse;
          background-color: $success;

          i {
            display: inline-block;
            color: $text-inverse;
          }
        }

        &.declined {
          border-color: $text-inverse;
          background-color: $danger;

          i {
            display: inline-block;
            color: $text-inverse;
          }
        }

        &.skipped {
          border-color: $text-inverse;
          background-color: $body-bg;
          font-size: 15px;

          i {
            display: inline-block;
            color: $text-inverse;
          }
        }
      }
    }
  }
</style>