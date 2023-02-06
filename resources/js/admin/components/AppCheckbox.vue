<template>
  <el-checkbox
    v-model="checkbox"
  >
    {{ label }}
  </el-checkbox>
</template>

<script>
  export default {
    name: 'AppCheckbox',

    description: 'Single chackbox input component',

    token: '<app-checkbox></app-checkbox>',

    props: {
      value: {
        type: Boolean,
        default: false,
        note: 'Value of checkbox input (v-model)'
      },
      label: {
        type: String,
        default: '',
        note: 'Set the text of checkbox label', 
      }
    },

    computed: {
      checkbox: {
        get: function() {
          return this.value
        },
        set: function(val) {
          this.$emit('click', val)
        }
      }
    },
  }
</script>

<style lang="scss" scoped>

</style>