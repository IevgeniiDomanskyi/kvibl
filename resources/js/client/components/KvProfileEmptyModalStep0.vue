<template>
  <div>
    <app-text
      :text="$t('game.profile.modal.step0.text')"
      bottom-space
    />

    <div
      v-if="$kvibl.isApp()"
    >
      <app-button
        :label="$t('game.profile.modal.step0.google')"
        icon="fab fa-google"
        role="primary"
        small
        block
        bottom-space
        @click="onGoogleSignIn"
      />

      <app-text
        :text="$t('game.profile.modal.step0.or')"
        align="center"
        bottom-space
      />

      <div class="kv-center">
        <app-link
          :text="$t('game.profile.modal.step0.signin')"
          bottom-space
          @click="onStep(1)"
        />
      </div>
    </div>

    <div
      v-else
    >
      <app-button
        :label="$t('game.profile.modal.step0.signin')"
        role="primary"
        small
        block
        bottom-space
        @click="onStep(1)"
      />
    </div>

    <app-text
      :text="$t('game.profile.modal.step0.alternate')"
      bottom-space
    />

    <app-button
      :label="$t('game.profile.modal.step0.continue')"
      role="default"
      small
      block
      @click="onStep(4)"
    />
  </div>
</template>

<script>
  import { mapActions } from 'vuex'
  import AppText from './AppText'
  import AppLink from './AppLink'
  import AppButton from './AppButton'
  import Game from '../mixins/game'

  export default {
    name: 'KvProfileEmptyModalStep0',

    mixins: [Game],

    components: {
      AppText,
      AppLink,
      AppButton,
    },

    methods: {
      onStep(step) {
        this.$emit('step', step)
      },

      onGoogleSignIn() {
        this.$kvibl.signIn(this.userUpdate)
      },

      userUpdate(data) {
        data.is_registered = true
        this['auth/update'](data)
        this.onStep(4)
      },

      onGoogleSignOut() {
        this.$kvibl.signOut(this.onLogout)
      },

      onLogout() {
        this['auth/logout']()
        this.m_resetGame()
      },
    },
  }
</script>