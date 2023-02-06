<template>
  <app-modal
    class="categoryModal"
    title="Додати категорію"
    :openModal="showModal"
    @close="onClose($event)"
    @submit="onSubmit($event)"
    hideSubmit
  >
    <div
      v-for="locale in locales"
      :key="locale.id"
    >
      <app-input-label
        :title="nameInputTitle(locale)"
      >
        <app-input
          ref="name"
          v-model="category.name[locale.id]"
          type="text"
          name="name"
          placeholder="Введіть назву категорії"
        />
      </app-input-label>

      <app-input-label
        :title="descriptionInputTitle(locale)"
      >
        <app-input
          v-model="category.description[locale.id]"
          type="textarea"
          rows="2"
          name="description"
          placeholder="Введіть опис категорії"
        />
      </app-input-label>
    </div>

    <div class="input-wrapper">
      <app-checkbox
        label="Активна"
        :value="category.is_active"
        @click="setActive($event)"
      />
      
      <app-checkbox
        label="Безкоштовна"
        :value="category.is_free"
        @click="setFree($event)"
      />
    </div>

    <app-input-label
      title="Зображення категорії"
    >
      <app-input-file 
        text="Завантажити зображення"
        icon="el-icon-upload"
        :requestUrl="requestUrl"
        :autoUpload="false"
        @change="onFileUpload($event)"
        listType="picture"
        showFileList
        :limit="1"
      />
    </app-input-label>

    <app-button
      text="Додати"
      type="success"
      @click="onSubmit"
    />
  </app-modal>
</template>

<script>
  import { mapActions, mapState } from 'vuex'
  import {
    AppButton,
    AppInput,
    AppInputFile,
    AppInputLabel,
    AppModal,
    AppSelect,
    AppCheckbox
  } from '../components'

  export default {
    name: 'KvCreateCategoryForm',

    description: 'Form for creating new category',

    token: '<kv-create-category-form></kv-create-category-form>',

    components: {
      AppButton,
      AppInput,
      AppInputFile,
      AppInputLabel,
      AppModal,
      AppSelect,
      AppCheckbox,
    },

    props: {
      openModal: {
        type: Boolean,
        default: false,
        note: 'Whether to show modal'
      }
    },

    data() {
      return {
        category: {
          name: [],
          description: [],
          is_active: false,
          is_free: false,
        },
        requestUrl: window.location.origin + '/admin/v1/category/image/upload',
      }
    },

    computed: {
      ...mapState({
        locales: state => state.locales.locales,
      }),

      showModal: {
        get: function() {
          return this.openModal
        },
        set: function(val) {          
          this.$emit('close', val)
        }
      },

      localeOptions() {
        let tempArray = []

        for (const key in this.locales) {
          let tempObj = {}
          tempObj.label = this.locales[key].name
          tempObj.value = this.locales[key].id
          tempArray.push(tempObj)
        }

        return tempArray;
      },
    },

    created() {
      this['locales/all']()
    },
    
    methods: {
      ...mapActions([
        'locales/all',
      ]),

      setLocale(val) {
        this.category.locale_id = val
      },
      
      setActive(val) {
        this.category.is_active = val
      },
      
      setFree(val) {
        this.category.is_free = val
      },

      onClose(val) {
        this.showModal = val
      },
      
      onSubmit() {
        this.$emit('submit', this.category)
        this.category = {
          name: [],
          description: [],
          is_active: false,
          is_free: false,
        }
      },
      
      onFileUpload(e) {
        console.log(e)
        this.category.cover_image = e
      },

      nameInputTitle(code) {
        let title = 'Назва категорії (' + (code.name) + ')'
        return title
      },

      descriptionInputTitle(code) {
        let title = 'Опис категорії (' + (code.name) + ')'
        return title
      },
    },
  }
</script>

<style lang="scss" scoped>
  .input-wrapper {
    margin-bottom: 30px;
  }
</style>