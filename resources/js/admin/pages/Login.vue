<template>
  <div>
    <router-view
      v-if="isLoggedIn"
    />
    
    <div v-else>
      <div class="login-wrapper">
        <div class="login-container">
          <div class="logo">
            <img src="/images/logo.png" class="" alt="" />
            <span>kvibl</span>
          </div>

          <el-card class="box-card login-card">
            <app-input-label
              title="Емейл"
              position="left"
              width="70px"
            >
              <app-input
                v-model="auth.email"
                type="email"
                name="email"
                placeholder="Введіть емейл"
                @enterPress="onLogin"
              />
            </app-input-label>

            <app-input-label
              title="Пароль"
              position="left"
              width="70px"
            >
              <app-input
                v-model="auth.password"
                type="password"
                name="password"
                placeholder="Введіть пароль"
                showPassword
                @enterPress="onLogin"
              />
            </app-input-label>
            
            <app-button
              text="Увійти"
              @click="onLogin"
            />
          </el-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapActions, mapState, mapMutations } from 'vuex'
  import { AppButton, AppInput, AppInputLabel } from '../components'

  export default {
    name: 'Login',

    components: {
      AppButton,
      AppInput,
      AppInputLabel,
    },

    data() {
      return {
        auth: {
          email: '',
          password: '',
        },
      }
    },

    computed: {
      ...mapState({
        me: state => state.auth.me,
        token: state => state.auth.token,
      }),

      isLoggedIn() {
        return this.token ? true : false
      },
    },

    created() {
      if (this.isLoggedIn) {
        this['auth/me']()
      } else {
        this['auth/loaderShowSet']()
      }
    },

    methods: {
      ...mapMutations([
        'auth/loaderShowSet',
      ]),
      
      ...mapActions([
        'auth/me',
        'auth/login',
      ]),

      onLogin() {
        this['auth/login'](this.auth)
      },
    },
  }
</script>

<style lang="scss">
  .login-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    text-align: center;
    background-color: #1b1b1b;
    background-position: center;
    
    & .login-container {
      margin-top: -150px;
    }

    & .logo {
      font-family: 'Spartan';
      text-align: center;
      color: #fff;
      font-size: 50px;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-bottom: 25px;
      width: 100px;
      margin: 0 auto;

      & img {
        width: 100%;
        height: auto;
      }
    }
  }
</style>