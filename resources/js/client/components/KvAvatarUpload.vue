<template>
  <div class="avatar-upload">
    <div class="avatar-upload__inner">
      Camera: {{ hasCamera }}<br />
      Can Stream: {{ canCameraStream }}<br />

      <app-avatar
        :image="avatar"
      />

      <!-- <div
        v-if=" ! browserHasUserMedia"
        class="avatar-upload__inner-wrapper"
      >
        <input
          type="file"
          accept="image/*;capture=camera"
          capture="camera"
          ref="file"
          @change="onFileChange"
        />
      </div>
      

      <a
        v-else
        class="avatar-upload__inner-upload"
        @click="onProfileUpload"
      /> -->

      <div
        class="avatar-upload__inner-camera"
      >
        <app-dropdown
          v-if="hasCamera"
          :items="options"
        >
          <app-button
            role="warning"
            icon="fas fa-cog"
            round
          />
        </app-dropdown>

        <div
          v-else
          class="avatar-upload__file"
        >
          <app-button
            role="warning"
            icon="fas fa-cog"
            round
          />

          <input
            ref="file"
            type="file"
            accept="image/*"
            class="avatar-upload__file-input"
            @change="onFileChange"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import DetectRTC from 'detectrtc'
  import AppAvatar from './AppAvatar'
  import AppButton from './AppButton'
  import AppDropdown from './AppDropdown'
  import Game from '../mixins/game'

  export default {
    name: 'KvAvatarUpload',

    mixins: [Game],

    components: {
      AppAvatar,
      AppButton,
      AppDropdown,
    },

    props: {
      avatar: {
        type: String,
        default: null,
      },
    },

    data: () => ({
      DetectRTC: false,
    }),

    computed: {
      hasCamera() {
        return this.DetectRTC.isMobileDevice || ( ! this.DetectRTC.isMobileDevice && this.DetectRTC.hasWebcam)
      },

      canCameraStream() {
        return this.DetectRTC.hasWebcam
      },

      options() {
        return [
          {
            icon: 'fas fa-camera',
            html: `${this.$t('game.profile.camera')}`,
          }, {
            icon: 'fas fa-image',
            html: `${this.$t('game.profile.gallery')}`,
          },
        ]
      },
    },

    created() {
      DetectRTC.load(() => {
        this.DetectRTC = DetectRTC
      })
    },

    methods: {
      onFileChange() {
        this.file = this.$refs.file.files[0]

        const img = document.createElement('img')
        const reader = new FileReader()
        reader.onload = (e) => {
          img.src = e.target.result
          img.onload = (e) => {
            this.profile.avatar = this.cutSquareImage(img, img.width, img.height)
            this.uploadImage(this.profile.avatar)
          }
        }
        reader.readAsDataURL(this.file)
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .avatar-upload {
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

    &__file {
      position: relative;
      width: 51px;
      height: 51px;
      overflow: hidden;

      &-input {
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
  }
</style>