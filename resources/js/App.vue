<template>
  <v-app>
    <v-card class="my-auto" flat>
      <v-layout row pb-2>
        <v-flex md10 offset-md1>
          <v-card class="card--flex-toolbar mx-2">
            <v-toolbar card prominent>
              <v-scale-transition>
                <v-btn color="dark" v-show="!showEventForm" @click="toggleAddEventForm(true)">
                  Add Event
                  <v-icon right dark>insert_invitation</v-icon>
                </v-btn>
              </v-scale-transition>
              <v-spacer></v-spacer>
            </v-toolbar>

            <v-divider></v-divider>

            <v-card-text>
              <v-layout>
                <v-flex shrink>
                  <event-form-container />
                </v-flex>
                <v-flex grow>
                  <event-calendar />
                </v-flex>
              </v-layout>
            </v-card-text>
          </v-card>
        </v-flex>
      </v-layout>
    </v-card>
    <snackbar-alert />
  </v-app>
</template>

<script>
import EventCalendar from './components/EventCalendar'
import EventFormContainer from './components/EventFormContainer'
import SnackbarAlert from './components/utils/SnackbarAlert'
import { mapState, mapMutations } from 'vuex'

export default {
  components: {
    EventCalendar,
    EventFormContainer,
    SnackbarAlert
  },
  computed: {
    ...mapState({
      showEventForm: state => state.showEventForm
    })
  },
  methods: {
    ...mapMutations({
      toggleAddEventForm: 'toggleAddEventForm'
    }),
  }
}
</script>

<style>
  .card--flex-toolbar {
    margin-top: -64px;
  }
</style>
