<template>
  <div
    class="viruses"
  >
    <app-text
      :text="$t('game.viruses.title')"
      type="title"
      align="center"
    />

    <div class="viruses-list">
      <div
        v-for="virus in viruses"
        :key="virus.id"
        :class="{ active: virusCount(virus.id) > 0 }"
        class="viruses-item"
      >
        <div
          class="viruses-item__info"
        >
          <div class="viruses-item__info-icon">
            <img
              :src="image(virus.image)"
            />
          </div>

          <div class="viruses-item__info-name">
            <app-text
              :text="virus.name"
              type="title"
            />

            <app-button
              v-if="virusCount(virus.id) > 0"
              :badge="virusCount(virus.id)"
              icon="fas fa-syringe"
              role="success"
              round
              class="viruses-item__info-name_button"
              @click="onVirusClick(virus)"
            />
          </div>
        </div>

        <app-button
          icon="fas fa-info-circle"
          role="default"
          round
          @click="onInfoClick(virus)"
        />
      </div>
    </div>

    <kv-viruses-info-modal
      :visible="isInfoModalVisible"
      :virus="infoVirus"
      @close="onInfoModalClose"
    />

    <kv-viruses-players-modal
      :visible="isVirusModalVisible"
      :virus="playerVirus"
      @close="onVirusModalClose"
    />
  </div>
</template>

<script>
  import { mapState, mapGetters, mapMutations, mapActions } from 'vuex'
  import { AppText, AppButton, KvVirusesPlayersModal, KvVirusesInfoModal } from '../components'
  import Game from '../mixins/game'

  export default {
    name: 'GameAwards',

    mixins: [Game],

    components: {
      AppText,
      AppButton,
      KvVirusesPlayersModal,
      KvVirusesInfoModal,
    },

    data() {
      return {
        isInfoModalVisible: false,
        infoVirus: {},
        isVirusModalVisible: false,
        playerVirus: {},
      }
    },

    computed: {
      ...mapState({
        viruses: state => state.viruses.list,
      }),

      virusCount() {
        return (id) => {
          for (const item of this.me.viruses) {
            if (item.id == id) {
              return item.count
            }
          }

          return 0
        }
      },
    },

    created() {
      if ( ! this.viruses.length) {
        this['viruses/get']()
      }
    },

    methods: {
      ...mapMutations([
        'messages/set',
      ]),

      ...mapActions([
        'viruses/get',
      ]),

      image(file) {
        const image = require.context('../assets/', false, /\.png$/)
        return image('./' + file)
      },

      onVirusClick(virus) {
        if (this.virusCount(virus.id) > 0) {
          if (this.game.lap > 1) {
            this.playerVirus = virus
            this.isVirusModalVisible = true
          } else {
            this['messages/set']({
              text: this.$t('game.viruses.lap'),
              type: 'info',
            })
          }
        } else {
          this['messages/set']({
            text: this.$t('game.viruses.empty'),
            type: 'error',
          })
        }
      },

      onVirusModalClose() {
        this.isVirusModalVisible = false
        this.playerVirus = {}
      },

      onInfoClick(virus) {
        this.infoVirus = virus
        this.isInfoModalVisible = true
      },

      onInfoModalClose() {
        this.isInfoModalVisible = false
        this.infoVirus = {}
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .viruses {
    display: flex;
    height: 100%;
    flex-direction: column;

    &-list {
      padding: 15px 20px 30px;
      flex: 1;
      overflow: auto;
      
      .viruses-item {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;

        &:not(:last-child) {
          margin-bottom: 20px;
        }

        &__info {
          display: flex;
          flex-direction: row;
          justify-content: flex-start;
          align-items: center;
          flex: 1;
          filter: grayscale(100%);
          opacity: 0.4;

          &-icon {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            width: 70px;
            height: 70px;
            position: relative;
            z-index: 2;
            border-radius: 50%;
            background: $virus-bg;
            border: solid $virus-border 5px;
            box-shadow: 0 0 8px $virus-shadow;

            img {
              max-width: 85px;
              max-height: 85px;
            }
          }

          &-name {
            display: flex;
            flex-direction: row;
            align-content: center;
            justify-content: flex-start;
            margin-left: -10px;
            padding-left: 20px;
            height: 40px;
            width: 100%;
            border-radius: 0 20px 20px 0;
            margin-right: 30px;
            background: $virus-bg;
            border: solid $virus-border 5px;
            box-shadow: 0 0 8px $virus-shadow;
            position: relative;
            z-index: 0;

            &_button {
              position: absolute;
              z-index: 0;
              right: -10px;
              top: -10px;
            }
          }
        }

        &.active {
          .viruses-item__info {
            filter: none;
            opacity: 1;
          }
        }
      }
    }
  }
</style>