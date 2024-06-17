import axios from "axios";

export default {
  data() {
    return {
      historyLog: [],
      filteredHistoryLog: [],
      historyLogColumns: [
        { name: "id", label: "ID", align: "left", field: "id" },
        { name: "action", label: "Action", align: "left", field: "action" },
        {
          name: "email",
          label: "Email",
          align: "left",
          field: "email",
        },
        {
          name: "timestamp",
          label: "Date & Time",
          align: "left",
          field: "timestamp",
        },
        // Add more columns as needed
      ],
      searchQuery: "",
    };
  },
  mounted() {
    this.fetchHistoryLog();
  },
  methods: {
    fetchHistoryLog() {
      axios
        .get("https://forbesscheduling.000webhostapp.com/server/history.php")
        .then((response) => {
          console.log("History Log Data:", response.data); // Log the response to the console
          this.historyLog = response.data;
          this.filteredHistoryLog = response.data; // Set initial filtered data
        })
        .catch((error) => {
          console.error("Error fetching history log:", error);
        });
    },

    searchByEmail() {
      // Filter the history log based on the search query
      if (this.searchQuery.trim() !== "") {
        const searchTerm = this.searchQuery.toLowerCase();
        this.filteredHistoryLog = this.historyLog.filter((log) =>
          log.email.toLowerCase().includes(searchTerm)
        );
      } else {
        // If search query is empty, show all history logs
        this.filteredHistoryLog = [...this.historyLog];
      }
    },

    clearSearch() {
      // Clear the search query and display the whole history log
      this.searchQuery = "";
      this.filteredHistoryLog = [...this.historyLog];
    },
  },
};
