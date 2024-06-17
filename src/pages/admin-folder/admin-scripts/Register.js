import axios from "axios";
import { ref, reactive, watch } from "vue";

export default {
  data() {
    return {
      fullname: "",
      department: "",
      position: "",
      course: "",
      email: "",
      password: "",
      showPassword: false,
      isFormValid: false,
    };
  },
  computed: {
    courseOptions() {
      // Return the course options based on the selected position
      return this.position === "Instructor"
        ? this.options_course[this.department] || []
        : [];
    },
  },
  setup() {
    const options_department = ref([
      "CITE",
      "Criminology",
      "Marketing",
      "Public Administration",
      "Microfinance",
      "Senior High",
    ]);

    const options_position = ref([
      "Program Head",
      "Senior High Coordinator",
      "Dean",
      "Academic Coordinator",
      "Admin",
      "Registrar",
      "Instructor",
    ]);

    const options_course = reactive({
      CITE: [
        "Information Technology",
        "Animation",
        // Add more courses as needed
      ],
      Criminology: [
        "Criminal Investigation",
        "Forensic Science",
        // Add more courses as needed
      ],
      Marketing: [
        "Digital Marketing",
        "Brand Management",
        // Add more courses as needed
      ],
      "Public Administration": [
        "Public Policy",
        "Human Resource Management",
        // Add more courses as needed
      ],
      Microfinance: [
        "Microcredit",
        "Financial Management",
        // Add more courses as needed
      ],
      "Senior High": [
        "TVL Track",
        "General Academic Strand",
        // Add more courses as needed
      ],
    });

    watch(
      () => options_position.value,
      (newRole) => {}
    );

    return {
      options_department,
      options_position,
      options_course,
    };
  },
  watch: {
    // Watch for changes in form fields and update isFormValid accordingly
    fullname: "validateForm",
    department: "validateForm",
    position: "validateForm",
    email: "validateForm",
    password: "validateForm",
    course: "validateForm",
  },
  methods: {
    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;
    },

    goToDashboard() {
      this.$router.push("/admin/account");
    },

    validateForm() {
      this.isFormValid =
        !!this.fullname &&
        !!this.department &&
        !!this.position &&
        !!this.email &&
        !!this.password &&
        ((this.position === "Instructor" && !!this.course) ||
          this.position !== "Instructor");
    },

    async register() {
      try {
        // Validate the form before submitting
        this.validateForm();

        if (!this.isFormValid) {
          this.$q.notify({
            message: "Please fill in all required fields.",
            color: "warning",
          });
          return;
        }

        // Check if email is from GSuite account
        if (!this.email.endsWith("@forbescollege.org")) {
          this.$q.notify({
            message: "Use only forbes g-suite account.",
            color: "negative",
          });
          return;
        }

        const response = await axios.post(
          "https://forbesscheduling.000webhostapp.com/server/register.php",
          {
            fullname: this.fullname,
            department: this.department,
            position: this.position,
            email: this.email,
            password: this.password,
            course: this.position === "Instructor" ? this.course : null,
          },
          {
            headers: {
              "Content-Type": "application/json",
            },
          }
        );

        if (response.data && response.data.success) {
          this.$q.notify({
            message: "New User Added!",
            color: "positive",
          });
          this.$router.push({ name: "account" });
        } else {
          this.$q.notify({
            message: "Registration failed",
            color: "negative",
          });
        }
      } catch (error) {
        console.error("Error registering user:", error);
        this.$q.notify({
          message: `Registration failed. ${error.message || "Unknown error"}`,
          color: "negative",
        });
      }
    },
  },
};
