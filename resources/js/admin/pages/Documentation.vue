<template>
  <section>
    <el-card class="box-card documentation-card">
      <h1>Kvibl Vue Components Documentation</h1>
      <hr />
      <prop-doc :component="AppButton"></prop-doc>
      <prop-doc :component="AppDropdown"></prop-doc>
      <prop-doc :component="AppInput"></prop-doc>
      <prop-doc :component="AppInputLabel"></prop-doc>
    </el-card>
  </section>
</template>

<script>
  import propDoc from 'propdoc'
  import { mapActions } from 'vuex'
  import { AppButton, AppDropdown, AppInput, AppInputLabel } from '../components'
  export default {
    name: 'Documentation',

    components: {
      propDoc,
      AppButton,
      AppDropdown,
      AppInput,
      AppInputLabel,
    },
    
    // bind your component to use propdoc's native template output
    data() {
      return {
        AppButton,
        AppDropdown,
        AppInput,
        AppInputLabel
      }
    },

    created() {
      this['auth/me']()
    },

    methods: {
      ...mapActions([
        'auth/me',
      ]),
    },
  }
</script>

<style lang="scss">
  .documentation-card {
    width: 80%;
    margin: 0 auto;
  }
</style>