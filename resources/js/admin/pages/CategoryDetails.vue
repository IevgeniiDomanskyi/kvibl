<template>
  <div>
    <h2>Категорія – «{{ getCategoryName }}»</h2>

    <h2 class="content-header-section">
      <div>
        <app-button
          text="Редагувати категорію"
          type="warning"
          icon="el-icon-edit"
          @click="editCategory"
        />
        
        <app-button
          text="Скинути лічильники"
          type="danger"
          icon="el-icon-refresh"
          :disabled="isLoaderShow"
          @click="resetCounters"
        />
      </div>

      <div>
        <app-button
          text="Додати слово"
          type="success"
          icon="el-icon-plus"
          :disabled="isLoaderShow"
          @click="addWord"
        />

        <app-button
          text="Видалити"
          type="danger"
          icon="el-icon-delete"
          :disabled="! selectedItems.length"
          @click="deleteWord"
        />
      </div>
    </h2>
    
    <kv-word-table
      :data="words"
      v-loading="isLoaderShow"
      @select="handleSelect($event)"
      @edit="updateWord($event)"
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
  import { AppButton, KvWordTable, KvCreateCategoryForm, KvCreateWordForm } from '../components'
  export default {
    name: 'CategoryDetails',

    components: {
      AppButton,
      KvWordTable,
      KvCreateCategoryForm,
      KvCreateWordForm,
    },

    data() {
      return {
        isLoaderShow: true,
        openWordModal: false,
        openCategoryModal: false,
        selectedItems: '',
        addWordUrl: window.location.origin + '/admin/v1/word/add',
        deleteWordUrl: window.location.origin + '/admin/v1/word',
      }
    },

    computed: {
      ...mapState({
        category: state => state.categories.category,
        token: state => state.auth.token,
        words: state => state.words.words,
      }),

      getCategoryName() {
        for (const key in this.category.name) {
          return this.category.name[key]
        }

        return ''
      },
    },

    created() {
      this['categories/get'](this.$route.params.id).then(response => {
        this.isLoaderShow = false
      })
      this['words/all'](this.$route.params.id).then(response => {
        this.isLoaderShow = false
      })
    },

    methods: {
      ...mapActions([
        'categories/get',
        'words/all',
        'words/add',
        'words/update',
        'words/delete',
        'words/reset',
      ]),

      addWord() {
        this.openWordModal = true        
      },
      
      deleteWord() {
        let tempArray = []
        let data = {}

        for (const item of this.selectedItems) {
          tempArray.push(item.id)
        }

        data.ids = tempArray
        data.category_id = this.category.id

        this['words/delete'](data)
      },

      onCloseWord(val) {
        this.openWordModal = val
      },
      
      handleSelect(val) {
        this.selectedItems = val
      },

      updateWord(val) {
        val.category_id = this.category.id
        this['words/update'](val)
      },
      
      editCategory(val) {
        console.log(val);
      },
      
      onWordCreate(val) {
        val.category_id = this.category.id
        this['words/add'](val)
      },
      
      resetCounters() {
        this['words/reset'](this.category.id)
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
</style>