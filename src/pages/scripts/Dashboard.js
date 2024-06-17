import auth from "src/Auth/auth";
import { ref, onMounted } from "vue";
import axios from "axios";

export default {
  data() {
    return {
      email: auth.email, // You may set this value after successful login
    };
  },
  setup() {
    const availabilities = ref([]);
    const selectedTimeAM = ref("00:00");
    const selectedTimePM = ref("00:00");
    const modalTimeAM = ref("00:00");
    const modalTimePM = ref("00:00");
    const selectedDay = ref(null);
    const options_day = ref([
      "Monday",
      "Tuesday",
      "Wednesday",
      "Thursday",
      "Friday",
      "Saturday",
    ]);
    const isSaved = ref(false);

    const onOKClick = (period) => {
      // Update the selected time based on the period (AM or PM)
      if (period === "AM") {
        selectedTimeAM.value = modalTimeAM.value;
      } else {
        selectedTimePM.value = modalTimePM.value;
      }
    };

    const saveAvailability = async () => {
      try {
        // Send data to the server
        const response = await axios.post(
          "https://forbesscheduling.000webhostapp.com/server/availability.php",
          {
            email: auth.email,
            selectedDay: selectedDay.value,
            selectedTimeAM: selectedTimeAM.value,
            selectedTimePM: selectedTimePM.value,
          }
        );

        console.log(response.data);

        // Set isSaved to true after successful save
        if (response.data.success) {
          const userID = response.data.userID; // Adjust this based on the actual key in your response
          console.log("User ID:", userID);

          // Set isSaved to true after successful save
          isSaved.value = true;

          // Optionally, you can handle the response as needed
          // For example, show a success message to the user
        } else {
          // Handle the case where data insertion fails
          console.error("Error inserting data");
        }
      } catch (error) {
        console.error("Error saving availability", error);
        // Handle error, show error message to the user, etc.
      }
    };

    onMounted(async () => {
      try {
        // Make a GET request to get availability data
        const response = await axios.get(
          "https://forbesscheduling.000webhostapp.com/server/getAvailabilityData.php"
        );

        // Update the reactive reference with the retrieved data
        if (response.data && Array.isArray(response.data)) {
          availabilities.value = response.data;
        }
      } catch (error) {
        console.error("Error fetching availability data", error);
        // Handle error, show error message to the user, etc.
      }
    });

    return {
      selectedTimeAM,
      selectedTimePM,
      modalTimeAM,
      modalTimePM,
      onOKClick,
      options_day,
      selectedDay,
      saveAvailability,
      isSaved,
      availabilities,
    };
  },

  computed: {
    formattedSelectedTimeAM() {
      // Convert selectedTimeAM to AM/PM format
      const timeArray = this.selectedTimeAM.split(":");
      const hours = parseInt(timeArray[0]);
      const minutes = parseInt(timeArray[1]);

      // Check if the time is 00:00, i.e., not chosen yet
      if (hours === 0 && minutes === 0) {
        return "AM";
      }

      const period = hours < 12 ? "AM" : "PM";
      const formattedHours = hours % 12 === 0 ? 12 : hours % 12;
      return `${formattedHours.toString().padStart(2, "0")}:${minutes
        .toString()
        .padStart(2, "0")} ${period}`;
    },
    formattedSelectedTimePM() {
      // Convert selectedTimePM to AM/PM format
      const timeArray = this.selectedTimePM.split(":");
      const hours = parseInt(timeArray[0]);
      const minutes = parseInt(timeArray[1]);

      // Check if the time is 00:00, i.e., not chosen yet
      if (hours === 0 && minutes === 0) {
        return "PM";
      }

      const period = hours < 12 ? "AM" : "PM";
      const formattedHours = hours % 12 === 0 ? 12 : hours % 12;
      return `${formattedHours.toString().padStart(2, "0")}:${minutes
        .toString()
        .padStart(2, "0")} ${period}`;
    },
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
  methods: {
    handleLogout() {
      // Handle the logout event

      auth.logout();
      window.location.reload();

      // Redirect back to the login page
      this.$router.push({ name: "login" });
    },
  },
};
