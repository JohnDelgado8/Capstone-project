import auth from "src/Auth/auth";
import { ref, onMounted } from "vue";
import axios from "axios";

export default {
  data() {
    return {
      email: auth.email,
      resetter: { resetInputs: null }, // Create a ref to hold the resetInputs method
      days: [
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
      ],
    };
  },
  setup() {
    const availabilities = ref([]);
    const filter = ref("");
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
    const columns = [
      {
        name: "DAY",
        label: "Day:",
        align: "left",
        field: "DAY",
        sortable: true,
      },
      {
        name: "TIME_FROM",
        label: "Time From",
        align: "left",
        field: "TIME_FROM",
        sortable: true,
      },
      {
        name: "TIME_TO",
        label: "Time To",
        align: "left",
        field: "TIME_TO",
        sortable: true,
      },
    ];
    const isSaved = ref(false);
    const selected = ref([]);

    // Assign the resetInputs method to the ref object
    onMounted(async () => {
      try {
        const response = await axios.get(
          `http://localhost/Capstone-System/capstone_scheduling/API/getAvailabilityData.php?email=${auth.email}`
        );
        console.log("API Response:", response.data);

        if (response.data && Array.isArray(response.data)) {
          availabilities.value = response.data;
        }
        console.log(availabilities.value);
      } catch (error) {
        console.error("Error fetching availability data", error);
      }
    });
    const resetter = ref({
      resetInputs: () => {
        selectedDay.value = null;
        selectedTimeAM.value = "00:00";
        selectedTimePM.value = "00:00";
      },
    });
    `http://localhost/Capstone-System/capstone_scheduling/API/getAvailabilityData.php?email=${auth.email}`;

    const onOKClick = (period) => {
      if (period === "AM") {
        selectedTimeAM.value = modalTimeAM.value;
      } else {
        selectedTimePM.value = modalTimePM.value;
      }
    };

    const saveAvailability = async () => {
      try {
        const response = await axios.post(
          "http://localhost/Capstone-System/capstone_scheduling/API/availability.php",
          {
            email: auth.email,
            selectedDay: selectedDay.value,
            selectedTimeAM: selectedTimeAM.value,
            selectedTimePM: selectedTimePM.value,
          }
        );

        console.log(response.data);

        if (response.data.success) {
          resetter.value.resetInputs(); // Call the resetInputs method from the ref object
          const userID = response.data.userID;
          console.log("User ID:", userID);

          isSaved.value = true;
        } else {
          console.error("Error inserting data");
        }
      } catch (error) {
        console.error("Error saving availability", error);
      }
    };

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
      resetter, // Expose the ref object
      filter,
      columns,
    };
  },

  computed: {
    formattedSelectedTimeAM() {
      const timeArray = this.selectedTimeAM.split(":");
      const hours = parseInt(timeArray[0]);
      const minutes = parseInt(timeArray[1]);

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
      const timeArray = this.selectedTimePM.split(":");
      const hours = parseInt(timeArray[0]);
      const minutes = parseInt(timeArray[1]);

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
      next({ name: "login" });
    } else {
      next();
    }
  },

  methods: {
    formatTime(time) {
      return formattedTime;
    },
    getAvailabilitiesByDay(day) {
      return this.availabilities.filter(
        (availability) => availability.DAY === day
      );
    },

    handleLogout() {
      auth.logout();
      window.location.reload();
      this.$router.push({ name: "login" });
    },
  },
};
