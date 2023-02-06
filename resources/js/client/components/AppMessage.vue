<template>
  <div />
</template>

<script>
  import { mapState, mapMutations } from 'vuex'

  export default {
    name: 'AppMessage',

    computed: {
      ...mapState({
        messages: state => state.messages.list,
      }),
    },

    watch: {
      messages(val, oldVal) {
        // Checking message store and if some message come to it trying to show message
        if (val.length) {
          for (const message of val) {
            if ( ! message.text && ! message.type) {
              // If message has not our format just print it in console
              console.log('*** MESSAGE:', message)
            } else {
              // Showing message
              this.$message({
                message: message.text,
                type: message.type,
                center: true,
                customClass: 'app-message',
                offset: 10,
                showClose: true,
              })
            }
          }

          // Clear messages store after all messages were shown
          this['messages/clear']()
        }
      },
    },

    methods: {
      ...mapMutations([
        'messages/clear',
      ]),
    },
  }
</script>

<style lang="scss">
  @import '../../../sass/_variables.scss';

  .app-message {
    &.el-message {
      max-width: 350px;
      min-width: 240px;
      width: 96%;
      border-radius: $radius-rect;
      border-width: 5px;
      border-style: solid;
      border-color: $color-light;
      box-shadow: 0 0 10px $shadow-7;

      .el-message__content {
        font-size: 14px;
        font-family: $font-text;
        color: $color-text-inverse;
      }

      .el-message__closeBtn {
        color: $color-text-inverse;

        &:hover {
          color: $color-text-inverse;
          opacity: 0.7;
        }
      }
    }

    &.el-message--error {
      background-color: $color-danger;

      .el-icon-error {
        color: $color-text-inverse;
        font-size: 24px;
      }
    }

    &.el-message--success {
      background-color: $color-success;

      .el-icon-success {
        color: $color-text-inverse;
        font-size: 24px;
      }
    }

    &.el-message--info {
      background-color: $color-default;

      .el-icon-info {
        color: $color-text-inverse;
        font-size: 24px;
      }
    }

    &.el-message--warning {
      background-color: $color-warning;

      .el-icon-warning {
        color: $color-text-inverse;
        font-size: 24px;
      }
    }
  }
</style>