<template>
  <div class="page-layout">
    <the-header
      logoPath="/images/logo.png"
      logoText="kvibl"
    />
    
    <div class="layout-container">
      <the-sidebar/>
      
      <div class="content-layout">
        <router-view />
      </div>
    </div>
  </div>
</template>

<script>
  import { TheHeader, TheSidebar } from '../components'

  export default {
    components: {
      TheHeader,
      TheSidebar,
    },
  }
</script>

<style lang="scss">
  .page-layout {
    position: fixed;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    height: 100vh;

    & .layout-container {
      display: flex;
      align-items: stretch;
      flex-wrap: nowrap;
      height: calc(100% - 70px);
    }
    
    & .content-layout {
      width: 100%;
      padding: 15px;
      overflow-y: auto;
    }
  }
</style>