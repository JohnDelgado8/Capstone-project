<template>
  <div v-if="show" class="modal">
    <div class="modal-content">
      <!-- Emit close event when the close button is clicked -->
      <span class="close" @click="closeDialog">&times;</span>
      <form @submit.prevent="submitEvent">
        <label for="subjectname">Subject Name:</label>
        <input type="text" id="subjectname" v-model="subjectName" required><br>
        <label for="day">Day:</label>
        <select id="day" v-model="day" required>
          <option v-for="resource in resources" :key="resource.id" :value="resource.id">{{ resource.name }}</option>
        </select><br>
        <label for="timeFrom">Time From:</label>
        <input type="time" id="timeFrom" v-model="timeFrom" required><br>
        <label for="timeTo">Time To:</label>
        <input type="time" id="timeTo" v-model="timeTo" required><br>
        <button type="submit">Add</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AddEventDialog',
  props: {
    show: {
      type: Boolean,
      required: true
    },
    newEvent: {
      type: Object,
      required: true
    },
    resources: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      subjectName: '',
      day: '',
      timeFrom: '',
      timeTo: ''
    }
  },
  methods: {
    closeDialog() {
      this.$emit('close');
    },
    submitEvent() {
      this.$emit('submit-event', {
        subjectName: this.subjectName,
        day: this.day,
        timeFrom: this.timeFrom,
        timeTo: this.timeTo
      });
    }
  }
}
</script>

<style>
/* Your styles */
</style>
