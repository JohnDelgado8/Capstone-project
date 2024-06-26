<template>
  <div class="row justify-center" style="max-width: 800px; width: 100%; overflow: hidden;">
    <div class="q-gutter-sm">
      <q-checkbox v-model="mobile" label="Use Touch (set if on mobile)" />
    </div>
    <q-separator class="full-width" />
    <q-input color="blue-8" filled v-model="convertedDates" @input="onInputChanged" label="Enter date range" mask="####-##-## - ####-##-##" class="q-pa-sm">
      <template v-slot:append>
        <div class="q-gutter-sm" style="overflow: hidden;">
          <span>
            <q-icon name="far fa-calendar" class="cursor-pointer q-ma-md" />
            <q-popup-proxy v-model="showCalendar" anchor="top right" self="bottom middle">
              <q-calendar
                ref="calendar"
                v-model="selectedDate"
                view="month"
                locale="en-us"
                mini-mode
                short-weekday-label
                :selected-start-end-dates="startEndDates"
                no-active-date
                @mousedown:day2="onMouseDownDay"
                @mouseup:day2="onMouseUpDay"
                @mousemove:day2="onMouseMoveDay"
                style="width: 170px;"
              />
            </q-popup-proxy>
          </span>
        </div>
      </template>
    </q-input>
  </div>
</template>

<script>
// normally you would not import "all" of QCalendar, but is needed for this example to work with UMD (codepen)
import QCalendar from 'ui' // ui is aliased from '@quasar/quasar-ui-qcalendar'

function leftClick (e) {
  return e.button === 0
}

export default {
  data () {
    return {
      selectedDate: '',
      convertedDates: '',
      showCalendar: false,
      anchorTimestamp: '',
      otherTimestamp: '',
      mouseDown: false,
      mobile: false
    }
  },

  computed: {
    startEndDates () {
      const dates = []
      if (this.anchorDayIdentifier !== false && this.otherDayIdentifier !== false) {
        if (this.anchorDayIdentifier <= this.otherDayIdentifier) {
          dates.push(this.anchorTimestamp.date, this.otherTimestamp.date)
        }
        else {
          dates.push(this.otherTimestamp.date, this.anchorTimestamp.date)
        }
      }
      return dates
    },

    anchorDayIdentifier () {
      if (this.anchorTimestamp !== '') {
        return QCalendar.getDayIdentifier(this.anchorTimestamp)
      }
      return false
    },

    otherDayIdentifier () {
      if (this.otherTimestamp !== '') {
        return QCalendar.getDayIdentifier(this.otherTimestamp)
      }
      return false
    },

    lowIdentifier () {
      // returns lowest of the two values
      return Math.min(this.anchorDayIdentifier, this.otherDayIdentifier)
    },

    highIdentifier () {
      // returns highest of the two values
      return Math.max(this.anchorDayIdentifier, this.otherDayIdentifier)
    }
  },

  watch: {
    startEndDates () {
      const [start, end] = this.startEndDates
      this.convertedDates = `${start} - ${end}`
    }
  },

  methods: {
    onInputChanged (val) {
      const items = val.split(' - ')
      if (items[0] && items[0].length === 10) this.anchorTimestamp = QCalendar.parseTimestamp(items[0])
      if (items[1] && items[1].length === 10) this.otherTimestamp = QCalendar.parseTimestamp(items[1])
    },

    calendarNext () {
      this.$refs.calendar.next()
    },

    calendarPrev () {
      this.$refs.calendar.prev()
    },

    onMouseDownDay ({ scope, event }) {
      if (leftClick(event)) {
        if (this.mobile === true &&
          this.anchorTimestamp !== null &&
          this.otherTimestamp !== null &&
          this.anchorTimestamp.date === this.otherTimestamp.date) {
          this.otherTimestamp = scope.timestamp
          this.mouseDown = false
          return
        }
        // mouse is down, start selection and capture current
        this.mouseDown = true
        this.anchorTimestamp = scope.timestamp
        this.otherTimestamp = scope.timestamp
      }
    },

    onMouseUpDay ({ scope, event }) {
      if (leftClick(event)) {
        // mouse is up, capture last and cancel selection
        this.otherTimestamp = scope.timestamp
        this.mouseDown = false
      }
    },

    onMouseMoveDay ({ scope, event }) {
      if (this.mouseDown === true) {
        this.otherTimestamp = scope.timestamp
      }
    }
  }
}
</script>
