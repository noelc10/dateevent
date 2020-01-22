import Vue from 'vue'
import Vuex from 'vuex'
import dayjs from 'dayjs'
import api from '@/services/bootstrap'
import Event from './classes/Event'

// Register vuex to vue instance
Vue.use(Vuex)
const fullDateFormat = 'YYYY-MM-DD'

export default new Vuex.Store({
  state: {
    calendar: {
      startDate: dayjs(),
      eventItems: [],
      event: new Event()
    },
    showEventForm: false,
  },
  getters: {
    startDateMonthYear(state) {
      return state.calendar.startDate.format('MMMM YYYY')
    },
    prevDateMonthYear(state) {
      return state.calendar.startDate.subtract(1, 'month').format('MMM YYYY')
    },
    nextDateMonthYear(state) {
      return state.calendar.startDate.add(1, 'month').format('MMM YYYY')
    },
  },
  mutations: {
    setStartDateFromString(state, dateString) {
      state.calendar.startDate = dayjs(dateString)
    },
    toggleAddEventForm(state, value) {
      state.calendar.event = new Event()
      state.showEventForm = value
    },
    toggleEventForm(state, value) {
      state.showEventForm = value
    },
    setCalendarEvent(state, value) {
      state.calendar.event = Event.fromJson(value)
    },
    setCalendarEventItems(state, values) {
      state.calendar.eventItems = values
    },
  },
  actions: {
    getEventItems({commit, state}) {
      return api.get('/api/event-items').then(response => {
        commit('setCalendarEventItems', response.data.data)
      })
    },
    addNewEvent({commit, dispatch}, formData) {
      return api.post('/api/events', formData).then(response => {
        commit('setCalendarEvent', response.data.data)
        dispatch('getEventItems')
      })
    },
    updateEvent({commit, dispatch}, formData) {
      return api.put('/api/events/'+formData.id, formData).then(response => {
        commit('setCalendarEvent', response.data.data)
        dispatch('getEventItems')
      })
    },
    deleteEvent({commit, dispatch}, id) {
      return api.delete('/api/events/'+id).then(response => {
        dispatch('getEventItems')
      })
    }
  }
})
