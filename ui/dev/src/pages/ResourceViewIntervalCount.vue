<template>
  <div style="max-width: 800px; width: 100%;">
    <q-calendar
      v-model="selectedDate"
      view="day-resource"
      :resources="resources"
      :resource-height="50"
      interval-count="4"
      bordered
      sticky
      locale="en-us"
      style="height: 200px;"
    />
  </div>
</template>

<script>
export default {
  data () {
    return {
      intervalWidth: 100,
      intervalHeight: 20,
      selectedDate: '2019-04-01',
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
