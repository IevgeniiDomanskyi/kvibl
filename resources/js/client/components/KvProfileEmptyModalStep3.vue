<template>
  <div>
    <app-text
      :text="$t('game.profile.modal.step3.text')"
      bottom-space
    />
  
    <app-input
      v-model="auth.email"
      :placeholder="$t('game.profile.modal.step3.email')"
      type="email"
      icon="fas fa-at"
      bottom-space
    />

    <div class="kv-center">
      <app-button
        :label="$t('game.profile.modal.step3.recovery')"
        role="primary"
        small
        bottom-space
        @click="onRecovery"
      />
    </div>

    <div
      class="kv-center"
    >
      <app-link
        :text="$t('game.profile.modal.step3.signin')"
        @click="onStep(1)"
      />
    </div>
  </div>
</template>

<script>
  import { mapActions } from 'vuex'
  import AppText from './AppText'
  import AppLink from './AppLink'
  import AppInput from './AppInput'
  import AppButton from './AppButton'
  import Game from '../mixins/game'

  export default {
    name: 'KvProfileEmptyModalStep3',

    mixins: [Game],

    components: {
      AppText,
      AppLink,
      AppInput,
      AppButton,
    },

    data: () => ({
      auth: {
        email: '',
      },
    }),

    methods: {
      onRecovery() {
        this.$emit('step', 1)
      },

      onStep(step) {
        this.$emit('step', step)
      },
    },
  }
</script>