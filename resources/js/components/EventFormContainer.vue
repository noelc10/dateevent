<template>
  <div class="event-form-container">
    <v-dialog persistent v-if="showAsModal" v-model="showForm" max-width="400">
      <event-form @close="onFormClose" v-if="showForm"/>
    </v-dialog>
    <template v-else>
      <v-expand-x-transition>
        <v-sheet width="400px" v-if="showForm" class="mr-3">
          <event-form @close="onFormClose"/>
        </v-sheet>
      </v-expand-x-transition>
    </template>
  </div>

</template>

<script>
import EventForm from './EventForm'
import { mapState, mapMutations } from 'vuex'

export default {
  components: {
    EventForm
  },
  data: () => ({
    showForm: false,
  }),
  computed: {
    ...mapState({
      showEventForm: state => state.showEventForm
    }),
    showAsModal() {
      return this.$vuetify.breakpoint.mdAndDown
    }
  },
  methods: {
    ...mapMutations({
      toggleAddEventForm: 'toggleAddEventForm'
    }),
    onFormClose() {
      this.showForm = false
      this.toggleAddEventForm(false)
    }
  },
  watch: {
    showEventForm (val) {
      if (this.showForm !== val) {
        this.showForm = val
      }
    }
  }
}
</script>
