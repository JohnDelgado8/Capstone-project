<template>
  <div style="max-width: 800px; width: 100%; background: #121212;">
    <q-calendar
      v-model="selectedDate"
      view="week"
      dark
      locale="en-us"
      style="height: 400px;"
    />
  </div>
</template>

<script>
export default {
  data () {
    return {
      selectedDate: ''
    }
  }
}
</script>
