<template>
  <el-form :label-position="position">
    <el-form-item
      :label="title"
      :label-width="width"
    >
      <slot />
    </el-form-item>
  </el-form>
</template>

<script>
  export default {
    name: 'AppInputLabel',
    
    description: 'Wrapper for input that displays text label and add margin to bottom of input',
    
    token: '<app-input-label labelTitle="Title" labelPosition="left" labelWidth="70px"></app-input-label>',

    props: {
      title: {
        type: String,
        default: '',
        note: 'Displays the text label near input',
      },
      position: {
        type: String,
        default: 'top',
        note: 'Set the position of label that will be displayed near input. Possible values: top / left / right. When using "left" or "right" - width prop is required',
      },
      width: {
        type: String,
        require: false,
        note: 'Set the width of label. Example: 50px',
      },
    },
  }
</script>