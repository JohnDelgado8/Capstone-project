export default {
  data() {
    return {
      historyLog: [],
      historyLogColumns: [
        { name: "id", label: "ID", align: "left", field: "id" },
        { name: "action", label: "Action", align: "left", field: "action" },
        { name: "email", label: "Email", align: "left", field: "email" },
        {
          name: "timestamp",
          label: "Timestamp",
          align: "left",
          field: "timestamp",
        },
        // Add more columns as needed
      ],
    };
  },
  mounted() {
    this.fetchHistoryLog();
  },
  methods: {
    fetchHistoryLog() {
      // Make an API request to fetch history log data
      // Adjust the URL based on your server setup
      axios
        .get(
          "https://forbesscheduling.000webhostapp.com/server/history-log.php"
        )
        .then((response) => {
          this.historyLog = response.data;
        })
        .catch((error) => {
          console.error("Error fetching history log:", error);
        });
    },
  },
};
