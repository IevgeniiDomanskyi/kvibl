<template>
  <el-table
    ref="multipleTable"
    :data="data.filter(tableData => ! search || tableData.value.toLowerCase().includes(search.toLowerCase()))"
    style="width: 100%"
    @selection-change="handleSelectionChange"
  >
    <el-table-column
      type="selection"
      width="55"
    />

    <el-table-column
      label="ID"
      property="id"
      width="55"
      align="center"
    />

    <el-table-column
      label="Аватар"
      property="avatar"
      width="80"
    >
      <template slot-scope="scope">
        <el-avatar v-if="scope.row.avatar != ''" :size="60">
          <img :src="scope.row.avatar" />
        </el-avatar>
      </template>
    </el-table-column>

    <el-table-column
      label="Ім'я"
      property="name"
      sortable
    />

    <el-table-column
      label="Email"
      property="email"
    />

    <el-table-column
      label="Зареєстрований"
      property="count_success"
      align="center"
      sortable
    >
      <template slot-scope="scope">
        {{scope.row.is_registered ? 'Так' : 'Ні'}}
      </template>
    </el-table-column>
  </el-table>
</template>

<script>
  import { AppButton, AppInput, AppTooltip } from '../components'

  export default {
    name: 'KvUsersTable',

    components: {
      AppButton,
      AppInput,
      AppTooltip,
    },

    description: 'Users table component',

    props: {
      data: {
        type: Array,
        default: function() {
          return []
        },
        note: 'Fill table with passed data.'
      },
    },

    data() {
      return {
        multipleSelection: [],
        search: '',
      }
    },

    methods: {
      handleSelectionChange(val) {
        this.$emit('select', val)
      },
    },
  }
</script>

<style lang="scss">
  .button-wrapper {
    margin-right: 10px;
  }
</style>
