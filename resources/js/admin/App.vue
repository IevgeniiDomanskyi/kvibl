<template>
  <div>
    <router-view></router-view>

    <app-alert />

    <app-loader
      :isLoaderShow="isLoaderShow"
    />
  </div>
</template>

<script>
  import { AppAlert, AppLoader } from './components'
  import { mapState } from 'vuex'

  export default {
    name: 'App',

    components: {
      AppAlert,
      AppLoader,
    },

    computed: {
      ...mapState({
        isLoaderShow: state => state.auth.isLoaderShow,
      }),
    },
  }
</script>