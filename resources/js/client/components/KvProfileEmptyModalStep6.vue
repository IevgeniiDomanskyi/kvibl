<template>
  <div>
    <app-text
      :text="$t('game.profile.modal.step6.text')"
      bottom-space
    />

    <app-link
      :text="$t('game.profile.modal.step6.privacy')"
      bottom-space
    />
  
    <app-text
      :text="$t('game.profile.modal.step6.end')"
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
    name: 'KvProfileEmptyModalStep6',

    mixins: [Game],

    components: {
      AppText,
      AppLink,
      AppButton,
    },
  }
</script>