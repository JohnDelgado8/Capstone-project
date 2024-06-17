import auth from "src/Auth/auth";
import axios from "axios";

export default {
  data() {
    return {
      email: auth.email,
      instructorData: [],
      loading: false,
      error: null,
    };
  },
  computed: {
    animationInstructors() {
      return this.instructorData.filter(
        (instructor) => instructor.course === "Animation"
      );
    },
    itInstructors() {
      return this.instructorData.filter(
        (instructor) => instructor.course === "Information Technology"
      );
    },
  },
  beforeRouteEnter(to, from, next) {
    if (!auth.isLoggedIn) {
      next({ name: "login" });
    } else {
      next((vm) => {
        vm.loading = true; // Set loading state
        axios
          .get(
            "https://forbesscheduling.000webhostapp.com/server/instructorlist.php"
          )
          .then((response) => {
            console.log("Instructor data:", response.data); // Log the response for debugging
            vm.instructorData = response.data;
          })
          .catch((error) => {
            console.error("Error fetching data:", error);
            vm.error = error;
          })
          .finally(() => {
            vm.loading = false; // Clear loading state
          });
      });
    }
  },
  methods: {
    handleLogout() {
      auth.logout();
      this.$router.push({ name: "login" });
    },
  },
};
