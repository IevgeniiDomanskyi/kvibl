<template>
  <div class="map-lap">
    <div class="map-lap__right">
      <span class="map-lap__right-text">
        {{ $t('game.main.lap') }}
      </span>

      <div class="map-lap__right-value">
        {{ lap }}
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'KvMapLap',

    props: {
      lap: {
        type: Number,
        default: 1,
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables.scss';

  .map-lap {
    display: flex;
    flex-direction: row;
    justify-content: flex-end;

    &__right {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      align-items: center;

      &-value {
        font-size: 30px;
        color: $white;
      }
    }
  }
</style>