<template>
  <timer
    :class="{danger: dangerClass}"
    :value="convertTime"
    :options="options"
  />
</template>

<script>
  import Timer from 'svg-progress-bar'

  export default {
    name: 'KvRoundTime',

    components: {
      Timer,
    },

    props: {
      start: {
        type: Boolean,
        default: false,
      },

      duration: {
        type: Number,
        required: true,
      },

      current: {
        type: Number,
        required: true,
      },

      danger: {
        type: Number,
        default: 0,
      },

      size: {
        type: Number,
        default: 50,
      },

      stop: {
        type: Boolean,
        default: false,
      },
    },

    data() {
      return {
        dangerClass: false,
        timeLeft: 0,
        timer: 0,

        options: {
          duration: 0,
          circleLinecap: 'round',
        },
      }
    },

    computed: {
      convertTime() {
        return this.duration - this.timeLeft
      },
    },

    created() {
      let duration = this.duration
      this.timeLeft = this.current

      this.options.maxValue = this.duration
      this.options.circleWidth = 5
      this.options.radius = Math.round(this.size / 2)
      this.options.text = function (value) { return this.htmlifyNumber(duration - value) }

      if (this.start) {
        this.countdown()
      }
    },

    watch: {
      stop(val) {
        if (val) {
          clearInterval(this.timer)
          this.timeLeft = 0
        }
      },
    },

    methods: {
      countdown() {
        const time = Math.floor(new Date().getTime() / 1000)
        this.timeLeft = this.current

        this.timer = setInterval(() => {
          const now = Math.floor(new Date().getTime() / 1000)
          this.timeLeft = Math.round(this.current - (now - time))

          this.$emit('update', this.timeLeft)

          if (this.timeLeft <= this.danger) {
            this.dangerClass = true
          }

          if (this.timeLeft <= 0) {
            clearInterval(this.timer)
            this.$emit('complete')
          }
        }, 1000)
      },
    },
  }
</script>

<style lang="scss">
  @import '../../../sass/_variables.scss';

  .circles-wrap {
    svg {
      background: $modal-bg;
      border-radius: 50%;
      box-shadow: 0 2px 5px $modal-shadow;
    }
  }

  .circles-valueStroke {
    stroke: $success !important;
  }

  .circles-text {
    .circles-integer {
      color: $text !important;
      font-family: $font !important;
      font-size: 22px !important;
      font-weight: 600 !important;
    }
  }

  .danger {
    .circles-valueStroke {
      stroke: $danger !important;
    }

    .circles-text {
      color: $danger !important;
    }
  }
</style>