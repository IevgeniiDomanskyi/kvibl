<template>
  <el-tooltip
    class="item"
    :content="content"
    :placement="position"
    :enterable="enterable"
  >
    <slot></slot>
  </el-tooltip>
</template>

<script>  
  export default {
    name: 'AppTooltip',

    description: 'Displays the Tooltip component',
    
    token: '<app-tooltip></app-tooltip>',

    props: {
      position: {
        type: String,
        default: 'top',
        note: 'Set the position of tooltip.'
      },
      
      content: {
        type: String,
        default: '',
        note: 'Set the content for tooltip.'
      },
      
      enterable: {
        type: Boolean,
        default: false,
        note: 'Whether the mouse can enter the tooltip.'
      },
    },
  }
</script>