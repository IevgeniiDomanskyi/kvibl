<template>
  <div class="virus-1-box">
    <span
      v-for="(letter, index) in letters"
      :key="letter.position"
      :class="className(index)"
      class="kv-word virus-1-item"
    >
      {{ letter.value }}
    </span>
  </div>
</template>

<script>
  export default {
    name: 'KvVirusWord1',

    props: {
      word: {
        type: String,
        required: true,
      }
    },

    data() {
      return {
        classes: [],
        letters: [],
      }
    },

    computed: {
      className() {
        return (n) => {
          return 'style-' + this.classes[n]
        }
      },
    },

    created() {
      this.splitWord()
    },

    methods: {
      splitWord() {
        const word = this.word
        this.letters = []
        for (let i = 0; i < word.length; i++) {
          this.letters.push({
            value: word[i],
            position: (i + 1),
          })

          this.classes.push(Math.floor(Math.random() * 6))
        }
      },
    },
  }
</script>

<style lang="scss" scoped>
  .virus-1-box {
    display: flex;
    flex-direction: row;
    justify-content: center;

    .virus-1-item {
      text-transform: lowercase;
      animation-duration: 0.3s;
      animation-iteration-count: infinite;
      animation-timing-function: linear;
      animation-direction: normal;

      &.style-0 {
        transform: rotate(90deg);
        animation-name: spin-0;
        animation-duration: 0.1s;
      }

      &.style-1 {
        transform: rotate(180deg) scaleX(-1);
        animation-name: spin-1;
        animation-direction: reverse;
        animation-duration: 0.2s;
      }

      &.style-2 {
        transform: rotate(90deg) scaleX(-1);
        animation-name: spin-2;
        animation-duration: 0.3s;
      }

      &.style-3 {
        transform: rotate(-90deg);
        animation-name: spin-3;
        animation-direction: reverse;
        animation-duration: 0.4s;
      }

      &.style-4 {
        transform: rotate(-180deg);
        animation-name: spin-4;
        animation-duration: 0.5s;
      }

      &.style-5 {
        transform: scaleX(-1);
        animation-name: spin-5;
        animation-direction: reverse;
        animation-duration: 0.6s;
      }
    }
  }

  @keyframes spin-0 {
    0% {
      transform: rotate(90deg);
      opacity: 0;
    }
    50% {
      transform: rotate(270deg);
      opacity: 1;
    }
    100% {
      transform: rotate(450deg);
      opacity: 0;
    }
  }

  @keyframes spin-1 {
    0% {
      transform: rotate(180deg) scaleX(-1);
      opacity: 0;
    }
    50% {
      transform: rotate(360deg) scaleX(-1);
      opacity: 1;
    }
    100% {
      transform: rotate(540deg) scaleX(-1);
      opacity: 0;
    }
  }

  @keyframes spin-2 {
    0% {
      transform: rotate(90deg) scaleX(-1);
      opacity: 0;
    }
    50% {
      transform: rotate(270deg) scaleX(-1);
      opacity: 1;
    }
    100% {
      transform: rotate(450deg) scaleX(-1);
      opacity: 0;
    }
  }

  @keyframes spin-3 {
    0% {
      transform: rotate(-90deg);
      opacity: 0;
    }
    50% {
      transform: rotate(90deg);
      opacity: 1;
    }
    100% {
      transform: rotate(270deg);
      opacity: 0;
    }
  }

  @keyframes spin-4 {
    0% {
      transform: rotate(-180deg);
      opacity: 0;
    }
    50% {
      transform: rotate(0deg);
      opacity: 1;
    }
    100% {
      transform: rotate(180deg);
      opacity: 0;
    }
  }

  @keyframes spin-5 {
    0% {
      transform: rotate(0deg) scaleX(-1);
      opacity: 0;
    }
    50% {
      transform: rotate(180deg) scaleX(-1);
      opacity: 1;
    }
    100% {
      transform: rotate(360deg) scaleX(-1);
      opacity: 0;
    }
  }
</style>