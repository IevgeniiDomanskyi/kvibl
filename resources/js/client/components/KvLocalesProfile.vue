<template>
  <div class="kv-locales">
    <app-button
      v-for="locale in locales"
      :key="locale.id"
      :bg="'https://www.countryflags.io/' + (locale.code == 'en' ? 'gb' : locale.code) + '/flat/64.png'"
      :active="locale.id == currentLocale.id"
      round
      class="kv-locales__item"
      @click="onLocalesSelect(locale.code)"
    />
  </div>
</template>

<script>
  import { mapState, mapActions } from 'vuex'
  import AppButton from './AppButton'
 
  export default {
    name: 'KvLocalesHome',

    components: {
      AppButton,
    },

    computed: {
      ...mapState({
        user: state => state.auth.me,
        locales: state => state.locales.list,
      }),

      currentLocale() {
        for (const locale of this.locales) {
          if (locale.id == this.user.locale.id) {
            return locale
          }
        }

        return {}
      },
    },

    methods: {
      ...mapActions([
        'locales/update',
        'locales/text',
      ]),

      onLocalesSelect(code) {
        if (code != this.user.locale.code) {
          this['locales/text'](code).then(() => {
            this['locales/update'](code)
          })
        }
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .kv-locales {
    display: flex;
    align-items: center;
    justify-content: center;

    &__item {
      margin: 0 10px;
    }
  }
</style>