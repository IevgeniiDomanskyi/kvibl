<template>
  <el-select
    v-model="select"
    :placeholder="placeholder"
  >
    <el-option
      v-for="item in options"
      :key="item.value"
      :label="item.label"
      :value="item.value">
    </el-option>
  </el-select>
</template>

<script>
  export default {
    name: 'AppSelect',

    description: 'Simple select input component',

    token: '<app-select></app-select>',

    props: {
      value: {
        type: Number,
        default: 0,
        note: 'Value of input (v-model).'
      },
      placeholder: {
        type: String,
        default: '',
        note: 'Set the placeholder for select input.'
      },
      
      options: {
        type: Array,
        default: '',
        note: 'Array of options that will be rendered inside select input'
      },
    },

    computed: {
      select: {
        get: function() {
          return this.value
        },
        set: function(val) {
          this.$emit('select', val)
        }
      }
    },
  }
</script>