<template>
  <el-button 
    :type="type"
    :disabled="disabled"
    :size="size"
    @click="onClick"
    :icon="icon"
  >
    <span v-if="text">
      {{ text }}
    </span>
  </el-button>
</template>

<script>
  export default {
    name: 'AppButton',
    
    description: 'Displays the button',
    
    token: '<app-button type="primary" text="Text"></app-button>',

    props: {
      type: {
        type: String,
        default: 'primary',
        note: 'Set the type of button. Possible values: primary / success / warning / danger / info / text.',
      },
      
      size: {
        type: String,
        default: '',
        note: 'Set the size of button. Possible values: medium / small / mini.',
      },
      
      text: {
        type: String,
        default: '',
        note: 'Set the text for button.',
      },
      
      disabled: {
        type: Boolean,
        default: false,
        note: 'Toggle "disabled" attribute for button.',
      },
      
      icon: {
        type: String,
        default: '',
        note: 'Set the icon class to the button.',
      },
    },

    methods: {
      onClick() {
        this.$emit('click')
      }
    },
  }
</script>
