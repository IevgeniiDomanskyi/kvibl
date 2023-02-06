<template>
  <div />
</template>

<script>
  import { mapState, mapMutations } from 'vuex'

  export default {
    name: 'AppAlert',
    
    description: 'Displays the notification alert.',
    
    token: '<app-alert></app-alert>',

    computed: {
      ...mapState({
        list: state => state.alerts.list,
      }),
    },

    watch: {
      list(value) {
        if (value.length) {
          value.forEach((message) => {
            setTimeout(() => {
              this.$notify[message.type]({
                title: message.type,
                message: message.text,
                position: 'top-right',
              })
            }, 50)
          })

          this.alertClear()
        }
      },
    },

    methods: {
      ...mapMutations([
        'alerts/alertClear',
      ]),

      alertClear() {
        this['alerts/alertClear']()
      },
    },
  }
</script>
