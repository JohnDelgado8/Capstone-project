<!-- HistoryLog.vue -->

<template>
  <q-page>
    <q-card>
      <q-card-section>
        <div class="text-h5 q-ml-sm text-bold">History Log</div>
      </q-card-section>

      <div class="search-field q-px-md">
        <q-input v-model="searchQuery" label="Search by Username" dense filled clearable class="input-field"
          @clear="clearSearch" />
        <q-btn class="search-button" icon="search" @click="searchByUsername" />
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


<style lang="scss" scoped>
@import "pages/dean-folder/dean-style/Dean-History.scss";
</style>

<script src="pages/dean-folder/dean-scripts/Dean-History"></script>

