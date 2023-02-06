<template>
  <div>
    <app-text
      :text="$t('game.profile.modal.step1.text')"
      bottom-space
    />

    <app-input
      v-model="auth.email"
      :placeholder="$t('game.profile.modal.step1.email')"
      type="email"
      icon="fas fa-at"
      bottom-space
    />

    <app-input
      v-model="auth.password"
      :placeholder="$t('game.profile.modal.step1.password')"
      type="password"
      icon="fas fa-lock"
      bottom-space
    />

    <div class="kv-center">
      <app-button
        :label="$t('game.profile.modal.step1.signin')"
        role="primary"
        small
        bottom-space
        @click="onSignin"
      />
    </div>

    <div
      class="kv-center"
    >
      <app-link
        :text="$t('game.profile.modal.step1.recovery')"
        bottom-space
        @click="onStep(3)"
      />
    </div>

    <app-text
      :text="$t('game.profile.modal.step1.account')"
      bottom-space
    />

    <div class="kv-center">
      <app-button
        :label="$t('game.profile.modal.step1.register')"
        role="default"
        small
        @click="onStep(2)"
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
    name: 'KvProfileEmptyModalStep1',

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
        password: '',
      },
    }),

    methods: {
      onSignin() {
        this.$emit('step', 4)
      },

      onStep(step) {
        this.$emit('step', step)
      },
    },
  }
</script>