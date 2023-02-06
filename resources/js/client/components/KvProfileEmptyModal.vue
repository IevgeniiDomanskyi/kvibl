<template>
  <app-modal
    :visible="visible"
    :title="signinTitle"
    :closeable="false"
    :no-footer="! isFooter"
    @close="onClose"
  >
    <kv-profile-empty-modal-step-0
      v-if="step == 0"
      @step="onStep"
    />

    <kv-profile-empty-modal-step-1
      v-if="step == 1"
      @step="onStep"
    />

    <kv-profile-empty-modal-step-2
      v-if="step == 2"
      @step="onStep"
    />

    <kv-profile-empty-modal-step-3
      v-if="step == 3"
      @step="onStep"
    />

    <kv-profile-empty-modal-step-4
      v-if="step == 4"
      @step="onStep"
    />

    <kv-profile-empty-modal-step-5
      v-if="step == 5"
      @step="onStep"
    />

    <kv-profile-empty-modal-step-6
      v-if="step == 6"
      @step="onStep"
    />

    <template
      v-if="isFooter"
      slot="footer"
    >
      <app-button
        :label="$t('game.profile.modal.begin')"
        role="primary"
        small
        @click="onClose"
      />
    </template>
  </app-modal>
</template>

<script>
  import { mapActions } from 'vuex'
  import AppModal from './AppModal'
  import AppText from './AppText'
  import AppButton from './AppButton'
  import KvProfileEmptyModalStep0 from './KvProfileEmptyModalStep0'
  import KvProfileEmptyModalStep1 from './KvProfileEmptyModalStep1'
  import KvProfileEmptyModalStep2 from './KvProfileEmptyModalStep2'
  import KvProfileEmptyModalStep3 from './KvProfileEmptyModalStep3'
  import KvProfileEmptyModalStep4 from './KvProfileEmptyModalStep4'
  import KvProfileEmptyModalStep5 from './KvProfileEmptyModalStep5'
  import KvProfileEmptyModalStep6 from './KvProfileEmptyModalStep6'
  import tabs from '../constants/tabs'
  import Game from '../mixins/game'

  export default {
    name: 'KvProfileEmptyModal',

    mixins: [Game],

    components: {
      AppModal,
      AppText,
      AppButton,
      KvProfileEmptyModalStep0,
      KvProfileEmptyModalStep1,
      KvProfileEmptyModalStep2,
      KvProfileEmptyModalStep3,
      KvProfileEmptyModalStep4,
      KvProfileEmptyModalStep5,
      KvProfileEmptyModalStep6,
    },

    props: {
      visible: {
        type: Boolean,
        default: false,
      },

      isOwner: {
        type: Boolean,
        default: false,
      },
    },

    data: () => ({
      step: 0,
    }),

    computed: {
      signinTitle() {
        return this.$t('game.profile.modal.step' + this.step + '.title')
      },

      isFooter() {
        return this.step == 6
      },
    },

    methods: {
      ...mapActions([
        'tabs/set',
        'auth/update',
        'auth/logout',
      ]),

      onStep(step) {
        this.step = step
      },

      onProfile() {
        this['tabs/set'](tabs.PROFILE)
      },

      onClose() {
        this.$emit('close')
      },
    },
  }
</script>