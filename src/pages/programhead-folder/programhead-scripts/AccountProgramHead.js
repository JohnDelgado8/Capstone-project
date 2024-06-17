import auth from "src/Auth/auth";
import axios from "axios";

export default {
  data() {
    return {
      userData: null,
      email: auth.email, // You may set this value after successful
    };
  },
  beforeRouteEnter(to, from, next) {
    if (!auth.isLoggedIn) {
      // Redirect to the login page if the user is not logged
      next({ name: "login" });
    } else {
      // Continue to the dashboard if the user is logged in
      next();
    }
  },

  mounted() {
    this.fetchData();
  },

  methods: {
    handleLogout() {
      // Handle the logout event

      auth.logout();

      // Redirect back to the login page
      this.$router.push({ name: "login" });
    },

    fetchData() {
      axios
        .get(
          "https://forbesscheduling.000webhostapp.com/server/accountmanagement.php",
          {
            params: {
              email: this.email,
            },
          }
        )
        .then((response) => {
          this.userData = response.data; // Store the user's data
        })
        .catch((error) => {
          console.error("Error fetching data:", error);
        });
    },
  },
};
