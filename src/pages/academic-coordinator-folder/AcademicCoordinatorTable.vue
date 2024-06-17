<template>
  <q-page>
    <q-card style="height: 700px; background-color: #F2F2F2;">
      <q-card-section>
        <div class="text-h5 q-ml-sm">Academic Coordinator</div>
      </q-card-section>
      <div class="q-pa-md">
        <q-table title="Schedules" :rows="rows" :columns="columns" row-key="name" />
      </div>
    </q-card>
  </q-page>
</template>

<script>
const columns = [
  {
    name: 'name',
    required: true,
    label: 'Departments',
    align: 'left',
    field: row => row.name,
    format: val => `${val}`,
    sortable: true
  },
  { name: '', align: 'center', label: 'Name', field: '', sortable: true },
  { name: '', label: 'File Type', field: '', sortable: true },
  { name: '', label: 'Action', field: '' },

]

const rows = [
  {
    name: 'CITE',
    calories: 159,
    fat: 6.0,
    carbs: 24,

  },
  {
    name: 'Marketing',
    calories: 237,
    fat: 9.0,
    carbs: 37,

  },
  {
    name: 'Criminology',
    calories: 262,
    fat: 16.0,
    carbs: 23,

  },
  {
    name: 'BPA',
    calories: 305,
    fat: 3.7,
    carbs: 67,

  },
  {
    name: 'Senior High',
    calories: 356,
    fat: 16.0,
    carbs: 49,

  },

]

export default {
  setup() {
    return {
      columns,
      rows
    }
  }
}
</script>



<style lang="scss" scoped>
@import "pages/styles/Dashboard.scss";
</style>
