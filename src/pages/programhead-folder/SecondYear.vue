<template>
  <div class="subcontent">
    <div class="row justify-center q-mt-xl">
      <div style="display: flex; max-width: 800px; width: 100%; height: 600px;">
        <q-calendar-day ref="calendar" v-model="selectedDate" view="week" animated bordered noDefaultHeaderBtn
          :interval-start="12" :interval-minutes="30" :interval-count="26" :weekdays="[1, 2, 3, 4, 5, 6]"
          transition-next="slide-left" transition-prev="slide-right" no-active-date @change="onChange" @moved="onMoved"
          @click-date="onClickDate" @click-time="onClickTime" @click-interval="onClickInterval"
          @click-head-intervals="onClickHeadIntervals" @click-head-day="onClickHeadDay">
          <!-- Render events -->
          <template #day-body="{ scope: { timestamp, timeStartPos, timeDurationHeight } }">
            <template v-for="event in getEvents(timestamp.date)" :key="event.id">
              <div v-if="event.time_from && event.time_to" class="my-event" :class="badgeClasses(event, 'body')"
                :style="badgeStyles(event, 'body', timeStartPos, timeDurationHeight)"
                style="background-color: lightblue;">
                <span class="title">
                  {{ event.subjectname }}
                  {{ event.instructor }}
                  {{ event.room }}
                  {{ event.type }} <!-- Updated property name -->
                </span>
                <q-badge color="primary">{{ event.type }}</q-badge> <!-- Updated property name -->
              </div>
            </template>
          </template>
        </q-calendar-day>
      </div>
    </div>
  </div>
</template>

<script>
import { QCalendarDay, parseTimestamp } from '@quasar/quasar-ui-qcalendar/src/QCalendarDay.js'
import { defineComponent } from 'vue'
import axios from "axios";

export default defineComponent({
  name: 'WeekSlotDayBody',
  components: {
    QCalendarDay
  },
  data() {
    return {
      selectedDate: parseTimestamp(new Date()),
      events: [],
    }
  },

  mounted() {
    this.fetchEventsFromDatabase();
  },

  methods: {
    async fetchEventsFromDatabase() {
      try {
        const response = await axios.get("http://localhost/Capstone-System/capstone_scheduling/API/get_schedule.php");
        console.log("Fetched events data:", response.data); // Debugging
        if (Array.isArray(response.data)) {
          this.events = response.data;
          console.log("Events loaded:", this.events); // Debugging
        } else {
          console.error("Error fetching events: Response data is not an array");
        }
      } catch (error) {
        console.error("Error fetching events:", error);
      }
    },

    getEvents(dt) {
      const events = this.events.filter(event => event.day.toLowerCase() === this.getDayName(dt).toLowerCase());
      console.log("Filtered events for", dt, ":", events); // Debugging
      return events;
    },

    getDayName(date) {
      const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
      const index = new Date(date).getDay();
      return days[index];
    },

    badgeClasses(event, type) {
      let classes = ['my-event'];
      if (type === 'body') {
        classes.push('body-event');
      } else {
        classes.push('header-event');
      }
      // Add additional classes based on event time if needed
      return classes;
    },

    badgeStyles(event, type, timeStartPos, timeDurationHeight) {
      const styles = {};

      // Log the values for debugging
      console.log('timeStartPos:', timeStartPos);
      console.log('timeDurationHeight:', timeDurationHeight);

      if (event.time_from && event.time_to) {
        // Parse event start time
        const start = event.time_from.split(':');
        const end = event.time_to.split(':');

        const startHour = parseInt(start[0]);
        const startMinute = parseInt(start[1]);
        const endHour = parseInt(end[0]);
        const endMinute = parseInt(end[1]);

        // Convert time_from and time_to to minutes
        const totalStartMinutes = startHour * 60 + startMinute;
        const totalEndMinutes = endHour * 60 + endMinute;

        // Calculate duration in minutes
        const durationMinutes = totalEndMinutes - totalStartMinutes;

        // Use duration as timeDurationHeight
        timeDurationHeight = durationMinutes;

        // Calculate difference from calendar start time
        const calendarStartTime = 9 * 60; // Assuming calendar starts at 9:00 AM
        const timeDifferenceStart = totalStartMinutes - calendarStartTime;

        // Calculate top position based on time slot height
        const timeSlotHeight = timeDurationHeight / 26;
        const topPosition = timeStartPos + (timeDifferenceStart * (timeSlotHeight / 30));

        // Assign top position to styles
        styles.top = `${topPosition}px`;

        // Log calculated values for debugging
        console.log('Event:', event);
        console.log('totalStartMinutes:', totalStartMinutes);
        console.log('totalEndMinutes:', totalEndMinutes);
        console.log('durationMinutes:', durationMinutes);
        console.log('calendarStartTime:', calendarStartTime);
        console.log('timeDifferenceStart:', timeDifferenceStart);
        console.log('timeSlotHeight:', timeSlotHeight);
        console.log('topPosition:', topPosition);
      }

      return styles;
    },

    // Event handlers (if needed)
    onChange(data) {
      // Handle calendar change event if needed
    },
    onMoved(data) {
      // Handle calendar moved event if needed
    },
    onClickDate(data) {
      // Handle click on calendar date if needed
    },
    onClickTime(data) {
      // Handle click on calendar time if needed
    },
    onClickInterval(data) {
      // Handle click on calendar interval if needed
    },
    onClickHeadIntervals(data) {
      // Handle click on calendar head intervals if needed
    },
    onClickHeadDay(data) {
      // Handle click on calendar head day if needed
    }
  }
});
</script>

<style lang="sass" scoped>
/* Add your styles here */
</style>
