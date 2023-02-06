<template>
  <el-dropdown
    :trigger="openTrigger"
    :placement="position"
    @command="handleCommand"
  >
    <span class="el-dropdown-link">
      {{ text }}<i class="el-icon-arrow-down el-icon--right"></i>
    </span>
    
    <el-dropdown-menu slot="dropdown" :placement="position">
      <el-dropdown-item
        v-for="(item, index) in dropdownItems"
        :key="index"
        :command="item.value"
      >{{ item.name }}</el-dropdown-item>
    </el-dropdown-menu>
  </el-dropdown>
</template>

<script>
  export default {
    name: 'AppDropdown',

    description: 'Dropdown element',
    
    token: '<app-dropdown></app-dropdown>',

    props: {
      text: {
        type: String,
        default: '',
        note: 'Set the text for dropdown element.'
      },
      openTrigger: {
        type: String,
        default: 'hover',
        note: 'Set the action which will trigger the dropdown. Possible values: hover / click.'
      },
      dropdownItems: {
        type: Object,
        default: function () {
          return {}
        },
        note: 'List of items (object) that should be displayed inside dropdown menu. Example of item: logout: {name: "Logout", value: ""}'
      },
      position: {
        type: String,
        default: 'bottom-end',
        note: 'Set the position of popup menu. Possible values top / top-start / top-end / bottom / bottom-start / bottom-end'
      },
    },

    methods: {
      handleCommand(command) {
        this.$emit(command);
      }
    },
  }
</script>