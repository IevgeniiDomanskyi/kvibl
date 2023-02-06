const library = {
  click: require('../assets/sounds/click.mp3'),
  camera: require('../assets/sounds/camera.mp3'),
}

export default {
  store: {},

  install(Vue, options) {
    this.prepare()

    this.store = options.store

    Vue.prototype.$play = (sound) => {
      if ( ! this.store.state.app.mute) {
        if (this.sounds[sound]) {
          this.sounds[sound].load()
          this.sounds[sound].play()
        } else {
          console.log('Unknown sound type ' + sound)
        }
      }
    }
  },

  sounds: {},

  prepare() {
    for (const key in library) {
      this.sounds[key] = new Audio()
      this.sounds[key].src = library[key]
      this.sounds[key].addEventListener('ended', () => { }, false);
      this.sounds[key].load()
    }
  },
}