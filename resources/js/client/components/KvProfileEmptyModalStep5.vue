<template>
  <div>
    <app-text
      :text="$t('game.profile.modal.step5.text')"
      bottom-space
    />

    <div class="kv-center">
      <app-avatar
        :image="user.avatar"
        bottom-space
      />
      
      <app-button
        :label="$t('game.profile.modal.step5.continue')"
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
  import AppAvatar from './AppAvatar'
  import AppButton from './AppButton'
  import Game from '../mixins/game'

  export default {
    name: 'KvProfileEmptyModalStep5',

    mixins: [Game],

    components: {
      AppText,
      AppInput,
      AppAvatar,
      AppButton,
    },

    data: () => ({
      tempAvatar: '',
    }),

    computed: {
      avatar: {
        get() {
          return this.tempAvatar || this.user.avatar
        },

        set(val) {
          this.tempAvatar = val
        },
      },
    },

    methods: {
      onContinue() {
        this.$emit('step', 6)
      },

      onStep(step) {
        this.$emit('step', step)
      },
    },
  }
</script>