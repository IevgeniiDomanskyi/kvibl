export default {
  install(Vue, options) {
    Vue.prototype.$p_size = (points) => {
      return points + (typeof points == 'number' ? 'px' : '')
    }

    Vue.prototype.$p_image = (file) => {
      const image = require.context('../assets/img/', false, /\.png$/)
      return image('./' + file + ".png")
    }

    Vue.prototype.$p_event = (event, callback) => {
      window.addEventListener(event, callback, false)
    }
  },
}