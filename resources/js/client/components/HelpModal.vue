<template>
  <app-modal
    :title="title"
    :visible="visible"
    help
    v-touch:swipe.left="onNext"
    v-touch:swipe.right="onBack"
    @close="onClose"
  >
    <app-text
      :text="description"
    />

    <template slot="help">
      <div class="help-steps">
        <div
          v-for="item in range(steps)"
          :key="item"
          :class="stepClassName(item)"
          @click="onStep(item)"
        />
      </div>
    </template>

    <template slot="footer">
      <app-button
        v-if="current > 1"
        icon="fas fa-backward"
        role="default"
        small
        @click="onBack"
      />

      <app-button
        v-if="current < steps"
        icon="fas fa-forward"
        role="primary"
        small
        @click="onNext"
      />

      <app-button
        v-if="current == steps || steps == 0"
        :label="$t('game.help.button.end')"
        role="primary"
        small
        @click="onClose"
      />
    </template>
  </app-modal>
</template>

<script>
  import AppModal from './AppModal'
  import AppText from './AppText'
  import AppButton from './AppButton'
  import Game from '../mixins/game'
  
  export default {
    name: 'HelpModal',

    mixins: [Game],

    components: {
      AppModal,
      AppText,
      AppButton,
    },

    data: () => ({
      current: 1,
    }),

    props: {
      visible: {
        type: Boolean,
        default: false,
      },

      type: {
        type: String,
        default: 'intro',
      },

      steps: {
        type: Number,
        default: 0,
      },
    },

    computed: {
      title() {
        return this.$t('game.help.' + this.type.toLowerCase() + '.step' + this.current + '.title')
      },

      description() {
        return this.$t('game.help.' + this.type.toLowerCase() + '.step' + this.current + '.description')
      },

      stepClassName() {
        return (step) => {
          let result = ['help-steps__item']

          if (this.current == step) {
            result.push('active')
          }

          return result.join(' ')
        }
      },
    },

    methods: {
      onClose() {
        this.$emit('close')
      },

      onNext() {
        if (this.current < this.steps) {
          this.current++
        }
      },

      onBack() {
        if (this.current > 1) {
          this.current--
        }
      },

      onStep(step) {
        this.current = step
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .help-steps {
    display: flex;
    justify-content: center;
    align-items: center;
    position: absolute;
    z-index: 1;
    left: 0;
    right: 0;
    bottom: 35px;

    &__item {
      width: 14px;
      height: 14px;
      border-radius: 50%;
      background: $input-bg;
      margin: 0 6px;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);

      &.active {
        background: $input-border;
        border: solid $input-color 3px;
        box-shadow: 0 0 2px rgba(0, 0, 0, 0.5);
        width: 20px;
        height: 20px;
        margin: 0 2px;
      }
    }
  }
</style>