<template>
  <div style="max-width: 800px; width: 100%;">
    <q-calendar
      v-model="selectedDate"
      view="week"
      locale="en-us"
      style="height: 400px;"
    >
      <template #head-day="{ timestamp }">
        <div class="full-height row justify-center items-center">
          {{ getHeadDay(timestamp) }}
        </div>
      </template>
    </q-calendar>
  </div>
</template>

<script>
export default {
  data () {
    return {
      selectedDate: ''
    }
  },

  methods: {
    getHeadDay (timestamp) {
      return `${timestamp.date}`
    }
  }
}
</script>
