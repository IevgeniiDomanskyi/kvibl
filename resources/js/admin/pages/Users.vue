<template>
  <div>
    <h2>Користувачі</h2>

    <h2 class="content-header-section">

    </h2>

    <kv-users-table
      :data="users"
      v-loading="isLoaderShow"
      @select="handleSelect($event)"
    />
  </div>
</template>

<script>
  import { mapActions, mapState } from 'vuex'
  import {
    AppButton,
    KvUsersTable,
  } from '../components'

  export default {
    name: 'Users',

    components: {
      AppButton,
      KvUsersTable,
    },

    data() {
      return {
        isLoaderShow: true,
      }
    },

    computed: {
      ...mapState({
        users: state => state.users.users,
      }),
    },

    created() {
      this['users/all']().then(response => {
        this.isLoaderShow = false
      })
    },

    methods: {
      ...mapActions([
        'users/all',
        'users/add',
        'users/delete',
      ]),

      handleSelect(val) {
        this.selectedItems = val
      },
    },
  }
</script>

<style lang="scss">
  .content-header-section {
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    justify-content: space-between;
    align-content: space-between;
    align-items: flex-start;
  }

  @media (max-width: 768px) {
    .content-header-section {

      & .el-button+.el-button {
        margin: 0;
      }
    }
  }
</style>
