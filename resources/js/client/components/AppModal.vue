<template>
  <el-dialog
    :visible.sync="isModalVisible"
    :class="className"
    :show-close="closeable"
    :close-on-click-modal="closeable"
    :close-on-press-escape="closeable"
    :top="top"
    append-to-body
    class="modal"
    width="86%"
  >
    <template v-slot:title>
      <app-text
        :text="title"
        type="title"
        class="modal-title"
      />
    </template>

    <slot />

    <slot name="help" />

    <div class="modal-footer">
      <slot name="footer" />
    </div>
  </el-dialog>
</template>

<script>
  import AppText from './AppText'

  export default {
    name: 'AppModal',

    components: {
      AppText,
    },

    props: {
      title: {
        type: String,
        default: '',
      },

      visible: {
        type: Boolean,
        default: false,
      },

      role: {
        type: String,
        default: 'default',
      },

      top: {
        type: String,
        default: '30px',
      },

      closeable: {
        type: Boolean,
        default: true,
      },

      noFooter: {
        type: Boolean,
        default: false,
      },

      help: {
        type: Boolean,
        default: false,
      },
    },

    computed: {
      isModalVisible: {
        get() {
          return this.visible
        },

        set(val) {
          this.$emit('close')
        },
      },

      className() {
        let result = [this.role]

        if (this.noFooter) {
          result.push('no-footer')
        }

        if (this.help) {
          result.push('help-modal')
        }

        if (this.$slots.help) {
          result.push('with-steps')
        }

        return result.join(' ')
      },
    },
  }
</script>

<style lang="scss" scoped>
  .modal {
    &-title {
      margin: 0;
    }

    &-footer {
      position: absolute;
      z-index: 1;
      left: 0;
      right: 0;
      bottom: -24px;
      text-align: right;
    }
  }
</style>

<style lang="scss">
  @import '../../../sass/_variables.scss';

  .modal {
    .el-dialog {
      max-width: 350px;
      max-height: 680px;
      background: $color-secondary-light;
      border-radius: $radius-rect;
      border-width: 8px;
      border-style: solid;
      border-color: $color-secondary;
      box-shadow:
        0 0 10px $shadow-1,
        inset 0 2px 4px $shadow-4;
    }

    &.help-modal {
      .el-dialog {
        height: 100%;
      }
    }

    .el-dialog__headerbtn {
      border-radius: 50%;
      border: solid $color-light 3px;
      box-shadow:
        0 4px 0 darken($color-danger, 10%),
        0 3px 5px $shadow-5;
      text-shadow:
        -2px 0 darken($color-danger, 10%),
        0 2px darken($color-danger, 10%),
        2px 0 darken($color-danger, 10%),
        0 -2px darken($color-danger, 10%);
      background-color: $color-danger;
      padding: 0;
      height: 46px;
      width: 46px;
      color: $color-text-inverse;
      overflow: hidden;
      user-select: none;
      outline: none;
      cursor: pointer;
      display: inline-flex;
      flex-direction: row;
      justify-content: center;
      align-items: center;
      top: -24px;
      right: -24px;

      i {
        position: relative;
        z-index: 3;
        font-size: 24px;
        font-weight: 600;
        color: $color-text-inverse;
      }

      &:after {
        content: "";
        position: absolute;
        z-index: 0;
        left: 0;
        right: 0;
        top: 4px;
        bottom: 45%;
        background-color: $color-danger-light;
        border-radius: 6px;
        box-shadow: 0 -4px 0 lighten($color-danger-light, 10%);
      }

      &:before {
        content: "";
        position: absolute;
        z-index: 1;
        top: -7px;
        left: -7px;
        background-color: $glow-5;
        display: block;
        width: 20px;
        height: 20px;
        border-radius: 50%;
      }

      &:hover {
        background: lighten($color-danger, 5%);

        &:after {
          background-color: lighten($color-danger-light, 5%);
          box-shadow: 0 -4px 0 lighten($color-danger-light, 15%);
        }

        i {
          color: $color-text-inverse;
        }
      }

      &:active {
        box-shadow: 0 1px 4px $shadow-3;
        margin-top: 4px;

        i {
          color: $color-text-inverse;
        }
      }
    }

    .el-dialog__body {
      word-break: normal;
      padding: 0 20px 10px;
      max-height: calc(100% - 130px);
      overflow: auto;
      margin-bottom: 40px;
    }

    &.with-steps {
      .el-dialog__body {
        padding-bottom: 65px;
      }
    }

    &.no-footer {
      .el-dialog__body {
        padding-bottom: 20px;
        margin: 0;
      }
    }

    .modal-footer {
      & > *:not(:last-child) {
        margin-right: 5px;
      }
    }
  }

  @media (max-width: 768px) {
    .modal {
      display: flex;
      align-items: center;
      justify-content: center;
      max-height: 100%;

      .el-dialog {
        margin-top: 0 !important;
        max-height: calc(100% - 70px);
        margin: 30px auto 40px;

        .el-dialog__body {
          padding: 0 20px 10px;
          max-height: calc(100vh - 190px);
          overflow: auto;
          margin-bottom: 40px;
        }
      }

      &.no-footer {
        .el-dialog__body {
          padding-bottom: 20px;
          margin: 0;
        }
      }

      &.help-modal {
        .el-dialog {
          height: calc(100% - 70px);
        }

        &.with-steps {
          .el-dialog__body {
            max-height: calc(100% - 144px);
          }
        }
      }
    }
  }
</style>