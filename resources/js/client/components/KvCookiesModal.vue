<template>
  <app-modal
    :title="$t('game.modal.cookies.title')"
    :visible="visible"
    :closeable="false"
  >
    <app-text
      :text="$t('game.modal.cookies.text')"
      bottom-space
    />

    <app-text
      :text="$t('game.modal.cookies.text_link')"
      bottom-space
    />

    <a
      href="https://kvibl.com/privacy-policy"
      target="_blank"
      class="kv-link bottom-space"
    >
      {{ $t('game.modal.cookies.link') }}
    </a>

    <app-text
      :text="$t('game.modal.cookies.text_confirm')"
    />

    <template slot="footer">
      <app-button
        :label="$t('game.modal.cookies.confirm')"
        role="primary"
        small
        @click="onConfirm"
      />
    </template>
  </app-modal>
</template>

<script>
  import { mapMutations } from 'vuex'
  import AppModal from './AppModal'
  import AppText from './AppText'
  import AppButton from './AppButton'
  import Game from '../mixins/game'

  export default {
    name: 'KvCookiesModal',

    mixins: [Game],

    props: {
      visible: {
        type: Boolean,
        default: false,
      },
    },

    components: {
      AppModal,
      AppText,
      AppButton,
    },

    methods: {
      ...mapMutations([
        'auth/cookiesSet',
      ]),

      onConfirm() {
        this['auth/cookiesSet'](true)
        this.$emit('close', true)
      },
    },
  }
</script>