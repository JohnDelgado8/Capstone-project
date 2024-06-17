<template>
  <q-page>
    <q-card class="q-pa-md" style="background-color: #f2f2f2; height: 100vh;">
      <div class="text-h5 q-mb-md text-bold">History Log</div>
      <q-table :rows="historyLogs" :columns="columns" row-key="id">
      </q-table>
      <div class="row">
        <div class="col" style="text-align: end;">
          <q-btn class="q-mt-md" @click="goToAccountTable" label="Back to Account" color="primary" />
        </div>
      </div>
    </q-card>
  </q-page>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      historyLogs: [], // Store history logs
      columns: [
        {
          name: 'Action',
          required: true,
          label: 'Action',
          align: 'left',
          field: row => row.action,
        },
        {
          name: 'Details',
          required: true,
          label: 'Details',
          align: 'left',
          field: row => row.details,
        },
        {
          name: 'Timestamp',
          required: true,
          label: 'Timestamp',
          align: 'left',
          field: row => row.timestamp,
        },
      ],
    };
  },
  created() {
    // Fetch history logs when component is created
    this.fetchHistoryLogs();
  },
  methods: {
    goToAccountTable() {
      this.$router.push({ name: 'account' });
    },
    fetchHistoryLogs() {
      // Make a GET request to fetch history logs
      axios.get("https://forbesscheduling.000webhostapp.com/server/get_history.php")
        .then(response => {
          // Assign fetched history logs to historyLogs array
          this.historyLogs = response.data;
        })
        .catch(error => {
          console.error('Error fetching history logs:', error);
        });
    }
  },
};
</script>

<style scoped>
/* Add your scoped styles here */
</style>
