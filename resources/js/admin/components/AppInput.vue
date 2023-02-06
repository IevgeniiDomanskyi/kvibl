<template>
  <el-form @submit.native.prevent>
    <el-input
      v-model="input"
      :type="type"
      :name="name"
      :placeholder="placeholder"
      :size="size"
      :show-password="showPassword"
      :rows="rows"
      @keyup.enter.native="onPressEnter"
    >
      <slot></slot>
    </el-input>
  </el-form>
</template>

<script>
  export default {
    name: 'AppInput',
    
    description: 'Displays input for enter some data',
    
    token: '<app-input type="text" placeholder="Placeholder" showPassword></app-input>',

    props: {
      value: {
        type: String,
        default: '',
      },
      type: {
        type: String,
        default: 'text',
        note: 'Set the standart input\'s type attribute, such as: text, email, number etc.',
      },
      name: {
        type: String,
        default: '',
        note: 'Set the standart input\'s name attribute.',
      },
      placeholder: {
        type: String,
        default: '',
        note: 'Set the standart input\'s placeholder attribute.',
      },
      size: {
        type: String,
        default: '',
        note: 'Set the size of input. Possible values: medium / small / mini',
      },
      showPassword: {
        type: Boolean,
        default: false,
        note: 'Whether to show toggleable password input',
      },
      rows: {
        type: String,
        default: '',
        note: 'Set the number of row for input type "textarea"',
      },
    },

    computed: {
      input: {
        get: function() {
          return this.value
        },
        set: function(val) {
          this.$emit('input', val)
        }
      }
    },

    mounted() {
      this.input = this.value
    },

    methods: {
      onPressEnter() {
        this.$emit('enterPress')
      },
    },
  }
</script>
