<template>
  <div
    class="loader"
    :class="{hide: ! isLoaderShow}"
  >
    <i class="fas fa-spinner fa-pulse"></i>
  </div>
</template>

<script>
  export default {
   name: 'AppLoader',
   
   description: 'Displays the loader when waiting for response from server.',

   token: '<app-loader></app-loader>',

   props: {
     isLoaderShow: {
       type: Boolean,
       default: false,
       note: 'Whether to show the loader.'
     }
   },
  }
</script>

<style lang="scss" scoped>
  .loader {
    position: fixed;
    z-index: 1000;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all .3s ease;

    i {
      font-size: 50px;
      color: #1d1d1dd2;
    }

    &.hide {
      opacity: 0;
      z-index: -1;
    }
  }
</style>