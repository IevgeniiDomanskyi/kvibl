<template>
  <div class="round-word">
    <app-text
      v-if="type == 0"
      :text="word"
      size="large"
      align="center"
    />

    <component
      v-else
      :is="wordComponent"
      :word="word"
    />
  </div>
</template>

<script>
  import AppText from "./AppText"
  import KvVirusWord1 from "./KvVirusWord1"
  import KvVirusWord2 from "./KvVirusWord2"
  import KvVirusWord3 from "./KvVirusWord3"
  import KvVirusWord4 from "./KvVirusWord4"
  import KvVirusWord5 from "./KvVirusWord5"
  import KvVirusWord6 from "./KvVirusWord6"

  export default {
    name: 'KvRoundWord',

    components: {
      AppText,
      KvVirusWord1,
      KvVirusWord2,
      KvVirusWord3,
      KvVirusWord4,
      KvVirusWord5,
      KvVirusWord6,
    },

    props: {
      word: {
        type: String,
        required: true,
      },

      type: {
        type: Number,
        default: 0,
      },
    },

    computed: {
      wordComponent() {
        if (this.type > 0) {
          return 'KvVirusWord' + this.type
        }

        return null
      },
    },
  }
</script>