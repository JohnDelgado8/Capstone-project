<template>
  <q-page>
    <q-card class="card-size" v-if="$q.screen.width >= 785">
      <q-card-section>
        <div class="text-h5 q-ml-sm text-bold">Schedule List</div>
      </q-card-section>

      <!-- Iterate over days from Monday to Saturday -->
      <div class="q-px-lg" v-for="day in ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']"
        :key="day">
        <q-card v-if="hasScheduleForDay(day)" class="q-mb-lg q-px-lg">
          <q-card-section>
            <div class="text-h6 text-bold">{{ day }}</div>
          </q-card-section>
          <!-- Iterate over schedule items for the current day and display them -->
          <q-card v-for="(schedule, index) in getScheduleForDay(day)" :key="index" style="height: 240px">
            <q-card-section>
              <div class="text-subtitle1">Instructor: {{ schedule.instructor }}</div>
              <div class="text-subtitle1">Year: {{ schedule.year }}</div>
              <div class="text-subtitle1">Subject: {{ schedule.subjectname }}</div>
              <div class="text-subtitle1">Type: {{ schedule.type }}</div>
              <div class="text-subtitle1">Room: {{ schedule.room }}</div>
              <div class="text-subtitle1">Time: {{ schedule.time_from }} - {{ schedule.time_to }}</div>
            </q-card-section>
          </q-card>
        </q-card>
      </div>

    </q-card>

    <q-card class="card-size" v-if="$q.screen.width <= 785">
      <q-card-section>
        <div class="text-h5 q-ml-sm text-bold">Schedule List</div>
      </q-card-section>

      <!-- Iterate over days from Monday to Saturday -->
      <div class="q-px-lg" v-for="day in ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']"
        :key="day">
        <q-card v-if="hasScheduleForDay(day)" class="q-mb-lg q-px-lg">
          <q-card-section>
            <div class="text-h6 text-bold">{{ day }}</div>
          </q-card-section>
          <!-- Iterate over schedule items for the current day and display them -->
          <q-card v-for="(schedule, index) in getScheduleForDay(day)" :key="index" style="height: 240px">
            <q-card-section>
              <div class="text-subtitle1">Instructor: {{ schedule.instructor }}</div>
              <div class="text-subtitle1">Year: {{ schedule.year }}</div>
              <div class="text-subtitle1">Subject: {{ schedule.subjectname }}</div>
              <div class="text-subtitle1">Type: {{ schedule.type }}</div>
              <div class="text-subtitle1">Room: {{ schedule.room }}</div>
              <div class="text-subtitle1">Time: {{ schedule.time_from }} - {{ schedule.time_to }}</div>
            </q-card-section>
          </q-card>
        </q-card>
      </div>

    </q-card>
  </q-page>
</template>

<script>
import axios from 'axios'
import auth from "src/Auth/auth";

export default {
  data() {
    return {
      scheduleList: [] // Initialize an empty array to hold schedule data
    };
  },
  mounted() {
    // Fetch schedule data after component is mounted
    this.fetchScheduleData();
  },
  methods: {
    fetchScheduleData() {
      const loggedInInstructor = auth.email;
      // Fetch schedule data using instructor's email
      axios.get(`http://localhost/Capstone-System/scheduling-system/API/get_instructor_id.php`, {
        params: {
          email: loggedInInstructor
        }
      })
        .then(response => {
          // Use the response directly to set the schedule list
          this.scheduleList = response.data;
        })
        .catch(error => {
          console.error('Error fetching schedule data:', error);
        });
    },
    // Method to check if there are schedules for the specified day
    hasScheduleForDay(day) {
      return this.scheduleList.some(schedule => schedule.day === day);
    },
    // Method to get schedules for the specified day
    getScheduleForDay(day) {
      return this.scheduleList.filter(schedule => schedule.day === day);
    }
  }
};
</script>

<style lang="scss" scoped>
@import "pages/instructor-folder/instructor-style/InstructorSubject.scss";
</style>
