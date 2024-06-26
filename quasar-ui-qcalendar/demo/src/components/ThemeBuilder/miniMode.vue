
<template>
  <div>
    <div class="q-gutter-sm q-mb-sm">
      <q-checkbox v-model="mobile" dense label="Use Touch (set if on mobile)" />
      <q-checkbox v-model="noActiveDate" dense label="No active date" />
      <q-checkbox v-model="disabledDays" dense label="Disabled weekends" />
      <q-checkbox v-model="hover" dense label="Hover" />
      <q-checkbox v-model="hideOutside" dense label="Hide outside days" />
      <q-checkbox v-model="showWorkweeks" dense label="Show workweeks" />
        <div class="full-width text-caption">Selection Type</div>
        <q-radio
          v-model="selectionType"
          dense
          val="off"
          label="Off"
        />
        <q-radio
          v-model="selectionType"
          dense
          val="date"
          label="Selection (toggle)"
        />
        <q-radio
          v-model="selectionType"
          dense
          val="range"
          label="Range"
        />
    </div>
    <div>
      <q-calendar
        ref="calendar"
        v-model="selectedDate"
        view="month"
        mini-mode
        short-weekday-label
        locale="en-us"
        bordered
        :no-active-date="noActiveDate"
        :selected-start-end-dates="startEndDates"
        :selected-dates="selectedDates"
        :disabled-weekdays="disabledWeekdays"
        :hover="hover ? mouseDown : false"
        :hide-outside-days="hideOutside"
        :show-work-weeks="showWorkweeks"
        @click:day2="onToggleDay"
        @click:date2="onToggleDate"
        @mousedown:day2="onMouseDownDay"
        @mouseup:day2="onMouseUpDay"
        @mousemove:day2="onMouseMoveDay"
        style="max-width: 300px; min-width: auto;"
        :style="styles"
      />
    </div>
  </div>
</template>

<script>
import {
  getDayIdentifier
} from 'ui'

function leftClick (e) {
  return e.button === 0
}

export default {
  name: 'ThemeBuilderMinimode',
  props: {
    value: String,
    styles: Object
  },
  data () {
    return {
      selectedDate: '',
      selectedDates: [],
      anchorTimestamp: null,
      otherTimestamp: null,
      mouseDown: false,
      mobile: false,
      noActiveDate: false,
      selectionType: 'off',
      disabledDays: false,
      hover: false,
      hideOutside: false,
      showWorkweeks: false
    }
  },

  beforeMount () {
    this.selectedDate = this.value
  },

  watch: {
    value (val) {
      this.selectedDate = val
    },

    selectionType (val) {
      // clear any existing data
      this.anchorTimestamp = null
      this.otherTimestamp = null
      this.selectedDates.splice(0, this.selectedDates.length)
    }
  },

  computed: {
    disabledWeekdays () {
      return this.disabledDays === true ? [0, 6] : []
    },

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
      if (this.anchorTimestamp !== null) {
        return getDayIdentifier(this.anchorTimestamp)
      }
      return false
    },

    otherDayIdentifier () {
      if (this.otherTimestamp !== null) {
        return getDayIdentifier(this.otherTimestamp)
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

  methods: {
    onToggleDate ({ scope }) {
      if (scope !== undefined) {
        this.toggleDate(scope)
      }
    },

    onToggleDay ({ scope }) {
      if (scope !== undefined) {
        this.toggleDate(scope)
      }
    },

    toggleDate (scope) {
      if (this.selectionType !== 'date') return
      const date = scope.timestamp.date
      if (this.selectedDates.includes(date)) {
        // remove the date
        for (let i = 0; i < this.selectedDates.length; ++i) {
          if (date === this.selectedDates[i]) {
            this.selectedDates.splice(i, 1)
            break
          }
        }
      }
      else {
        // add the date if not outside
        if (scope.outside !== true) {
          this.selectedDates.push(date)
        }
      }
    },

    onMouseDownDay ({ scope, event }) {
      if (this.selectionType !== 'range') return
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
      if (this.selectionType !== 'range') return
      if (leftClick(event)) {
        // mouse is up, capture last and cancel selection
        this.otherTimestamp = scope.timestamp
        this.mouseDown = false
      }
    },

    onMouseMoveDay ({ scope, event }) {
      if (this.selectionType !== 'range') return
      if (this.mouseDown === true) {
        this.otherTimestamp = scope.timestamp
      }
    }
  }
}
</script>
