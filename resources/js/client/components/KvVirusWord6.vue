<template>
  <div
    class="kv-word virus-6"
  >
    {{ word }}
  </div>
</template>

<script>
  export default {
    name: 'KvVirusWord6',

    props: {
      word: {
        type: String,
        required: true,
      },
    },
  }
</script>

<style lang="scss" scoped>
  .virus-6 {
    text-transform: lowercase;
    color: transparent;
    text-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
    animation: blur 4s infinite alternate;
  }

  @keyframes blur {
    0% {
      text-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
    }

    100% {
      text-shadow: 0 0 6px rgba(0, 0, 0, 0.5);
    }
  }
</style>