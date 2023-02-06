<template>
  <div>
    <app-text
      :text="$t('game.profile.modal.step4.text')"
      bottom-space
    />
  
    <app-input
      v-model="name"
      :placeholder="$t('game.profile.modal.step4.name')"
      align="center"
      title
      bottom-space
    />

    <div class="kv-center">
      <app-button
        :label="$t('game.profile.modal.step4.continue')"
        role="primary"
        small
        @click="onContinue"
      />
    </div>
  </div>
</template>

<script>
  import { mapActions } from 'vuex'
  import AppText from './AppText'
  import AppInput from './AppInput'
  import AppButton from './AppButton'
  import Game from '../mixins/game'

  export default {
    name: 'KvProfileEmptyModalStep4',

    mixins: [Game],

    components: {
      AppText,
      AppInput,
      AppButton,
    },

    data: () => ({
      tempName: '',
    }),

    computed: {
      name: {
        get() {
          return this.tempName || this.user.name
        },

        set(val) {
          this.tempName = val
        },
      },
    },

    methods: {
      onContinue() {
        this.$emit('step', 5)
      },

      onStep(step) {
        this.$emit('step', step)
      },
    },
  }
</script>