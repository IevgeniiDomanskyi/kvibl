<template>
  <div class="virus-3-box">
    <span
      v-for="letter in letters"
      :key="letter.position"
      class="kv-word virus-3-item"
    >
      {{ letter.value }}

      <small>{{ letter.position }}</small>
    </span>
  </div>
</template>

<script>
  export default {
    name: 'KvVirusWord3',

    props: {
      word: {
        type: String,
        required: true,
      }
    },

    data() {
      return {
        letters: [],
      }
    },

    created() {
      this.splitWord()
      this.shuffleLetters()
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
        }
      },

      shuffleLetters() {
        let currentIndex = this.letters.length, temporaryValue, randomIndex

        while (0 !== currentIndex) {
          randomIndex = Math.floor(Math.random() * currentIndex)
          currentIndex -= 1

          temporaryValue = this.letters[currentIndex]
          this.letters[currentIndex] = this.letters[randomIndex]
          this.letters[randomIndex] = temporaryValue
        }
      }
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .virus-3-box {
    display: flex;
    flex-direction: row;
    justify-content: center;

    .virus-3-item {
      position: relative;
      z-index: 0;
      text-align: center;
      margin: 0 1px;
      text-transform: lowercase;

      small {
        position: absolute;
        z-index: 0;
        top: 100%;
        left: 0;
        right: 0;
        font-size: 50%;
      }
    }
  }
</style>