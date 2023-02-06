<template>
  <nav class="header-nav">
    <div class="header-nav-content">
      <div class="header-left-section">
        <div class="mobile-menu-section">
          <div
            class="mobile-menu-btn"
            @click="handleOpenMobileMenu"
          >
            <i class="fas fa-bars"></i>
          </div>

          <div
            class="mobile-menu"
            :class="{'collapsed': isOpen}"
          >
            <el-menu
              :default-active="activeIMenutem"
              class="el-menu-vertical"
              :background-color="background"
              :text-color="textColor"
              :active-text-color="activeTextColor"
            >
              <router-link
                to="/admin"
                class="sidebar-link"
              >
                <el-menu-item 
                  index="1"
                  @click="handleOpenMobileMenu"
                >
                  <i class="el-icon-user"></i>
                  <span>Користувачі</span>
                </el-menu-item>
              </router-link>
              
              <router-link
                to="/admin/categories"
                class="sidebar-link"
              >
                <el-menu-item
                  index="2"
                  @click="handleOpenMobileMenu"
                >
                  <i class="el-icon-collection"></i>
                  <span>Категорії</span>
                </el-menu-item>
              </router-link>
            </el-menu>
          </div>
        </div>

        <div class="header-nav-logo-section">
          <img :src="logoPath" alt="" />
          <span>{{ logoText }}</span>
        </div>
      </div>
      
      <div class="header-nav-avatar-section">
        <img src="/images/default_avatar.png" alt="" />
        <span><app-dropdown 
        :text="me.email"
        openTrigger="click"
        :dropdownItems="dropdownItems"
        @logout="logout"
        /></span>
      </div>
    </div>
  </nav>
</template>

<script>
  import { mapActions, mapState } from 'vuex'
  import { AppDropdown } from '../components'
  export default {
    name: 'TheHeader',

    description: 'Header of the admin panel',
    
    token: '<the-header></the-header>',

    components: {
      AppDropdown,
    },

    props: {
      logoPath: {
        type: String,
        default: '',
        note: 'Set the logo image into the header.'
      },
      logoText: {
        type: String,
        default: '',
        note: 'Set the name of brand near logo.'
      },
    },

    data() {
      return {
        dropdownItems: {
          logout: {
            name: 'Вийти',
            value: 'logout',
          }
        },
        isOpen: false,
        path: this.$router.history.current.path,
        background: '#292929',
        textColor: '#909090',
        activeTextColor: '#f7f7f7',
      }
    },

    computed: {
      ...mapState({
        me: state => state.auth.me,
      }),

      activeIMenutem() {
        switch (this.path) {
          case '/admin':
            return '1'
            break
          case '/admin/category':
            return '2'
            break
          default:
            return ''
            break
        }
      },
    },

    methods: {
      ...mapActions([
        'auth/logout',
      ]),
      
      logout() {
        this['auth/logout']()
      },
      
      handleOpenMobileMenu() {
        this.isOpen = ! this.isOpen
      },
    },
  }
</script>

<style lang="scss">
  .header-nav {
    background-color: #1b1b1b;
    display: flex;

    & .header-nav-content {
      width: 100%;
      padding: 15px 25px;
      display: flex;
      justify-content: space-between;

      & .mobile-menu-section {
        display: none;
      }

      & .header-nav-logo-section {
        display: flex;
        align-items: center;

        & img {
          height: 40px;
          margin-right: 10px;
        }
        
        & span {
          color: #fff;
          font-size: 24px;
        }
      }

      & .header-nav-avatar-section {
        display: flex;
        align-items: center;

        & img {
          width: 40px;
          height: 40px;
          border-radius: 50%;
          margin-right: 10px;
        }

        & span {
          color: #fff;
          font-size: 14px;
          cursor: pointer;
        }
      }
    }
  }

  @media (max-width: 768px) {
    .header-nav {
      
      .header-nav-content {
        padding-left: 15px;
       
        .header-left-section {
          display: flex;

          & .mobile-menu-section {
            display: block;

            & .mobile-menu-btn {
              color: #fff;
              padding: 2px 10px;
              border: 1px solid #fff;
              border-radius: 6px;
              font-size: 25px;
              margin-right: 20px;
            }

            & .mobile-menu {
              position: fixed;
              z-index: 10;
              top: 70px;
              left: 0;
              right: 0;
              height: 0;
              background: #313131;
              transition: .3s;
              overflow: hidden;

              &.collapsed {
                height: calc(100vh - 70px);
              }
            }
          }
        }
      }
    }
  }
</style>