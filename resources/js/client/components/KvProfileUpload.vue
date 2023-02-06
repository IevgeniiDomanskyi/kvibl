<template>
  <div
    :class="{ loaded: loaded }"
    class="photo"
  >
    <div
      v-show="isCameraPermission"
      ref="container"
      class="profile-upload"
    >
      <div>
        <video
          v-show=" ! image && width > 0"
          :style="'object-fit: cover; width: ' + width + 'px; height: ' + height + 'px;'"
          autoplay
          playsinline
          ref="video"
        />

        <img
          v-show="image"
          :src="image"
          :style="'width: ' + width + 'px; height: ' + height + 'px;'"
        />
      </div>

      <div
        v-if=" ! image"
        class="profile-upload__buttons"
      >
        <app-button
          icon="fas fa-times"
          round
          @click="onClose"
        />

        <app-button
          icon="fas fa-camera"
          round
          large
          mute
          role="warning"
          @click="onSnap"
        />

        <app-button
          icon="fas fa-circle"
          round
          class="button-hidden"
        />
      </div>

      <div
        v-else
        class="profile-upload__buttons"
      >
        <app-button
          icon="fas fa-redo-alt"
          round
          large
          role="danger"
          @click="onResnap"
        />

        <app-button
          icon="fas fa-check"
          round
          large
          role="success"
          @click="onConfirm"
        />
      </div>
    </div>

    <div
      v-show=" ! isCameraPermission"
      class="profile-permissions"
    >
      <div
        v-if="browserCameraDisabled"
        class="profile-permissions__center"
      >
        <app-text
          :text="$t('game.profile.browser_disable_camera')"
          align="center"
          bottom-space
        />

        <app-button
          :label="$t('game.profile.back')"
          role="default"
          @click="onClose"
        />
      </div>

      <div
        v-else
        class="profile-permissions__center"
      >
        <app-text
          :text="$t('game.profile.ask_permission_text')"
          align="center"
          bottom-space
        />

        <app-button
          :label="$t('game.profile.ask_permission')"
          role="danger"
          @click="onAskPermission"
        />
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters, mapMutations } from 'vuex' 
  import AppButton from './AppButton'
  import AppText from './AppText'
  import Game from '../mixins/game'

  export default {
    name: 'KvProfileUpload',

    mixins: [Game],

    components: {
      AppButton,
      AppText,
    },

    data() {
      return {
        loaded: false,

        constraints: {
          video: true,
        },

        video: null,
        stream: null,

        width: 0,
        height: 0,
        ratio: 0,

        image: null,

        browserCameraDisabled: false,
      }
    },

    computed: {
      ...mapGetters([
        'auth/permissionApp',
        'auth/permissionBrowser',
      ]),

      borderRadius() {
        return this.width / 2
      },

      isCameraPermission() {
        let result = 1
        if (this.$kvibl.isApp()) {
          result *= this['auth/permissionApp']('camera')
        }
        return result * this['auth/permissionBrowser']('camera')
      },
    },

    mounted() {
      this.onAskPermission()
    },

    beforeDestroy() {
      if (this.stream) {
        this.stream.getTracks().forEach((track) => {
          track.stop()
        })
      }
    },

    methods: {
      ...mapMutations([
        'auth/permissionAppSet',
        'auth/permissionBrowserSet',
      ]),

      permissionsCallback(result) {
        if (this.$kvibl.isApp()) {
          this['auth/permissionAppSet']({
            type: 'camera',
            permission: result,
          })
        }

        this['auth/permissionBrowserSet']({
          type: 'camera',
          permission: result,
        })

        if (this.isCameraPermission) {
          this.video = this.$refs.video
          this.runStream()
        } else {
          this.loaded = true
        }
      },

      onAskPermission() {
        this.browserHasPermission('camera')

        if ( ! this['auth/permissionBrowser']('camera')) {
          if (this.$kvibl.isApp()) {
            this.$kvibl.cameraPermission(this.permissionsCallback)
          } else {
            navigator.mediaDevices.getUserMedia(this.constraints).then((stream) => {
              stream.getTracks().forEach((track) => {
                track.stop()
              })

              this.permissionsCallback(true)
            }, (error) => {
              this.browserCameraDisabled = true
              this.loaded = true
            })
          }
        } else {
          this.permissionsCallback(true)
        }
      },

      runStream() {
        navigator.mediaDevices.getUserMedia(this.constraints).then((stream) => {
          this.stream = stream
          this.video.srcObject = this.stream
          let {width, height} = this.stream.getTracks()[0].getSettings();
          this.setVideoSize(width, height)

          this.loaded = true
        })
      },

      setVideoSize(width, height, ratio) {
        const scale = width / this.$refs.container.offsetWidth
        this.width = width / scale
        this.height = this.width
        this.ratio = ratio
      },

      onSnap() {
        this.$play('camera')
        this.image = this.cutSquareImage(this.video, this.video.videoWidth, this.video.videoHeight)
      }, 

      onClose() {
        this.$emit('close')
      },

      onResnap() {
        this.image = null
      },

      onConfirm() {
        this.$emit('confirm', this.image)
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .photo {
    height: 100%;
    margin: 15px 20px 30px;
    opacity: 0;
    transition: all 0.3s linear 0s;

    &.loaded {
      opacity: 1;
    }

    .profile-upload {
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;

      video {
        transform: rotateY(180deg);
        -webkit-transform:rotateY(180deg);
        -moz-transform:rotateY(180deg);
        border-radius: 67% 33% 28% 72% / 67% 56% 44% 33%;
        border: solid $avatar-border 8px;
        background-color: $avatar-bg;
        box-shadow: 0 1px 8px $avatar-shadow;
      }

      img {
        border-radius: 33% 67% 72% 28% / 56% 67% 33% 44%;
        border: solid $avatar-border 8px;
        background-color: $avatar-bg;
        box-shadow: 0 1px 8px $avatar-shadow;
      }

      &__buttons {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        align-items: center;

        .button-hidden {
          opacity: 0;
        }
      }
    }

    .profile-permissions {
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;

      &__center {
        text-align: center;
      }
    }
  }
</style>