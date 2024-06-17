<!-- HistoryLog.vue -->

<template>
  <q-page>
    <q-card style="height: 700px; background-color: #F2F2F2;">
      <q-card-section>
        <div class="text-h5 q-ml-sm">History</div>
      </q-card-section>

      <div class="sample q-px-md" style="display: flex; align-items: center; gap: 10px;">
        <q-input v-model="searchQuery" label="Search by Username" dense filled clearable class="" @clear="clearSearch"
          style="width: 200px;" />
        <q-btn icon="search" color="green" @click="searchByUsername" />
      </div>

      <div class="q-pa-md">
        <q-table :rows="filteredHistoryLog" :columns="historyLogColumns" row-key="id">
          <template v-slot:body-cell-timestamp="props">
            <q-td :props="props">
              {{ props.row.timestamp }}
            </q-td>
          </template>
        </q-table>
      </div>
    </q-card>
  </q-page>
</template>


<script src="pages/registrar-folder/registrar-scripts/RegistrarHistory"></script>
<style scoped>
/* Add component-specific styles if needed */
</style>
