<template>
  <div class="event-item" v-ripple @click="showUpdateForm">
    {{ item.title }}
  </div>
</template>

<script>
import { mapMutations } from 'vuex'

export default {
  props: {
    item: {
      type: Object,
      required: true
    }
  },
  methods: {
    ...mapMutations({
      setCalendarEvent: 'setCalendarEvent',
      toggleEventForm: 'toggleEventForm'
    }),
    showUpdateForm() {
      this.setCalendarEvent(this.item.event)
      this.toggleEventForm(true)
    }
  }
}
</script>

<style scoped>
  .event-item {
    background-color: #000;
    color: white;
    padding: 2px 6px;
    margin: 2px 0;
    border-radius: 2px;
    cursor: pointer;
  }
</style>
