<template>
  <div>
    <h2>Категорії</h2>
    
    <h2 class="content-header-section">
      <div>
        <app-input-file 
          text="Імпортувати категорії"
          icon="el-icon-upload"
          :requestUrl="requestUrl"
          @success="onFileSubmit($event)"
        />

        <app-button
          text="Експортувати категорії"
          type="warning"
          icon="el-icon-download"
          @click="forceFileDownload"
        />
      </div>

      <div>
        <app-button
          text="Додати категорію"
          type="success"
          icon="el-icon-plus"
          @click="addCategory"
        />

        <app-button
          text="Видалити"
          type="danger"
          icon="el-icon-delete"
          :disabled="! selectedItems.length"
          @click="deleteCategory"
        />
      </div>
    </h2>

    <kv-category-table 
      :data="categories"
      v-loading="isLoaderShow"
      @select="handleSelect($event)"
      @add="addWord($event)"
    />

    <kv-create-category-form
      :openModal="openModal"
      @close="onClose($event)"
      @submit="onSubmit($event)"
    />

    <kv-create-word-form 
      :openModal="openWordModal"
      @close="onCloseWord($event)"
      @submit="onWordCreate($event)"
    />
  </div>
</template>

<script>
  import { mapActions, mapState } from 'vuex'
  import { 
    AppButton,
    AppInputFile,
    KvCategoryTable,
    KvCreateCategoryForm,
    KvCreateWordForm,
  } from '../components'
  
  export default {
    name: 'Categories',

    components: {
      AppButton,
      AppInputFile,
      KvCategoryTable,
      KvCreateCategoryForm,
      KvCreateWordForm,
    },

    data() {
      return {
        isLoaderShow: true,
        openModal: false,
        openWordModal: false,
        selectedItems: '',
        category_id: 0,
        exportUrl: window.location.origin + '/admin/v1/category/export',
        url: window.location.origin + '/storage/categories.kvb',
        requestUrl: window.location.origin + '/admin/v1/category/upload',
      }
    },

    computed: {
      ...mapState({
        categories: state => state.categories.categories,
        token: state => state.auth.token,
        words: state => state.words.words,
      }),
    },

    created() {
      this['categories/all']().then(response => {
        this.isLoaderShow = false
        this['words/clear']()
      })
    },

    methods: {
      ...mapActions([
        'categories/import',
        'categories/all',
        'categories/add',
        'categories/delete',
        'words/add',
        'words/clear',
      ]),

      forceFileDownload(){
        let params = {
          method: 'GET',
          headers: {
            Authorization: 'Bearer ' + this.token,
          },
        }
        
        fetch(this.exportUrl, params)
        .then(response => {
          if (response.ok) {
            let anchor = document.createElement('a');
            anchor.href = this.url;
            anchor.download = this.url;
            anchor.setAttribute('download', 'categories.kvb')
            document.body.appendChild(anchor);
            anchor.click();
          }
        })
      },

      addCategory() {
        this.openModal = true        
      },
      
      deleteCategory() {
        let tempArray = []
        let data = {}

        for (const item of this.selectedItems) {
          tempArray.push(item.id)
        }

        data.ids = tempArray

        this['categories/delete'](data)
      },

      onClose(val) {
        this.openModal = val
      },
      
      handleSelect(val) {
        this.selectedItems = val
      },

      onFileSubmit(val) {
        this['categories/import'](val)
      },

      onSubmit(val) {
        this['categories/add'](val)
      },

      addWord(val) {
        this.category_id = val;
        this.openWordModal = true
      },

      onCloseWord(val) {
        this.openWordModal = val
      },

      onWordCreate(val) {
        val.category_id = this.category_id
        this['words/add'](val).then(response => {
          this['categories/all']()
        });
      },
    },
  }
</script>

<style lang="scss">
  .content-header-section {
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    justify-content: space-between;
    align-content: space-between;
    align-items: flex-start;
  }

  @media (max-width: 768px) {
    .content-header-section {

      & .el-button+.el-button {
        margin: 0;
      }
    }
  }
</style>