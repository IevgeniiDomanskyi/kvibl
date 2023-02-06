<template>
  <app-modal
    :title="title"
    :visible="visible"
    @close="onClose"
  >
    <app-text
      :text="text"
    />

    <template slot="footer">
      <app-button
        :label="closeLabel"
        :width="90"
        role="default"
        small
        @click="onClose"
      />

      <app-button
        :label="confirmLabel"
        :width="90"
        role="primary"
        small
        @click="onConfirm"
      />
    </template>
  </app-modal>
</template>

<script>
  import AppModal from './AppModal'
  import AppText from './AppText'
  import AppButton from './AppButton'
  
  export default {
    name: 'AppModalConfirm',

    components: {
      AppModal,
      AppText,
      AppButton,
    },

    props: {
      visible: {
        type: Boolean,
        default: false,
      },

      title: {
        type: String,
        default: null,
      },

      text: {
        type: String,
        default: null,
      },

      close: {
        type: String,
        default: '',
      },

      confirm: {
        type: String,
        default: '',
      },
    },

    computed: {
      confirmLabel() {
        return this.confirm != '' ? this.confirm : this.$t('game.text.yes')
      },

      closeLabel() {
        return this.close != '' ? this.close : this.$t('game.text.no')
      },
    },

    methods: {
      onClose() {
        this.$emit('close')
      },

      onConfirm() {
        this.$emit('confirm')
      },
    },
  }
</script>