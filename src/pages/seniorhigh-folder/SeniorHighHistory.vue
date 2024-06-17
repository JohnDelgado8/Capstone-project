<!-- HistoryLog.vue -->

<template>
  <q-page>
    <q-card style="height: 700px;">
      <q-card-section>
        <div class="text-h5 q-ml-sm">History Log</div>
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

<script>
import axios from 'axios';

export default {
  data() {
    return {
      historyLog: [],
      filteredHistoryLog: [],
      historyLogColumns: [
        { name: 'id', label: 'ID', align: 'left', field: 'id' },
        { name: 'action', label: 'Action', align: 'left', field: 'action' },
        { name: 'email', label: 'Email', align: 'left', field: 'email' },
        { name: 'timestamp', label: 'Date & Time', align: 'left', field: 'timestamp' },
        // Add more columns as needed
      ],
      searchQuery: '',
    };
  },
  mounted() {
    this.fetchHistoryLog();
  },
  methods: {
    fetchHistoryLog() {
      axios.get('https://forbesscheduling.000webhostapp.com/server/history.php')
        .then(response => {
          console.log('History Log Data:', response.data); // Log the response to the console
          this.historyLog = response.data;
          this.filteredHistoryLog = response.data; // Set initial filtered data
        })
        .catch(error => {
          console.error('Error fetching history log:', error);
        });
    },

    searchByUsername() {
      // Filter the history log based on the search query
      if (this.searchQuery.trim() !== '') {
        const searchTerm = this.searchQuery.toLowerCase();
        this.filteredHistoryLog = this.historyLog.filter(
          (log) => log.email.toLowerCase().includes(searchTerm)
        );
      } else {
        // If search query is empty, show all history logs
        this.filteredHistoryLog = [...this.historyLog];
      }
    },

    clearSearch() {
      // Clear the search query and display the whole history log
      this.searchQuery = '';
      this.filteredHistoryLog = [...this.historyLog];
    },
  },
};
</script>

<style lang="scss" scoped>
@import "pages/seniorhigh-folder/senior-style/SeniorHistory.scss";
</style>
