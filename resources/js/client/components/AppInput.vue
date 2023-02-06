<template>
  <div
    :class="classNameParent"
    @keypress.enter="onSubmit"
  >
    <el-input
      v-model="input"
      :type="type"
      :placeholder="placeholder"
      :autofocus="autofocus"
      :class="className"
    >
      <i
        v-if="icon"
        :class="icon"
        slot="prefix"
      />
    </el-input>
  </div>
</template>

<script>
  export default {
    name: 'AppInput',

    props: {
      value: {
        type: String,
        default: '',
      },

      type: {
        type: String,
        default: 'text',
      },

      role: {
        type: String,
        default: '',
      },

      align: {
        type: String,
        default: 'left',
      },

      title: {
        type: Boolean,
        default: false,
      },

      placeholder: {
        type: String,
        default: '',
      },

      autofocus: {
        type: Boolean,
        default: false,
      },

      icon: {
        type: String,
        default: null,
      },

      bottomSpace: {
        type: Boolean,
        default: false,
      },

      error: {
        type: Boolean,
        default: false,
      },
    },

    computed: {
      input: {
        get() {
          return this.value
        },

        set(val) {
          this.$emit('input', val)
        },
      },

      classNameParent() {
        let result = ['kv-input']

        if (this.bottomSpace) {
          result.push('bottom-space')
        }

        return result.join(' ')
      },

      className() {
        let result = [this.align]

        if (this.role) {
          result.push(this.role)
        }

        if (this.title) {
          result.push('title')
        }

        if (this.error) {
          result.push('error')
        }

        return result.join(' ')
      },
    },

    methods: {
      onSubmit() {
        this.$emit('submit')
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .kv-input {
    border: solid $color-secondary-dark 3px;
    border-top: 0;
    height: 10px;
    position: relative;
    z-index: 0;
    margin-top: 40px;
    text-align: left;
  }

  .bottom-space {
    margin-bottom: 15px;
  }
</style>

<style lang="scss">
  @import '../../../sass/_variables.scss';

  .el-input {
    position: absolute;
    bottom: 0;
  }

  .el-input__inner {
    font-family: $font-text;
    font-size: 16px;
    font-weight: 600;
    border-width: 0;
    background: transparent;
    color: $color-text;
    width: 100%;
    height: 30px;
    caret-color: $color-text;

    &:hover,
    &:focus {
      border-width: 0;
    }

    &::placeholder {
      color: $color-placehoder;
      opacity: 1;
    }

    &:-ms-input-placeholder {
      color: $color-placehoder;
    }

    &::-ms-input-placeholder {
      color: $color-placehoder;
    }
  }

  .center {
    .el-input__inner {
      text-align: center;
    }
  }

  .title {
    .el-input__inner {
      font-family: $font-title;
      font-size: 24px;
    }
  }

  .el-input--prefix {
    .el-input__inner {
      padding-left: 35px;
    }
  }

  .el-input__prefix {
    color: $color-secondary-dark;
    font-size: 15px;
    padding-top: 3px;
    padding-left: 5px;
  }

  .error .el-input__inner {
    box-shadow: inset 0 0 2px $red;
    border-color: $red;
  }
</style>