<template>
  <app-modal
    title="Додати слово"
    :openModal="showModal"
    @close="onClose($event)"
    @submit="onSubmit($event)"
    hideSubmit
  >
    <app-input-label
      title="Слово"
    >
      <app-input
        ref="value"
        v-model="word.value"
        type="text"
        name="value"
        placeholder="Введіть слово"
        @enterPress="onSubmit"
      />
    </app-input-label>

    <app-input-label
      title="Мова слова"
    >
      <app-select
        v-model="word.lang_id"
        placeholder="Оберіть мову слова"
        :options="langsOptions"
        @select="setLocale($event)"
      />
    </app-input-label>

    <div class="input-wrapper">
      <app-checkbox
        label="Активне"
        :value="word.is_active"
        @click="setActive($event)"
      />
    </div>

    <app-button
      text="Додати"
      type="success"
      @click="onSubmit"
    />
  </app-modal>
</template>

<script>
  import { mapActions, mapState } from 'vuex'
  import { AppButton, AppInput, AppInputLabel, AppModal, AppSelect, AppCheckbox } from '../components'

  export default {
    name: 'KvCreateWordForm',

    description: 'Form for creating new word',

    token: '<kv-create-word-form></kv-create-word-form>',

    components: {
      AppButton,
      AppInput,
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
        word: {
          value: '',
          lang_id: 3,
          is_active: true,
        },
      }
    },

    computed: {
      ...mapState({
        langs: state => state.langs.langs,
      }),

      showModal: {
        get: function() {
          return this.openModal
        },
        set: function(val) {          
          this.$emit('close', val)
        }
      },

      langsOptions() {
        let tempArray = []

        for (const key in this.langs) {
          let tempObj = {}
          tempObj.label = this.langs[key].name
          tempObj.value = this.langs[key].id
          tempArray.push(tempObj)
        }

        return tempArray;
      },
    },

    created() {
      this['langs/all']()
    },
    
    methods: {
      ...mapActions([
        'langs/all',
        'word/add',
      ]),

      setLocale(val) {
        this.word.lang_id = val
      },
      
      setActive(val) {
        this.word.is_active = val
      },

      onClose(val) {
        this.showModal = val
      },
      
      onSubmit() {
        this.$emit('submit', this.word)
        this.word = {
          value: '',
          lang_id: 3,
          is_active: true,
        }
        
        this.$nextTick(() => this.$refs.value.$el.children[0].children[0].focus())
      },
    },
  }
</script>

<style lang="scss" scoped>
  .input-wrapper {
    margin-bottom: 30px;
  }
</style>