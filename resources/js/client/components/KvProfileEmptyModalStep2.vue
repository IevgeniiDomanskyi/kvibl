<template>
  <div>
    <app-text
      :text="$t('game.profile.modal.step2.text')"
      bottom-space
    />
  
    <app-input
      v-model="auth.name"
      :placeholder="$t('game.profile.modal.step2.name')"
      type="email"
      icon="fas fa-user"
      bottom-space
    />

    <app-input
      v-model="auth.email"
      :placeholder="$t('game.profile.modal.step2.email')"
      type="email"
      icon="fas fa-at"
      bottom-space
    />

    <app-input
      v-model="auth.password"
      :placeholder="$t('game.profile.modal.step2.password')"
      type="password"
      icon="fas fa-lock"
      bottom-space
    />

    <app-checkbox
      v-model="auth.confirm"
      bottom-space
    >
      <app-link
        :text="$t('game.profile.modal.step2.privacy')"
      />
    </app-checkbox>

    <div class="kv-center">
      <app-button
        :label="$t('game.profile.modal.step2.register')"
        role="primary"
        small
        bottom-space
        @click="onRegister"
      />
    </div>

    <div
      class="kv-center"
    >
      <app-link
        :text="$t('game.profile.modal.step2.signin')"
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
  import AppCheckbox from './AppCheckbox'
  import AppButton from './AppButton'
  import Game from '../mixins/game'

  export default {
    name: 'KvProfileEmptyModalStep2',

    mixins: [Game],

    components: {
      AppText,
      AppLink,
      AppInput,
      AppCheckbox,
      AppButton,
    },

    data: () => ({
      auth: {
        name: '',
        email: '',
        password: '',
        confirm: false,
      },
    }),

    methods: {
      onRegister() {
        this.$emit('step', 4)
      },

      onStep(step) {
        this.$emit('step', step)
      },
    },
  }
</script>