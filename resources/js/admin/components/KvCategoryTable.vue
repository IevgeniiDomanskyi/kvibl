<template>
  <el-table
    ref="multipleTable"
    :data="data.filter(tableData => ! search || tableData.name[1].toLowerCase().includes(search.toLowerCase()))"
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
    />
    
    <el-table-column
      type="expand"
    >
      <template slot-scope="props">
        {{ props.row.name }}
      </template>
    </el-table-column>
    
    <el-table-column
      label="Назва"
      property="name.1"
    />
    
    <el-table-column
      label="Опис"
      property="description.1"
      show-overflow-tooltip
    />
    
    <el-table-column
      label="Безкоштовна"
      property="is_free"
      align="center"
    >
      <template
        slot-scope="scope"
      >
        <span
          class="boolColumn"
        >
          <i
            v-if="scope.row.is_free"
            class="el-icon-check"
          />
          
          <i
            v-else
            class="el-icon-close"
          />     
        </span>
      </template>
    </el-table-column>
    
    <el-table-column
      label="Активна"
      property="is_active"
      align="center"
    >
      <template
        slot-scope="scope"
      >
        <span
          class="boolColumn"
        >
          <i
            v-if="scope.row.is_active"
            class="el-icon-check"
          />
          
          <i
            v-else
            class="el-icon-close"
          />     
        </span>
      </template>
    </el-table-column>
    
    <el-table-column
      label="К-сть слів"
      property="count_words"
      align="center"
    />
    
    <el-table-column
      align="center"
      width="250"
    >
      <template slot="header" slot-scope="scope">
        <el-input
          v-model="search"
          placeholder="Пошук категорії"/>
      </template>

      <template slot-scope="scope">
        <router-link
          :to="'/admin/categories/' + scope.row.id"
        >
          <app-tooltip
            content="Переглянути слова категорії"
          >
            <app-button
              type="warning"
              icon="el-icon-view"
              size="mini"
            />
          </app-tooltip>
        </router-link>
        
        <app-tooltip
          content="Додати слово до категорії"
        >
          <app-button
            type="success"
            icon="el-icon-plus"
            size="mini"
            @click="addWord(scope.row.id)"
          />
        </app-tooltip>
      </template>
    </el-table-column>
  </el-table>
</template>

<script>
  import { AppButton, AppTooltip } from '../components'
  
  export default {
    name: 'KvCategoryTable',
    
    components: {
      AppButton,
      AppTooltip,
    },

    description: 'Table component',
    
    token: '<app-table></app-table>',

    props: {
      data: {
        type: Array,
        default: '',
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
      toggleSelection(rows) {
        if (rows) {
          rows.forEach(row => {
            this.$refs.multipleTable.toggleRowSelection(row);
          });
        } else {
          this.$refs.multipleTable.clearSelection();
        }
      },

      handleSelectionChange(val) {
        this.$emit('select', val)
      },

      addWord(val) {
        this.$emit('add', val)
      },
    },
  }
</script>

<style lang="scss">
  .button-wrapper {
    margin-right: 10px;
  }
</style>