<template>
  <div class="virus-2-box">
    <span
      v-for="letter in letters"
      :key="letter.position"
      class="kv-word virus-2-item"
    >
      {{ letter.value }}
    </span>
  </div>
</template>

<script>
  export default {
    name: 'KvVirusWord2',

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
    },
  }
</script>

<style lang="scss" scoped>
  .virus-2-box {
    display: flex;
    flex-direction: row;
    justify-content: center;
    transform: rotate(180deg) scaleX(-1);
    filter: FlipH;

    .virus-2-item {
      animation: shake 0.01s both infinite;
      transform: translate3d(16px, 0, 0);
      backface-visibility: hidden;
      perspective: 1000px;
      text-transform: lowercase;
    }
  }

  @keyframes shake {
    0% {
      transform: translate3d(16px, 0, 0);
    }

    100% {
      transform: translate3d(-16px, 0, 0);
    }
  }
</style>