<template>
  <div style="max-width: 800px; width: 100%;">
    <q-calendar
      ref="calendar"
      v-model="currentDate"
      view="day"
      locale="en-us"
      style="height: 400px;"
    >
      <template #day-container="{ /* timestamp */ }">
        <div class="day-view-current-time-indicator" :style="style" />
        <div class="day-view-current-time-line" :style="style" />
      </template>
    </q-calendar>
  </div>
</template>

<script>
// normally you would not import "all" of QCalendar, but is needed for this example to work with UMD (codepen)
import QCalendar from 'ui' // ui is aliased from '@quasar/quasar-ui-qcalendar'

export default {
  data () {
    return {
      currentDate: undefined,
      currentTime: undefined,
      intervalId: null,
      timeStartPos: 0
    }
  },

  mounted () {
    this.adjustCurrentTime()
    // now, adjust the time every minute
    this.intervalId = setInterval(() => {
      this.adjustCurrentTime()
    }, 60000)
  },

  beforeDestroy () {
    clearInterval(this.intervalId)
  },

  computed: {
    style () {
      return {
        top: this.timeStartPos + 'px'
      }
    }
  },

  methods: {
    adjustCurrentTime () {
      const now = new Date()
      const p = QCalendar.parseDate(now)
      this.currentDate = p.date
      this.currentTime = p.time
      this.timeStartPos = this.$refs.calendar.timeStartPos(this.currentTime)
    }
  }
}
</script>

<style lang="sass">
.day-view-current-time-indicator
  position: absolute
  left: 45px
  height: 10px
  width: 10px
  margin-top: -4px
  background-color: rgba(0, 0, 255, .5)
  border-radius: 50%

.day-view-current-time-line
  position: absolute
  left: 55px
  border-top: rgba(0, 0, 255, .5) 2px solid
  width: calc(100% - 50px - 5px)

.body--dark
  .day-view-current-time-indicator
    background-color: rgba(255, 255, 0, .85)

  .day-view-current-time-line
    border-top: rgba(255, 255, 0, .85) 2px solid

</style>
