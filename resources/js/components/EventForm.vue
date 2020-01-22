<template>
  <v-card flat color="grey lighten-5 event-form-card" v-show="showForm">
    <abs-loading v-show="loading" />
    <v-toolbar dense flat>
      <v-toolbar-title class="subheading grey--text">
        <span v-if="isUpdateMode">Event</span>
        <span v-else> Add New Event </span>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn flat icon @click="close">
        <v-icon>close</v-icon>
      </v-btn>
    </v-toolbar>
    <v-card-text>
      <v-form>
        <v-text-field
          :error-messages="getErrorMessages('title')"
          v-model="form.title"
          label="Event Title"
          required
        ></v-text-field>
        <date-picker-input v-model="form.date_from" label="Date From" :error-messages="getErrorMessages('date_from')" />
        <date-picker-input v-model="form.date_to" :min-date="form.date_from" label="Date To" :error-messages="getErrorMessages('date_to')" />
        <br>
        <v-layout row wrap>
          <v-flex class="text-center">
            <p class="text-uppercase"> Sun </p>
            <v-checkbox v-model="form.days.sun" />
          </v-flex>
          <v-flex class="text-center">
            <p class="text-uppercase"> Mon </p>
            <v-checkbox v-model="form.days.mon" />
          </v-flex>
          <v-flex class="text-center">
            <p class="text-uppercase"> Tue </p>
            <v-checkbox v-model="form.days.tue" />
          </v-flex>
          <v-flex class="text-center">
            <p class="text-uppercase"> Wed </p>
            <v-checkbox v-model="form.days.wed" />
          </v-flex>
          <v-flex class="text-center">
            <p class="text-uppercase"> Thu </p>
            <v-checkbox v-model="form.days.thu" />
          </v-flex>
          <v-flex class="text-center">
            <p class="text-uppercase"> Fri </p>
            <v-checkbox v-model="form.days.fri" />
          </v-flex>
          <v-flex class="text-center">
            <p class="text-uppercase"> Sat </p>
            <v-checkbox v-model="form.days.sat" />
          </v-flex>
        </v-layout>
        <div class="v-messages theme--light error--text" v-show="getErrorMessages('days')">
          <div class="v-messages__wrapper">
            <div class="v-messages__message" v-for="msg in getErrorMessages('days')" :key="msg">{{ msg }}</div>
          </div>
        </div>
        <br><hr><br>
        <v-btn v-if="isUpdateMode" :disabled="isFormPristine" @click="updateCurrrentEvent" color="dark">Update</v-btn>
        <v-btn v-if="isUpdateMode" @click="deleteCurrentEvent" color="error">Delete</v-btn>
        <v-btn v-if="!isUpdateMode" :disabled="isFormPristine" @click="addEvent" color="dark">Submit</v-btn>
      </v-form>
    </v-card-text>
  </v-card>
</template>

<script>
import dayjs from 'dayjs'
import DatePickerInput from './picker/DatePickerInput'
import AbsLoading from './utils/AbsLoading'
import { mapActions, mapState } from 'vuex'
import cloneDeep from 'lodash/cloneDeep'
import isEqual from 'lodash/isEqual'
import EventBus from '@/services/eventBus'
import loader from './mixins/loader'
import { setTimeout } from 'timers';

const fullDateFormat = 'YYYY-MM-DD'

export default {
  components: {
    DatePickerInput,
  },
  mixins: [
    loader,
  ],
  data: () => ({
    form: {},
    formClone: {},
    showForm: false,
    formErrors: {}
  }),
  computed: {
    ...mapState({
      event: state => state.calendar.event
    }),
    isUpdateMode() {
      return !!this.form.id
    },
    isFormPristine() {
      return isEqual(this.formClone, this.form)
    }
  },
  methods: {
    ...mapActions({
      addNewEvent: 'addNewEvent',
      deleteEvent: 'deleteEvent',
      updateEvent: 'updateEvent',
    }),
    addEvent() {
      this.clearError()
      this.showLoader()
      this.addNewEvent(this.form).then(() => {
        EventBus.$emit('SHOW_SNACKBAR', {text: 'Event successfully saved!'})
        this.hideLoader()
      }).catch(err => {
        this.handleError(err)
        this.hideLoader()
      })
    },
    updateCurrrentEvent() {
      this.clearError()
      this.showLoader()
      this.updateEvent(this.form).then(() => {
        EventBus.$emit('SHOW_SNACKBAR', {text: 'Event successfully updated!'})
        this.hideLoader()
      }).catch(err => {
        this.handleError(err)
        this.hideLoader()
      })
    },
    deleteCurrentEvent() {
      this.showLoader()
      this.deleteEvent(this.form.id).then(() => {
        EventBus.$emit('SHOW_SNACKBAR', {text: 'Event successfully deleted!'})
        this.hideLoader()
        this.close()
      })
    },
    getErrorMessages (field) {
      return this.formErrors[field] ? this.formErrors[field] : null
    },
    handleError (err) {
      if (err.response.status === 422) {
        this.formErrors = err.response.data.errors
      }
    },
    clearError() {
      this.formErrors = {}
    },
    close() {
      this.showForm = false
      setTimeout(() => {
        this.$emit('close')
      }, 100)
    },
    cloneForm() {
      this.formClone = cloneDeep(this.form)
    }
  },
  watch: {
    event (val) {
      this.form = val
      this.cloneForm()
    }
  },
  created() {
    this.form = this.event
    this.cloneForm()
  },
  mounted() {
    setTimeout(() => {
      this.showForm = true
    }, 100)
  }
}
</script>

<style scoped>
  .event-form-card {
    position: relative;
  }
</style>
