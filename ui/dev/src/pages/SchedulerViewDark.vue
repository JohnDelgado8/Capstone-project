<template>
  <div style="max-width: 800px; width: 100%; background: #121212;">
    <q-calendar
      v-model="selectedDate"
      view="week-scheduler"
      dark
      :resources="resources"
      :resource-height="50"
      locale="en-us"
      style="height: 400px;"
    />
  </div>
</template>

<script>
export default {
  data () {
    return {
      selectedDate: '',
      resources: [
        { label: 'John' },
        { label: 'Mary' },
        { label: 'Susan' },
        { label: 'Olivia' },
        { label: 'Board Room' },
        { label: 'Room-1' },
        { label: 'Room-2' }
      ]
    }
  }
}
</script>
