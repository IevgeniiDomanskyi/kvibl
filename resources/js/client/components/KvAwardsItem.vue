<template>
  <div
    :class="className"
    @click="onClick"
  >
    <div class="coin__front">
      <img
        v-if="virus"
        :src="image(virus)"
      />

      <i
        v-else
        :class="back"
      />
    </div>
    <div class="coin__edge">
      <div class="coin__edge_image"></div><div class="coin__edge_image"></div><div class="coin__edge_image"></div><div class="coin__edge_image"></div><div class="coin__edge_image"></div><div class="coin__edge_image"></div><div></div><div></div><div></div><div></div>
      <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
      <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
      <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
      <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
      <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
      <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
      <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
    </div>
    <div class="coin__back">
      <i class="fas fa-question" />
    </div>
  </div>
</template>

<script>
  export default {
    name: 'KvAwardsItem',

    props: {
      start: {
        type: Boolean,
        default: false,
      },

      item: {
        type: Number,
        required: true,
      },

      icon: {
        type: String,
        default: 'fas fa-grin-stars',
      },

      award: {
        type: Boolean,
        default: false,
      },

      other: {
        type: Boolean,
        default: false,
      },
    },

    data() {
      return {
        back: 'fas fa-question',
        virus: false,
        isHide: false,
      }
    },

    computed: {
      className() {
        let result = ['coin']

        if (this.start) {
          result.push('start')
        }

        if (this.isHide) {
          result.push('hide')
        }
        
        if (this.award) {
          result.push('award')
        }

        if (this.other) {
          result.push('other')
        }

        return result.join(' ')
      },
    },

    watch: {
      start(val) {
        if (val) {
          setTimeout(() => {
            this.virus = this.icon
            setTimeout(() => {
              this.$emit('opened', this.item)
            }, 1000)
          }, 500)
        }
      },
    },

    methods: {
      image(file) {
        if (file) {
          const image = require.context('../assets/', false, /\.png$/)
          return image('./' + file)
        }

        return null
      },

      onClick() {
        this.$emit('click', this.item)
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  $coin-diameter: 100px;
  $coin-thickness: 5px;
  $coin-color: $gold;
  $coin-front: "";
  $coin-back: "";
  $edge-faces: 80;
  $edge-face-length: 3.14 * $coin-diameter / $edge-faces;
  $turn-time: 1s;

  .coin {
    position: relative;
    width: $coin-diameter;
    height: $coin-diameter;
    margin: 0;
    transform-style: preserve-3d;
    transition: all .3s;

    &.award {
      position: relative;
      z-index: 2;
    }

    &.other {
      position: absolute;
      z-index: 0;
    }
  }

  .coin__front,
  .coin__back {
    position: absolute;
    width: $coin-diameter;
    height: $coin-diameter;
    border-radius: 50%;
    overflow: hidden;
    background-color: $coin-color;
    display: flex;
    align-items: center;
    justify-content: center;

    &:after {
      content: "";
      position: absolute;
      left: -$coin-diameter/2;
      bottom: 100%;
      display: block;
      height: $coin-diameter/1.5;
      width: $coin-diameter*2;
      background: #fff;
      opacity: 0.3;
    }

    i {
      font-size: 60px;
      color: rgba(0, 0, 0, 0.7);
      text-shadow: 1px 1px 2px rgba(255,255, 255, 0.8);
    }

    img {
      max-width: 90%;
      max-height: 90%;
    }
  }

  .coin.start {
    animation: rotate3d $turn-time linear 1;

    .coin__front,
    .coin__back {
      &:after {
        animation: shine linear $turn-time/2 2;
      }
    }
  }

  .coin__front {
    background-image: url($coin-front);
    background-size: cover;
    transform: translateZ($coin-thickness/2);
  }
  .coin__back {
    background-image: url($coin-back);
    background-size: cover;
    transform: translateZ(-$coin-thickness/2) rotateY(180deg);
  }

  .coin__edge {
    @for $i from 1 through $edge-faces {
      div:nth-child(#{$i}) {
        position: absolute;
        height: $edge-face-length;
        width: $coin-thickness;
        background: darken( $coin-color, ( ($i - $edge-faces/2) * ($i - $edge-faces/2)) / ($edge-faces*$edge-faces/4) * 100 * 0.7 );
        transform: 
          translateY(#{$coin-diameter/2-$edge-face-length/2})
          translateX(#{$coin-diameter/2-$coin-thickness/2})
          rotateZ(360deg/$edge-faces*$i+90)
          translateX(#{$coin-diameter/2})
          rotateY(90deg);
      }
    }
  }

  @keyframes rotate3d {
    0% {
      transform: perspective(1000px) rotateY(0deg);
    }

    100% {
      transform: perspective(1000px) rotateY(360deg);
    }
  }

  @keyframes shine {
    0%, 15% {
      transform: translateY($coin-diameter*2) rotate(-40deg);
    }
    50% {
      transform: translateY(-$coin-diameter) rotate(-40deg);
    }
  }

  .coin__edge_image {
    background-image: url(https://placedog.net/540/205);
  }
</style>