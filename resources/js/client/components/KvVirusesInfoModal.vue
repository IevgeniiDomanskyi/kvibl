<template>
  <app-modal
    :visible="visible"
    :title="virus.name"
    no-footer
    @close="onClose"
  >
    <div class="viruses-modal__image">
      <img
        :src="image(virus.image)"
      />
    </div>

    <app-text
      :text="virus.description"
      bottom-space
    />

    <app-text
      :text="$t('game.viruses.example') + ' ' + $t('game.viruses.example_word')"
      bottom-space
    />

    <div
      class="viruses-modal__example"
    >
      <kv-round-word
        :word="$t('game.viruses.example_word')"
        :type="virus.type"
      />
    </div>
  </app-modal>
</template>

<script>
  import AppModal from './AppModal'
  import AppText from './AppText'
  import KvRoundWord from './KvRoundWord'

  export default {
    name: 'KvVirusesInfoModal',

    components: {
      AppModal,
      AppText,
      KvRoundWord,
    },

    props: {
      visible: {
        type: Boolean,
        default: false,
      },

      virus: {
        type: Object,
        required: true,
      },
    },

    methods: {
      image(file) {
        if (file) {
          const image = require.context('../assets/', false, /\.png$/)
          return image('./' + file)
        }

        return null
      },

      onClose() {
        this.$emit('close')
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';
  @import '../../../sass/_viruses.scss';

  .viruses-modal__image {
    text-align: center;

    img {
      max-width: 150px;
      max-height: 150px;
      margin-bottom: 30px;
    }
  }
</style>