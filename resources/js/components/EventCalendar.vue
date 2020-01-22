<template>
  <v-layout wrap fill-height>
    <v-flex class="text-sm-left">
      <v-btn flat @click="$refs.calendar.prev()">
        <v-icon dark left> keyboard_arrow_left</v-icon>
        <span class="hidden-xs-only">{{ prevDateMonthYear }}</span>
      </v-btn>
    </v-flex>
    <v-flex class="text-xs-center">
      <div class="display-1 font-weight-light text-capitalize">
        {{ startDateMonthYear }}
      </div>
    </v-flex>
    <v-flex class="text-sm-right">
      <v-btn flat @click="$refs.calendar.next()">
        <span class="hidden-xs-only">{{ nextDateMonthYear }}</span>
        <v-icon right dark >
          keyboard_arrow_right
        </v-icon>
      </v-btn>
    </v-flex>
    <v-flex xs12 class="mt-2">
      <v-sheet>
        <v-calendar
          style="min-height: 500px"
          ref="calendar"
          v-model="start"
          :show-month-on-first="false"
          :type="type"
          :end="end"
          color="dark"
        >
          <template v-slot:day="{ date }">
            <v-scale-transition :hide-on-leave="true">
              <template v-for="item in getEventItemsByDate(date)">
                <event-item :item="item" :key="item.id"/>
              </template>
            </v-scale-transition>
          </template>
        </v-calendar>
      </v-sheet>
    </v-flex>
  </v-layout>
</template>

<script>
import { mapState, mapMutations, mapGetters, mapActions } from 'vuex'
import EventItem from './EventItem'
import filter from 'lodash/filter'

const fullDateFormat = 'YYYY-MM-DD'

export default {
  components: {
    EventItem
  },
  data: () => ({
    type: 'month',
    start: '',
    end: '',
    typeOptions: [
      { text: 'Day', value: 'day' },
      { text: 'Week', value: 'week' },
      { text: 'Month', value: 'month' },
    ]
  }),
  computed: {
    ...mapState({
      startDate: state => state.calendar.startDate,
      eventItems: state => state.calendar.eventItems,
    }),
    ...mapGetters({
      startDateMonthYear: 'startDateMonthYear',
      prevDateMonthYear: 'prevDateMonthYear',
      nextDateMonthYear: 'nextDateMonthYear',
    }),
  },
  methods: {
    ...mapActions({
      getEventItems: 'getEventItems',
    }),
    ...mapMutations({
      setStartDateFromString: 'setStartDateFromString'
    }),
    getEventItemsByDate(date) {
      return filter(this.eventItems, (item) => {
        return item.date === date
      })
    },
  },
  watch: {
    startDate(val) {
      this.start = val.format(fullDateFormat)
    },
    start(val) {
      this.setStartDateFromString(val)
    },
  },
  created() {
    this.getEventItems()
  }
}
</script>
