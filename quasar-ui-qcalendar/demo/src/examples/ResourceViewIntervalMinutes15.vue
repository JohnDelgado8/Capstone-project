<template>
  <div style="max-width: 800px; width: 100%;">
    <q-calendar
      v-model="selectedDate"
      view="day-resource"
      :resources="resources"
      :resource-height="50"
      interval-minutes="15"
      bordered
      sticky
      locale="en-us"
        style="height: 200px; max-width: 800px; width: 100%;"
    />
  </div>
</template>

<script>
export default {
  data () {
    return {
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
