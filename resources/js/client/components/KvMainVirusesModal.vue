<template>
  <app-modal
    :visible="visible"
    :title="$t('game.main.viruses_title')"
    role="default"
    @close="onClose"
  >
    <app-text
      v-if="game.lap == 1"
      :text="$t('game.viruses.lap')"
    />

    <app-text
      v-if="! me.viruses.length && game.lap > 1"
      :text="$t('game.main.viruses_empty')"
    />

    <div
      v-if="me.viruses.length && game.lap > 1"
    >
      <div
        v-for="virus in me.viruses"
        :key="virus.id"
        :class="{ selected: virus.id == selectedVirusId }"
        class="viruses-item"
        @click="onVirusClick(virus.id)"
      >
        <img
          :src="image(virus.image)"
        />

        <app-text
          :text="virus.name"
          size="medium"
        />
      </div>
    </div>

    <template slot="footer">
      <app-button
        :label="$t('game.main.viruses_button')"
        :role="(selectedVirusId > 0 && game.lap > 1) ? 'primary' : 'disabled'"
        :pulse="selectedVirusId > 0 && game.lap > 1"
        small
        @click="onInfect"
      />
    </template>
  </app-modal>
</template>

<script>
  import { mapState, mapMutations, mapActions } from 'vuex'
  import AppModal from './AppModal'
  import AppText from './AppText'
  import AppButton from './AppButton'
  import Game from '../mixins/game'

  export default {
    name: 'KvMainVirusesModal',

    mixins: [Game],

    components: {
      AppModal,
      AppText,
      AppButton,
    },

    props: {
      visible: {
        type: Boolean,
        default: false,
      },

      player: {
        type: Object,
        default: () => {}
      },
    },

    data: () => ({
      selectedVirusId: 0
    }),

    watch: {
      me(val) {
        this.setDefaultVirus()
      },
    },

    created() {
      this.setDefaultVirus()
    },

    methods: {
      ...mapMutations([
        'messages/set',
      ]),

      ...mapActions([
        'viruses/apply',
      ]),

      setDefaultVirus() {
        if (this.me && this.me.viruses && this.me.viruses.length == 1) {
          this.selectedVirusId = this.me.viruses[0].id
        }
      },

      image(file) {
        if (file) {
          const image = require.context('../assets/', false, /\.png$/)
          return image('./' + file)
        }

        return null
      },

      onVirusClick(virus_id) {
        if (this.selectedVirusId == virus_id) {
          this.selectedVirusId = 0
        } else {
          this.selectedVirusId = virus_id
        }
      },

      onInfect() {
        if (this.game.lap > 1) {
          if (this.selectedVirusId > 0) {
            this['viruses/apply']({
              virus_id: this.selectedVirusId,
              id: this.player.player_id,
            }).then(data => {
              this.selectedVirusId = 0
              this['messages/set']({
                text: this.$t('game.viruses.apply'),
                type: 'success',
              })
              
              this.onClose()
            })
          } else {
            this['messages/set']({
              text: this.$t('game.viruses.empty_virus'),
              type: 'warning',
            })
          }
        } else {
          this['messages/set']({
            text: this.$t('game.viruses.lap'),
            type: 'warning',
          })
        }
      },

      onClose() {
        this.$emit('close')
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .viruses-item {
    position: relative;
    z-index: 0;
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    align-items: center;

    margin-bottom: 2px;
    padding: 3px 10px;
    margin: 0 -10px;
    border-radius: 10px;
    border: solid transparent 1px;
    cursor: pointer;

    &.selected {
      background: $warning-second;
      border-color: $warning;
      box-shadow: inset 0 1px 2px $virus-shadow; 
    }

    img {
      max-width: 60px;
      margin-right: 10px;
    }
  }
</style>