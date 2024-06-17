import auth from "src/Auth/auth";
import axios from "axios";

export default {
  data() {
    return {
      email: auth.email,
      roleInstructorCounts: [], // Change the name to reflect instructor counts
    };
  },
  beforeRouteEnter(to, from, next) {
    if (!auth.isLoggedIn) {
      next({ name: "login" });
    } else {
      axios
        .get(
          "https://forbesscheduling.000webhostapp.com/server/countInstructors.php", // Update endpoint URL
          {
            params: { email: auth.email },
          }
        )
        .then((response) => {
          if (response.data.error) {
            console.error(response.data.error);
            next(false); // Abort navigation
          } else {
            // Use the function passed to next to set data in the component instance
            next((vm) => {
              vm.roleInstructorCounts = response.data; // Update the property to store instructor counts
            });
          }
        })
        .catch((error) => {
          console.error(error);
          next(false); // Abort navigation
        });
    }
  },
  methods: {
    handleLogout() {
      auth.logout();
      this.$router.push({ name: "login" });
    },
    getInstructorCount(course) {
      // Change method name to reflect instructor counts
      const count = this.roleInstructorCounts.find(
        (item) => item.course === course
      );
      return count ? count.totalInstructorCount : 0; // Update to retrieve totalInstructorCount
    },
  },
};
