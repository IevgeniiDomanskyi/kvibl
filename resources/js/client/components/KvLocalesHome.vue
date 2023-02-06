<template>
  <div class="locales">
    <app-button
      :bg="$p_image(current)"
      round
      @click="onOpen"
    />

    <div
      :class="{ visible: isPanelVisible }"
      class="locales-panel"
    >
      <app-button
        v-for="locale in sorted"
        :key="locale.id"
        :bg="$p_image(locale.code)"
        round
        class="locales-panel__item"
        @click="onSelect(locale.code)"
      />
    </div>
  </div>
</template>

<script>
  import { mapState, mapActions } from 'vuex'
  import AppButton from './AppButton'
  import Game from '../mixins/game'
 
  export default {
    name: 'KvLocalesHome',

    mixins: [Game],

    components: {
      AppButton,
    },

    data: () => ({
      isPanelVisible: false,
    }),

    computed: {
      ...mapState({
        locales: state => state.locales.list,
        current: state => state.locales.current,
      }),

      sorted() {
        // Sorting locales to make current locale at the top
        return this.locales.sort((a, b) => { return a.code == this.current ? -1 : 1 })
      },
    },

    created() {
      // Add event to close locales panel after clicking outside panel
      this.$p_event('click', this.onClickOutside)
    },

    methods: {
      ...mapActions([
        'locales/update',
        'locales/text',
      ]),

      onClickOutside(e) {
        // Detecting if click was outside panel
        if ( ! this.$el.contains(e.target)) {
          this.isPanelVisible = false
        }
      },

      onOpen() {
        this.isPanelVisible = true
      },

      onSelect(code) {
        this.isPanelVisible = false

        // Checking if user selected different locale
        if (code != this.current) {
          // Load texts for selected locale
          this['locales/text'](code).then(text => {
            if (text) {
              // Set selected locale as current
              // and update locale for current user

              this['locales/update']({
                code,
                user: this.user,
              })
            } else {
              // To-Do
              // Show something when no texts for selected locale
              console.log('*** Loaded texts', 'No texts for locale ' + code)
            }
          })
        }
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .locales {
    position: relative;
    z-index: 0;

    &-panel {
      position: absolute;
      top: -5px;
      left: -5px;
      background: $color-light;
      padding: 5px 5px 9px;
      border-radius: 38px;
      box-shadow: 0 0 5px $shadow-2;
      overflow: hidden;

      max-height: 66px;
      opacity: 0;
      z-index: -1;
      transition: all 0.3s ease 0s;

      &.visible {
        max-height: 400px;
        opacity: 1;
        z-index: 1;
      }

      &__item:not(:last-child) {
        margin-bottom: 9px;
      }
    }
  }
</style>