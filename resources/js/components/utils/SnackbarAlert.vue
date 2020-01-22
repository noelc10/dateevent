<template>
  <v-snackbar
    v-model="showSnackbar"
    :right="true"
    :timeout="3000"
    :top="true"
    :color="color"
  >
    {{ text }}
  </v-snackbar>
</template>

<script>
import EventBus from '@/services/eventBus'

export default {
  data: () => ({
    showSnackbar: false,
    color: 'success',
    text: ''
  }),
  mounted() {
    EventBus.$on('SHOW_SNACKBAR', (payload) => {
      this.showSnackbar = false
      this.text = payload.text
      if (payload.color) {
        this.color = payload.color
      }
      this.showSnackbar = true
    })
  }
}
</script>
