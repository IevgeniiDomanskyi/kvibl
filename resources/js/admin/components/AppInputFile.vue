<template>
  <el-upload
    class="input-file"
    :action="requestUrl"
    :show-file-list="showFileList"
    :headers="appHeaders"
    :on-success="onSuccess"
    :on-change="onChange"
    :auto-upload="autoUpload"
    :list-type="listType"
    :limit="limit"
  >
    <app-button 
      :type="type"
      :icon="icon"
      :text="text"
    />
  </el-upload>
</template>

<script>
  import { mapState } from 'vuex' 
  import { AppButton } from '../components'

  export default {
    name: 'AppInputFile',
    
    components: {
      AppButton,
    },
    
    description: 'Displays button for uploading the files',
    
    token: '<app-input-file></app-input-file>',

    props: {
      type: {
        type: String,
        default: 'primary',
        note: 'Set the type of button.',
      },
      text: {
        type: String,
        default: '',
        note: 'Set the text for upload button.',
      },
      requestUrl: {
        type: String,
        default: '',
        note: 'Set the URL for processing of file upload.',
      },
      showFileList: {
        type: Boolean,
        default: false,
        note: 'Whether to show file list or no.',
      },
      headers: {
        type: Object,
        default: function() {
          return
        },
        note: 'Set request headers.',
      },
      icon: {
        type: String,
        default: '',
        note: 'Set the icon for upload button.',
      },
      autoUpload: {
        type: Boolean,
        default: true,
        note: 'Whether to upload file immediately or manually by clicking submit.',
      },
      listType: {
        type: String,
        default: '',
        note: 'Set the list type of uploaded files. Possible values: text/picture/picture-card',
      },
      limit: {
        type: Number,
        default: 1,
        note: 'Set the maximum number of uploads.',
      },
    },

    computed: {
      ...mapState({
        token: state => state.auth.token,
      }),

      appHeaders() {
        return {
          'Authorization': 'Bearer ' + this.token
        }
      },
    },

    methods: {
      onSuccess(response) {
        
        this.$emit('success', response)
      },
      
      onChange(file, fileList) {
        this.$emit('change', file)
      },
    },
  }
</script>

<style lang="scss">
  .input-file {
    display: inline-block;
  }
</style>