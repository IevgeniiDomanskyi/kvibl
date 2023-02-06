<template>
  <el-dialog
    :title="title"
    :visible.sync="showModal"
    custom-class="kvibl-modal"
    append-to-body
  >
    <slot></slot>
    <span slot="footer" class="dialog-footer">
      <el-button
        :v-if=" ! hideCancel"
        @click="showModal = false"
      >
        Відмінити
      </el-button>
      
      <el-button
        v-if=" ! hideCancel"
        type="primary"
        @click="onSubmit"
      >
        Гаразд
      </el-button>
    </span>
  </el-dialog>
</template>

<script>  
  export default {
    name: 'AppModal',

    description: 'Displays the Modal component',
    
    token: '<app-modal></app-modal>',

    props: {
      title: {
        type: String,
        default: '',
        note: 'Set the title of modal window.'
      },
      
      openModal: {
        type: Boolean,
        default: false,
        note: 'Visibility of modal window.'
      },
      
      hideCancel: {
        type: Boolean,
        default: true,
        note: 'Whether to show Cancel button in modal window.'
      },
      
      hideSubmit: {
        type: Boolean,
        default: true,
        note: 'Whether to show Submit (OK) button in modal window.'
      },
    },

    computed: {
      showModal: {
        get: function() {
          return this.openModal
        },
        set: function(val) {
          this.$emit('close', val)
        }
      }
    },

    methods: {
      onSubmit() {
        this.$emit('submit', val)
      },
    },
  }
</script>

<style lang="scss">
  .el-dialog {
    &.kvibl-modal {
      width: 460px;
    }
  }

  @media (max-width: 768px) {
    .el-dialog {
      &.kvibl-modal {
        width: 100%;
      }
    }
  }
</style>