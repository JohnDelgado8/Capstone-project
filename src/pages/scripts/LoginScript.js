import { useQuasar } from "quasar";
import { Notify, Loading } from "quasar";
import { ref } from "vue";
import auth from "src/Auth/auth";

export default {
  setup() {
    const $q = useQuasar();
  },
  data() {
    return {
      loggedIn: false,
      showPassword: false,
      email: ref(""),
      password: ref(""),
      loading: false, // Added loading state
    };
  },
  methods: {
    redirectToForgotPasswordPage() {
      // Redirect the user to the forgot password page using Vue Router
      this.$router.push({ name: "forgot" }); // Adjust the route name as per your router configuration
    },
    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;
    },
    login() {
      // Show global loading indicator
      Loading.show();

      // Simulate a 2-3 seconds loading delay
      setTimeout(() => {
        // Call the PHP backend for authentication
        fetch("https://forbesscheduling.000webhostapp.com/server/login.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            email: this.email,
            password: this.password,
          }),
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              // Successful login
              auth.login(this.email);
              const userRole = data.position;
              const userDepartment = data.department;
              const course = data.course;

              if (userRole === "Dean") {
                this.$router.push({ name: "dean-page" });
              } else if (userRole === "Program Head") {
                // Determine the department and redirect accordingly
                if (userDepartment === "CITE") {
                  this.$router.push({
                    name: "program-head-information-technology",
                  });
                } else if (userDepartment === "Marketing") {
                  this.$router.push({ name: "program-head-marketing-page" });
                } else if (userDepartment === "Senior High") {
                  this.$router.push({ name: "senior-high-department-subject" });
                } else if (userDepartment === "Criminology") {
                  this.$router.push({ name: "program-head-criminology" });
                } else if (userDepartment === "Public Administration") {
                  this.$router.push({ name: "program-head-businessadmin" });
                } else if (userDepartment === "Microfinance") {
                  this.$router.push({ name: "program-head-microfinance" });
                } else {
                  // Handle other departments or provide a default redirect
                  this.$router.push({ name: "program-head-default" });
                }
              } else if (userRole === "Admin") {
                this.$router.push({ name: "homepage" });
              } else if (userRole === "Senior High Coordinator") {
                this.$router.push({ name: "senior-high-subject" });
              } else if (userRole === "Academic Coordinator") {
                this.$router.push({ name: "academic-coordinator-table" });
              } else if (userRole === "Instructor") {
                if (course === "Animation") {
                  this.$router.push({ name: "animation-page" });
                } else if (course === "Information Technology") {
                  this.$router.push({ name: "IT-subject" });
                } else if (course === "Criminal Investigation") {
                  this.$router.push({ name: "CrimInvest-subject" });
                } else if (course === "Forensic Science") {
                  this.$router.push({ name: "ForenScience-subject" });
                } else if (course === "Digital Marketing") {
                  this.$router.push({ name: "DigiMarketing-subject" });
                } else if (course === "Brand Management") {
                  this.$router.push({ name: "BrandManagement-page" });
                } else if (course === "Public Policy") {
                  this.$router.push({ name: "PublicPolicy-subject" });
                } else if (course === "Human Resource Management") {
                  this.$router.push({ name: "HRM-subject" });
                } else if (course === "Microcredit") {
                  this.$router.push({ name: "MicroCredit-subject" });
                } else if (course === "Financial Management") {
                  this.$router.push({ name: "FinancialManagement-subject" });
                } else if (course === "TVL Track") {
                  this.$router.push({ name: "TVL-subject" });
                } else if (course === "General Academic Strand") {
                  this.$router.push({ name: "GAS-subject" });
                } else {
                  // Handle other courses or provide a default redirect
                  this.$router.push({ name: "defaultDashboard" });
                }
              } else if (userRole === "Registrar") {
                this.$router.push({ name: "registrar-table" });
              } else {
                // Default redirection for other positions
                this.$router.push({ name: "defaultDashboard" });
              }

              this.loggedIn = true;
              Notify.create({
                type: "positive",
                message: "Login successful",
              });

              // Remove the following line, as it may cause unexpected behavior
              // this.$router.push({ name: "homepage" });
              console.log("Welcome to dashboard");

              // Redirect to the dashboard
            } else {
              // Failed login, handle accordingly
              Notify.create({
                type: "negative",
                message: "Wrong Credentials",
              });
            }
          })
          .catch((error) => console.error("Error:", error))
          .finally(() => {
            // Hide global loading indicator
            Loading.hide();

            // Set loading to false regardless of the outcome
            this.loading = false;
          });
      }, 2000); // 2 seconds delay (adjust as needed)
    },
  },
  components: {},
};
