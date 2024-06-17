import {
  QCalendarResource,
  today,
} from "@quasar/quasar-ui-qcalendar/src/QCalendarResource.js";
import "@quasar/quasar-ui-qcalendar/src/QCalendarVariables.sass";
import "@quasar/quasar-ui-qcalendar/src/QCalendarTransitions.sass";
import "@quasar/quasar-ui-qcalendar/src/QCalendarResource.sass";
import { defineComponent, ref } from "vue";
import axios from "axios";

export default defineComponent({
  name: "ResourceSlotResourceIntervals",
  components: {
    QCalendarResource,
  },

  data() {
    return {
      availabilityDays: [], // Maglalaman ng mga availability days ng instructor
      selectedAvailabilityDay: "",
      showDialog: false,
      formData: {
        instructor: "",
        subjectname: "",
        day: "",
        room: "",
        time_from: "",
        time_to: "",
      },
      instructors: [],
      selectedDate: today(),
      locale: "en-US",
      resources: [
        { id: "1", name: "Monday" },
        { id: "2", name: "Tuesday" },
        { id: "3", name: "Wednesday" },
        { id: "4", name: "Thursday" },
        { id: "5", name: "Friday" },
        { id: "6", name: "Saturday" },
      ],
      events: {},
      resourceWidth: 60, // Initial value for resource width
      resourceHeight: 180, // Initial value for resource height
      cellWidth: 220,
      year: ["1st Year", "2nd Year", "3rd Year", "4th Year"],
      block: ["Block A", "Block B", "Block C", "Block D"],
      year_model: ref(null),
      block_model: ref(null),
      isYearSelected: false,
    };
  },

  computed: {
    // Computed property to check if the form is invalid
    isAddButtonDisabled() {
      return !this.year_model || !this.block_model;
    },
    isFormInvalid() {
      return Object.values(this.formData).some((value) => !value); // Returns true if any field is empty
    },
  },

  mounted() {
    this.fetchEventsFromBackend();
    this.fetchInstructors();
    this.getAvailabilityDays();
  },

  watch: {
    // Watch for changes in the instructor form data
    "formData.instructor": {
      handler: "getAvailabilityDays", // Call getAvailabilityDays method when formData.instructor changes
      immediate: true, // Call the handler immediately on component mount
    },
    year_model: function (newVal, oldVal) {
      this.selectedYear = newVal;
      this.handleYearAndBlockSelection(); // Tawagin ang method para ma-update ang isYearSelected
    },
    // Watch para sa pagbabago sa selected block
    block_model: function (newVal, oldVal) {
      this.selectedBlock = newVal;
      this.handleYearAndBlockSelection(); // Tawagin ang method para ma-update ang isYearSelected
    },
  },
  methods: {
    handleYearSelection() {
      // Check if both year and block are selected
      if (this.year_model && this.block_model) {
        this.isYearSelected = true; // Enable calendar rendering
      } else {
        this.isYearSelected = false; // Disable calendar rendering if any selection is missing
      }
    },
    showNotification(message) {
      this.$q.notify({
        message: message,
        color: "negative",
        position: "top",
        timeout: 3000, // You can adjust the timeout as needed
      });
    },

    // Method to handle the click event on the disabled button
    handleDisabledButtonClick() {
      this.showNotification("Please select year and block 1st");
    },
    async getAvailabilityDays() {
      try {
        console.log("Selected instructor:", this.formData.instructor.value); // Gamitin ang .value property para makuha ang value
        const response = await axios.get(
          "https://forbesscheduling.000webhostapp.com/server/getAvailabilityFullnames.php"
        );
        console.log("Response from server:", response.data);

        // Hanapin ang tamang record para sa piniling instructor fullname
        const selectedInstructor = response.data.find(
          (item) => item.fullname === this.formData.instructor.value
        ); // Gamitin ang .value property dito rin
        console.log("Selected instructor:", selectedInstructor);

        if (selectedInstructor) {
          // Kung nakatagpo ng record, ilagay ang mga availability_days sa q-select options
          this.availabilityDays = selectedInstructor.availability_days.map(
            (day) => ({
              label: day,
              value: day,
            })
          );
        } else {
          // Kung walang record na nakita, i-reset ang availabilityDays
          this.availabilityDays = [];
        }
      } catch (error) {
        console.error("Error fetching availability days:", error);
      }
    },
    async fetchInstructors() {
      try {
        const response = await axios.get(
          "https://forbesscheduling.000webhostapp.com/server/getAvailabilityFullnames.php"
        );
        console.log("Response from server:", response.data);

        // Map the response data to create an array of options for the instructor select
        this.instructors = response.data.map((item) => ({
          label: item.fullname,
          value: item.fullname,
        }));
      } catch (error) {
        console.error("Error fetching instructors:", error);
      }
    },
    async fetchEventsFromBackend() {
      try {
        const response = await axios.get(
          "https://forbesscheduling.000webhostapp.com/server/get_schedule.php"
        );
        if (Array.isArray(response.data)) {
          this.processEvents(response.data);
        } else {
          console.error("Error fetching events: Response data is not an array");
        }
      } catch (error) {
        console.error("Error fetching events:", error);
      }
    },
    processEvents(data) {
      // Initialize an object to store the width of each event ID
      const eventWidths = {};

      data.forEach((event) => {
        const resourceId = this.getResourceId(event.day);
        const eventId = event.id;
        const eventKey =
          resourceId + "-" + event.time_from + "-" + event.time_to; // Combine resource ID, start time, and end time to uniquely identify each event

        // Calculate event duration
        const startTime = new Date(`2024-02-12T${event.time_from}`);
        const endTime = new Date(`2024-02-12T${event.time_to}`);
        const durationInMinutes = this.calculateDuration(startTime, endTime);

        // Create a new event object
        const newEvent = {
          id: eventId, // Store the event ID
          start: startTime,
          end: endTime,
          title: `${event.subjectname} - ${event.instructor} - ${event.room}`,
          duration: durationInMinutes,
          instructor: event.instructor,
          subjectName: event.subjectname,
          room: event.room,
          stacked: false, // New property to indicate if the event is stacked
        };

        // Check if the events array for the current resource ID is undefined
        if (!Array.isArray(this.events[resourceId])) {
          // If it's undefined, initialize it as an empty array
          this.events[resourceId] = [];
        }

        // Push the new event to the events array
        this.events[resourceId].push(newEvent);

        // Check if the event ID is already present in the eventWidths object
        if (!eventWidths[eventKey]) {
          eventWidths[eventKey] = durationInMinutes;
        } else {
          // If the event ID is already present, update the width if the current event has a larger duration
          if (eventWidths[eventKey] < durationInMinutes) {
            eventWidths[eventKey] = durationInMinutes;
          }
        }
      });

      // Save the event widths for later use
      this.eventWidths = eventWidths;
    },

    getEvents(scope) {
      return this.events[scope.resource.id] || [];
    },
    getResourceId(day) {
      switch (day.toLowerCase()) {
        case "monday":
          return "1";
        case "tuesday":
          return "2";
        case "wednesday":
          return "3";
        case "thursday":
          return "4";
        case "friday":
          return "5";
        case "saturday":
          return "6";
        default:
          return "1"; // Default to Monday if day is not recognized
      }
    },
    calculateDuration(startTime, endTime) {
      const durationInMilliseconds = endTime - startTime;
      const durationInMinutes = durationInMilliseconds / (1000 * 60);
      return durationInMinutes;
    },
    getStyle(event, index, scope) {
      // Get the ID of the current resource
      const resourceId = scope.resource.id;

      // Calculate the left position based on start time
      const startHour = event.start.getHours();
      const startMinute = event.start.getMinutes();
      const totalStartMinutes = startHour * 60 + startMinute;
      const left = (totalStartMinutes - 6 * 60) * (1200 / (15 * 21.8)); // Adjusted calculation

      // Calculate the width based on the duration of the event
      const durationInMinutes = event.duration;
      const width = durationInMinutes * (1200 / (15 * 21.8)); // Adjusted calculation

      // Calculate the height based on the number of lines of text in the badge
      const lineHeight = 15; // Adjust as needed based on your design
      const numLines = Math.ceil(event.title.length / 20); // Assuming 20 characters per line, adjust as needed
      const height = numLines * lineHeight + 5; // Added 5 pixels for padding

      // Calculate top position
      let top = (totalStartMinutes - 6 * 60) * (140 / (25 * 60)); // Adjusted calculation

      // Find the index of the previous event
      const prevEvent = this.events[resourceId][index - 1];

      // If there is a previous event and its end time is after the start time of the current event,
      // adjust the top position to stack the current event below the previous one
      if (prevEvent && prevEvent.end > event.start) {
        const prevStartHour = prevEvent.start.getHours();
        const prevStartMinute = prevEvent.start.getMinutes();
        const prevTotalStartMinutes = prevStartHour * 60 + prevStartMinute;
        const prevHeight = Math.ceil(prevEvent.title.length / 20) * lineHeight; // Height of previous event
        top = prevTotalStartMinutes * (140 / (15 * 60)) + prevHeight + -50; // Add margin of 5 pixels
      }

      return {
        position: "absolute",
        background: "white",
        left: left + "px",
        top: top + "px",
        width: width + "px", // Set the width based on the duration of the event
        height: height + "px", // Set the height dynamically based on content
      };
    },

    async submitForm() {
      try {
        const response = await axios.post(
          "https://forbesscheduling.000webhostapp.com/server/schedule.php",
          {
            newEvent: this.formData,
          }
        );
        if (response.data.success) {
          this.formData = {
            instructor: "",
            subjectname: "",
            day: "",
            room: "",
            time_from: "",
            time_to: "",
          };
          this.showDialog = false;
          console.log("Event added successfully!");
        } else {
          console.error("Error adding event:", response.data.message);
        }
      } catch (error) {
        console.error("Error:", error);
      }
    },
  },
});
