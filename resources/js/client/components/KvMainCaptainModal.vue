<template>
  <app-modal
    :visible="visible"
    :title="$t('game.main.captain_title')"
    role="default"
    @close="onClose"
  >
    <div class="captain-icon">
      <i
        class="fas fa-crown"
      />
    </div>

    <app-text
      :text="$t('game.main.captain_text')"
    />

    <template slot="footer">
      <app-button
        :label="$t('game.main.got_it')"
        role="primary"
        small
        @click="onClose"
      />
    </template>
  </app-modal>
</template>

<script>
  import { mapGetters, mapMutations, mapActions } from 'vuex'
  import AppModal from './AppModal'
  import AppText from './AppText'
  import AppButton from './AppButton'
  import Game from '../mixins/game'

  export default {
    name: 'KvMainCaptainModal',

    mixins: [Game],

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
    },

    methods: {
      onClose() {
        this.$emit('close')
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .captain-icon {
    text-align: center;
    margin-bottom: 15px;

    i {
      color: $gold;
      font-size: 60px;
      text-shadow: 0 0 2px rgba(0, 0, 0, 1);
    }
  }
</style>