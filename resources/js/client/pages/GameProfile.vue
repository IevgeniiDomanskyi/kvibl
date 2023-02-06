<template>
  <kv-profile-upload
    v-if="browserHasUserMedia && isProfileUploadVissible"
    @confirm="onProfileUploadConfirm"
    @close="onProfileUploadClose"
  />

  <div
    v-else
    class="profile"
  >
    <div>
      <app-text
        :text="$t('game.profile.title')"
        align="center"
        type="title"
        bottom-space
      />

      <kv-avatar-upload />

      <form
        class="profile-form"
        @submit.prevent="onSave"
      >
        <app-input
          v-model="profile.name"
          :placeholder="$t('game.profile.name_placeholder')"
          bottom-space
          @input="onNameInput"
        />
      </form>
    </div>

    <div class="profile-button">
      <app-button
        :label="$t('game.profile.save')"
        role="primary"
        @click="onSave"
      />
    </div>
  </div>
</template>

<script>
  import { mapState, mapMutations, mapActions } from 'vuex'
  import { AppAvatar, AppInput, AppButton, AppText, KvAvatarUpload, KvProfileUpload } from '../components'
  import tabs from '../constants/tabs'
  import Game from '../mixins/game'

  export default {
    name: 'GameProfile',

    mixins: [Game],

    components: {
      AppAvatar,
      AppInput,
      AppButton,
      AppText,
      KvAvatarUpload,
      KvProfileUpload,
    },

    data() {
      return {
        profile: {
          name: '',
          avatar: '',
          status: 0,
        },

        isProfileUploadVissible: false,
        file: null,
      }
    },

    methods: {
      ...mapMutations([
        'messages/set',
        'players/nameSet',
      ]),

      ...mapActions([
        'players/profile',
        'tabs/set',
        'upload/image',
      ]),

      onNameInput(val) {
        this['players/nameSet'](val)
      },

      onProfileUpload() {
        this.isProfileUploadVissible = true
      },

      onProfileUploadClose() {
        this.isProfileUploadVissible = false
      },

      onProfileUploadConfirm(image) {
        this.onProfileUploadClose()

        this.profile.avatar = image
        this.uploadImage(image)
      },

      uploadImage(image) {
        this['upload/image'](image).then(url => {
          this.profile.avatar = url
        })
      },

      onSave() {
        if (this.validateProfile()) {
          if (this.me.is_owner || this.me.lastname == '') {
            this.profile.status = 1
          } else {
            this.profile.status = this.me.status
          }

          this['players/profile'](this.profile).then(profile => {
            if (profile) {
              this['tabs/set'](tabs.LOADING)
            }
          })
        }
      },

      validateProfile() {
        if (this.profile.name.trim() == '') {
          this['messages/set']({
            text: this.$t('game.message.name_empty'),
            type: 'error',
          })

          return false
        }

        return true
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .profile {
    height: 100%;
    padding: 15px 20px 30px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;

    &-avatar {
      text-align: center;
      padding: 15px 0 20px;

      &__inner {
        position: relative;
        z-index: 0;
        display: inline-block;

        & > * {
          position: relative;
          z-index: 0;
        }

        &-wrapper {
          overflow: hidden;
          position: absolute;
          z-index: 1;
          top: 0;
          bottom: 0;
          left: 0;
          right: 0;

          input[type=file] {
            display: block;
            font-size: 150px;
            position: absolute;
            z-index: 0;
            top: 0;
            right: 0;
            cursor: pointer;
            opacity: 0;
          }
        }

        &-upload {
          display: block;
          position: absolute;
          z-index: 1;
          top: 0;
          bottom: 0;
          left: 0;
          right: 0;
        }

        &-camera {
          position: absolute;
          z-index: 0;
          bottom: 0;
          right: 0;
        }
      }
    }

    &-button {
      text-align: center;
    }
  }
</style>