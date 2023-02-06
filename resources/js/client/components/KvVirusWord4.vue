<template>
  <div class="virus-4-box">
    <span
      v-for="(letter, index) in letters"
      :key="letter.position"
      :class="className(index)"
      class="kv-word virus-4-item"
    >
      {{ letter.value }}
    </span>
  </div>
</template>

<script>
  export default {
    name: 'KvVirusWord4',

    props: {
      word: {
        type: String,
        required: true,
      }
    },

    data() {
      return {
        timer: 0,
        current: 0,
        indexes: [],
        letters: [],
      }
    },

    computed: {
      className() {
        return (n) => {
          return n == this.indexes[this.current] ? 'showing' : ''
        }
      },
    },

    created() {
      this.splitWord()
      this.changeCurrent()
    },

    beforeDestroy() {
      clearTimeout(this.timer)
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

          this.indexes.push(i)
        }

        this.indexes.sort(() => Math.random() - 0.5)
      },

      changeCurrent() {
        this.timer = setTimeout(() => {
          this.current++
          if (this.current == this.indexes.length) {
            this.current = 0
          }

          this.changeCurrent()
        }, 300)
      },
    },
  }
</script>

<style lang="scss" scoped>
  .virus-4-box {
    display: flex;
    flex-direction: row;
    justify-content: center;

    .virus-4-item {
      opacity: 0;
      text-transform: lowercase;
      transition: opacity 0.5s ease 0s;

      &.showing {
        opacity: 1;
      }
    }
  }

  @keyframes blink {
    0% {
      opacity: 1;
    }
    100% {
      opacity: 0;
    }
  }
</style>