<template>
    <el-menu
      :default-active="activeIMenutem"
      class="el-menu-vertical kv-sidebar"
      :background-color="background"
      :text-color="textColor"
      :active-text-color="activeTextColor"
    >
      <router-link
        to="/admin"
        class="sidebar-link"
      >
        <el-menu-item index="1">
          <i class="el-icon-s-data"></i>
          <span>Дашборд</span>
        </el-menu-item>
      </router-link>

      <router-link
        to="/admin/categories"
        class="sidebar-link"
      >
        <el-menu-item index="2">
          <i class="el-icon-collection"></i>
          <span>Категорії</span>
        </el-menu-item>
      </router-link>

      <router-link
        to="/admin/Users"
        class="sidebar-link"
      >
        <el-menu-item index="3">
          <i class="el-icon-user"></i>
          <span>Користувачі</span>
        </el-menu-item>
      </router-link>
    </el-menu>
</template>

<script>
  import { AppDropdown } from '../components'

  export default {
    name: 'TheSidebar',

    description: 'Sidebar of the admin panel',

    token: '<the-sidebar></the-sidebar>',

    components: {
    },

    props: {
      active: {
        type: String,
        default: '1',
        note: 'Set the number of item in the sidebar\'s menu that whould be active by default.',
      },
    },

    data() {
      return {
        background: '#292929',
        textColor: '#909090',
        activeTextColor: '#f7f7f7',
        path: this.$router.history.current.path,
      }
    },

    computed: {
      activeIMenutem() {
        switch (this.path) {
          case '/admin':
            return '1'
            break
          case '/admin/category':
            return '2'
            break
          case '/admin/users':
            return '2'
            break
          default:
            return ''
            break
        }
      },
    },
  }
</script>

<style lang="scss">
  .kv-sidebar {
    width: 250px;

    & .is-active .sidebar-link {
      color: #f7f7f7;
    }

    & .sidebar-link {
      color: #909090;
      text-decoration: none;
    }
  }

  @media (max-width: 768px) {
    .kv-sidebar {
      display: none;
    }
  }
</style>
