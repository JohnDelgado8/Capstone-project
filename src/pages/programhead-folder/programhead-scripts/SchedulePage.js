import axios from "axios";

const days = [
  "Monday",
  "Tuesday",
  "Wednesday",
  "Thursday",
  "Friday",
  "Saturday",
];

export default {
  data() {
    return {
      schedule: [],
      mergedTimeSlots: [],
      // Array to hold time slots from 6 am to 7 pm
      timeColumn: [
        {
          name: "time",
          required: true,
          label: "Time",
          align: "left",
          field: "time",
          style: "border-right: 1px solid #ddd",
        },
        // Add day columns
        ...days.map((day) => ({
          name: day.toLowerCase(),
          required: true,
          label: day,
          align: "left",
          field: day.toLowerCase(), // Make sure field matches the lowercase name of the day
          style: "border-right: 1px solid #ddd",
        })),
      ],
      days: days,
      isAddEventModalOpen: false,
      selectedEvent: {
        timeFrom: "",
        timeTo: "",
        day: "",
        subjectName: "",
      },
    };
  },

  methods: {
    openAddEventModal() {
      this.isAddEventModalOpen = true;
    },
    closeAddEventModal() {
      this.isAddEventModalOpen = false;
    },
    addEvent() {
      const eventData = {
        timeFrom: this.selectedEvent.timeFrom,
        timeTo: this.selectedEvent.timeTo,
        day: this.selectedEvent.day,
        subjectName: this.selectedEvent.subjectName,
      };

      axios
        .post(
          "https://forbesscheduling.000webhostapp.com/server/schedule.php",
          eventData
        )
        .then((response) => {
          const data = response.data;
          if (data.success) {
            this.updateSchedule();
            this.closeAddEventModal();
          } else {
            console.error("Error inserting event:", data.message);
          }
        })
        .catch((error) => {
          console.error("Error inserting event:", error);
        });
    },
    updateSchedule() {
      axios
        .get(
          "https://forbesscheduling.000webhostapp.com/server/get_schedule.php"
        )
        .then((response) => {
          this.schedule = response.data;

          // Reset all time slots data to empty strings
          this.generateTimeSlots();

          // Iterate through the schedule and update the table data accordingly
          this.schedule.forEach((event) => {
            const { timeFrom, timeTo, day, subjectName } = event;
            const fromHour = parseInt(timeFrom.split(":")[0]);
            const toHour = parseInt(timeTo.split(":")[0]);

            // Find the row index corresponding to the timeFrom and timeTo
            const startIndex = fromHour - 6;
            const endIndex = toHour - 6;

            // Update the data in the table for the time range
            for (let i = startIndex; i <= endIndex; i++) {
              // Check if the cell already contains a subject, if not, add the subject name
              if (!this.mergedTimeSlots[i][day.toLowerCase()]) {
                this.mergedTimeSlots[i][day.toLowerCase()] = subjectName;
              } else {
                // If cell already contains a subject, append to it
                this.mergedTimeSlots[i][
                  day.toLowerCase()
                ] += ` / ${subjectName}`;
              }
            }
          });

          console.log("Merged Time Slots:", this.mergedTimeSlots); // Debugging: Print merged time slots data
        })
        .catch((error) => {
          console.error("Error fetching schedule:", error);
        });
    },

    // Method to generate time slots from 6 am to 7 pm
    generateTimeSlots() {
      const hours = Array.from({ length: 13 }, (_, i) => i + 6); // Generate hours from 6 to 18 (7 pm)
      this.mergedTimeSlots = hours.map((hour) => {
        const time = `${hour}:00 ${hour < 12 ? "AM" : "PM"}`; // Format time as "X:00 AM/PM"
        const slot = { time };
        // Initialize data for each day to an empty string
        this.days.forEach((day) => {
          slot[day.toLowerCase()] = "";
        });
        return slot;
      });
    },

    // Method to get event name for a specific time and day
    getEventName(time, day) {
      const event = this.schedule.find(
        (event) =>
          event.time === time && event.day.toLowerCase() === day.toLowerCase()
      );
      return event ? event.subjectName : "";
    },
  },
  mounted() {
    this.updateSchedule();
    this.generateTimeSlots();
    // Fetch initial schedule data and generate time slots when the component is mounted
  },
};
