<template>
  <div class="row justify-center q-pa-lg">
    <q-scroll-area
      style="height: 400px; max-width: 600px; width: 100%;"
      class="content-bordered"
    >
      <q-calendar
        v-model="selectedDate"
        view="day"
        locale="en-us"
        no-scroll
      />
    </q-scroll-area>
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

<style lang="sass">
.content-bordered
  border: 1px solid #e0e0e0
</style>
