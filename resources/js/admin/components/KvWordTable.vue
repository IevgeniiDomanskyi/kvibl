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
      label="Слово"
      property="value"
    >
      <template slot-scope="scope">
        <span
          v-if="editId != scope.row.id"
        >
          {{ scope.row.value }}
        </span>

        <app-input
          v-else
          v-model="word.value"
          size="mini"
          placeholder="Введіть слово"
        />
      </template>
    </el-table-column>
    
    <el-table-column
      label="К-сть показів"
      property="count_show"
      align="center"
      sortable
    />
    
    <el-table-column
      label="К-сть вгадувань"
      property="count_success"
      align="center"
      sortable
    />
    
    <el-table-column
      label="Активне"
      property="is_active"
      align="center"
      sortable
    >
      <template
        slot-scope="scope"
      >
        <span
          v-if="editId != scope.row.id" 
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

        <span
          v-else
        >
          <el-switch
            v-model="word.is_active"
          />
        </span>
      </template>
    </el-table-column>

    <el-table-column
      align="center"
    >
      <template slot="header" slot-scope="scope">
        <el-input
          v-model="search"
          placeholder="Пошук слова"/>
      </template>

      <template slot-scope="scope">
        <app-tooltip
          v-if="editId != scope.row.id"
          content="Редагувати слово"
        >
          <app-button
            type="warning"
            icon="el-icon-edit"
            size="mini"
            @click="onEdit(scope.row)"
          />
        </app-tooltip>

        <div
          v-else
        >
          <app-tooltip
            content="Зберегти зміни"
          >
            <app-button
              type="success"
              icon="el-icon-check"
              size="mini"
              @click="onSave(scope.row)"
            />
          </app-tooltip>

          <app-tooltip
            content="Скасувати"
          >
            <app-button
              type="danger"
              icon="el-icon-close"
              size="mini"
              @click="onCancel(scope.row)"
            />
          </app-tooltip>
        </div>
      </template>
    </el-table-column>
  </el-table>
</template>

<script>
  import { AppButton, AppInput, AppTooltip } from '../components'
  
  export default {
    name: 'KvWordTable',
    
    components: {
      AppButton,
      AppInput,
      AppTooltip,
    },

    description: 'Words table component',
    
    token: '<kv-word-table></kv-word-table>',

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
        word: {
          id: null,
          value: '',
          is_active: 0,
        },
        editId: false,
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

      onEdit(val) {
        this.word = {
          id: val.id,
          value: val.value,
          is_active: val.is_active ? true : false,
        }
        
        this.editId = val.id;
      },

      onSave() {
        this.$emit('edit', this.word)
        this.word = {
          is_active: 0,
          value: '',
        }
        this.editId = false;
      },

      onCancel(val) {
        this.word = {
          is_active: 0,
          value: '',
        }
        this.editId = false;
      },
    },
  }
</script>

<style lang="scss">
  .button-wrapper {
    margin-right: 10px;
  }
</style>