export default {
  app: null,

  install(Vue, options) {
    this.init()

    Vue.prototype.$kvibl = this
  },

  init() {
    if (typeof KviblApp != 'undefined') {
      this.app = KviblApp
    }
  },

  isApp() {
    return this.app != null
  },

  cameraPermission(callback) {
    const name = callback.name.replace('bound ', '')
    window[name] = callback
    this.app.cameraPermission(name)
  },

  getLocale() {
    return this.app.getLocale()
  },

  isLoggedIn() {
    let data = this.app.isLoggedIn()
    data = JSON.parse(data)
    return data
  },

  login(callback) {
    const name = callback.name.replace('bound ', '')
    window[name] = callback
    this.app.login(name)
  },

  logout(callback) {
    const name = callback.name.replace('bound ', '')
    window[name] = callback
    this.app.logout(name)
  },
}