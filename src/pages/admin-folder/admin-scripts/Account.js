import auth from "src/Auth/auth";
import axios from "axios";

export default {
  data() {
    return {
      email: auth.email,
      tableData: [],
      fullTableData: [], // Add fullTableData array to store the full fetched data
      columns: [
        { name: "id", label: "ID", align: "left", field: "id" },
        {
          name: "fullname",
          label: "Fullname",
          align: "left",
          field: "fullname",
        },
        {
          name: "department",
          label: "Department",
          align: "left",
          field: "department",
        },
        {
          name: "position",
          label: "Position",
          align: "left",
          field: "position",
        },
        { name: "course", label: "Course", align: "left", field: "course" },
        { name: "email", label: "Email", align: "left", field: "email" },
        { name: "status", label: "Status", align: "left", field: "status" },
        { name: "action", label: "Action", align: "left", field: "action" },
      ],
      selectedPosition: null,
      positions: [], // Array to store available positions
    };
  },
  beforeRouteEnter(to, from, next) {
    if (!auth.isLoggedIn) {
      next({ name: "login" });
    } else {
      next();
    }
  },
  mounted() {
    this.fetchPositions();
    this.fetchData();
  },
  watch: {
    selectedPosition(newVal, oldVal) {
      // Call searchByPosition method when selectedPosition changes
      this.searchByPosition();
    },
  },
  methods: {
    handleLogout() {
      auth.logout();
      window.location.reload();
      this.$router.push({ name: "login" });
    },
    searchByPosition() {
      if (this.selectedPosition) {
        this.tableData = this.fullTableData.filter(
          (user) => user.position === this.selectedPosition
        );
      } else {
        this.fetchData();
      }
    },
    clearSearch() {
      this.selectedPosition = null;
      this.fetchData();
    },
    fetchData() {
      axios
        .get("https://forbesscheduling.000webhostapp.com/server/account.php")
        .then((response) => {
          this.fullTableData = response.data.map((user) => ({
            id: user.id,
            fullname: user.fullname,
            department: user.department,
            position: user.position,
            course: user.course,
            email: user.email,
            status: user.status,
          }));
          this.tableData = [...this.fullTableData];
        })
        .catch((error) => {
          console.error("Error fetching data:", error);
        });
    },

    redirectToEditPage(userId) {
      // Redirect to the registration page with the user ID as a query parameter
      this.$router.push({ name: "edit", query: { userId } });
    },
    fetchPositions() {
      axios
        .get("https://forbesscheduling.000webhostapp.com/server/positions.php")
        .then((response) => {
          // Assuming the positions are returned as an array of strings

          this.positions = response.data;
        })
        .catch((error) => {
          console.error("Error fetching positions:", error);
        });
    },
    toggleStatus(accountId, currentStatus) {
      const newStatus = currentStatus === "active" ? "inactive" : "active";

      // Make a request to update the user status in the database
      axios
        .put(
          `https://forbesscheduling.000webhostapp.com/server/update-status.php?id=${accountId}&status=${newStatus}`
        )
        .then((response) => {
          // Handle success, update the UI or show a notification
          this.$q.notify({
            message: `User status updated to ${newStatus}`,
            color: "positive",
          });

          // Update the status in the UI without waiting for fetchData()
          const userIndex = this.tableData.findIndex(
            (user) => user.id === accountId
          );
          if (userIndex !== -1) {
            this.$set(this.tableData[userIndex], "status", newStatus);
          }

          // Update the status in the fullTableData array for consistency
          const fullUserIndex = this.fullTableData.findIndex(
            (user) => user.id === accountId
          );
          if (fullUserIndex !== -1) {
            this.$set(this.fullTableData[fullUserIndex], "status", newStatus);
          }
        })
        .catch((error) => {
          // Handle error, show an error message
          console.error("Error updating user status:", error);
        });
    },
  },
};
