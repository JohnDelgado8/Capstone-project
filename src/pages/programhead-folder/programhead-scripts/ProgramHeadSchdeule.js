import {
  QCalendarResource,
  today,
} from "@quasar/quasar-ui-qcalendar/src/QCalendarResource.js";
import "@quasar/quasar-ui-qcalendar/src/QCalendarVariables.sass";
import "@quasar/quasar-ui-qcalendar/src/QCalendarTransitions.sass";
import "@quasar/quasar-ui-qcalendar/src/QCalendarResource.sass";
import { defineComponent, ref, onMounted, getCurrentInstance } from "vue";
import axios from "axios";
import auth from "src/Auth/auth"; // Siguraduhing tama ang path nito
import html2canvas from "html2canvas";
export default defineComponent({
  name: "ResourceSlotResourceIntervals",
  components: {
    QCalendarResource,
  },
  data() {
    return {
      imageData: null,
      newData: null,
      email: auth.email,
      availabilityDays: [],
      selectedAvailabilityDay: "",
      showDialog: false,
      showEventDialog: false,
      isEditing: false,
      selectedEvent: null,
      modelSingle: { id: "", name: "" },
      showBlockDialog: false,
      newBlockName: "",
      block: [],
      formData: {
        instructor: "",
        block: "",
        year: "",
        subjectname: "",
        type: "",
        room: "",
        day: "",
        time_from: "",
        time_to: "",
        school_year: "",
        semester: "",
        course: "",
        building: "",
        units: "",
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
      resourceWidth: 60,
      resourceHeight: 180,
      cellWidth: 220,
      block_model: ref(),
      selectYear: [],
      disableTimeTo: false,
      selectType: [],
      showRoomBadge: true,
      showAvailabilityBadge: true,
      availableSubjects: [],
      selectedSchoolYear: "", // Variable to hold selected school year
      schoolYearOptions: [],
      schoolYearDialog: false,
      semesterModel: "",
      semesterOptions: ["1st", "2nd"],
      formSubmitted: false,
      selectedCourse: "", // Holds the selected course
      courseOptions: [],
      courseModel: "",
      buildingModel: "",
      buildingOptions: ["King's Building", "Main Building"],
      selectedBlocks: "",
      filteredBlock: [],
      selectedYearLevel: "",
    };
  },
  computed: {
    selectedCourseLabel() {
      return this.courseModel ? this.courseModel.label : ""; // Kung may napiling kurso, ipapakita ang label; kung wala, ipapakita ang empty string
    },
    isFormInvalid() {
      return Object.values(this.formData).some((value) => !value);
    },
    filteredEvents() {
      // Check if all required filters are selected

      if (
        !this.selectedSchoolYear ||
        !this.courseModel ||
        !this.semesterModel ||
        !this.selectedBlocks
      ) {
        return {}; // Return an empty object if any required filter is not selected
      }
      // Filter events based on selected filters
      return Object.keys(this.events).reduce((filtered, resourceId) => {
        filtered[resourceId] = this.events[resourceId].filter(
          (event) =>
            event.school_year === this.selectedSchoolYear.value &&
            event.semester === this.semesterModel &&
            event.course === this.courseModel.label &&
            event.block === this.selectedBlocks.label
        );
        console.log("Value of selectedYearLevel:", this.selectedYearLevel);
        return filtered;
      }, {});
    },
    formDataYear: {
      get() {
        return this.formData.year;
      },
      set(newValue) {
        this.formData.year = newValue;
      },
    },
  },
  mounted() {
    this.fetchEventsFromBackend();
    this.fetchInstructors();
    this.getAvailabilityDays();
    this.fetchYearsAndSubjects();
    this.fetchRooms();
    this.fetchSavedDays();
    this.fetchBlocks();
    this.fetchCourses();
  },
  watch: {
    "formData.instructor": {
      handler: "getAvailabilityDays",
      immediate: true,
    },
    "formData.subjectname": {
      handler: "fetchUnitsForSubject",
      immediate: true,
    },

    "formData.type": "fetchRooms",

    courseModel(newVal) {
      if (newVal) {
        // Update formData.course with the selected course's label
        this.formData.course = newVal.label;
        this.fetchEventsFromBackend();
      } else {
        // Clear formData.course if no course is selected
        this.formData.course = "";
      }
    },
    selectedSchoolYear(newVal) {
      if (newVal) {
        this.formData.school_year = newVal.value;
        this.fetchEventsFromBackend();
      } else {
        console.error("Invalid value:", newVal);
      }
    },
    selectedBlocks(newVal) {
      if (newVal) {
        this.formData.block = newVal.label;
        this.fetchEventsFromBackend();
      } else {
        this.formData.block = null; // Set to null if no block selected
        this.fetchEventsFromBackend(); // Fetch events even if no block selected
      }
    },

    semesterModel(newVal) {
      this.formData.semester = newVal;
      this.fetchEventsFromBackend();
    },

    selectedYearLevel(newVal) {
      if (newVal) {
        this.formData.year = newVal;
        this.fetchEventsFromBackend();
        this.fetchYearsAndSubjects(); // Unahin ang pagkuha ng subjects
      } else {
        this.formData.year = "";
      }
    },

    buildingModel(newVal) {
      this.formData.building = newVal;
      this.fetchRooms();
    },
  },
  setup() {
    const fetchSchoolYears = () => {
      const instance = getCurrentInstance();
      if (instance) {
        axios
          .get(
            `https://forbesscheduling.000webhostapp.com/server/get_schoolyear.php?email=${auth.email}`
          )
          .then((response) => {
            console.log("Response:", response.data); // Log the response
            // Check if the response contains an array of school years
            if (Array.isArray(response.data)) {
              // Extract school years from the response data
              const schoolYears = response.data.map((item) => ({
                label: item,
                value: item,
              }));

              // Set schoolYearOptions to the extracted school years
              instance.proxy.schoolYearOptions = schoolYears;
            } else {
              console.error(
                "Invalid response format: Expected an array of school years"
              );
            }
          })
          .catch((error) => {
            console.error("Error fetching school years data:", error);
          });
      } else {
        console.error(
          "Unable to fetch school years: No component instance found."
        );
      }
    };

    // Fetch school years data from server when component is mounted
    onMounted(fetchSchoolYears);
  },
  methods: {
    async fetchCourses() {
      try {
        // Retrieve the user's email from the auth module
        const userEmail = auth.email;

        // Make a GET request to fetch courses from the database
        const response = await axios.get(
          `https://forbesscheduling.000webhostapp.com/server/get-courses.php?email=${userEmail}`
        );

        // Check if the response contains data
        if (response.data && Array.isArray(response.data)) {
          // Map the response data to options format required by q-select component
          this.courseOptions = response.data.map((course) => ({
            label: course.course_name,
            value: course.courses_id,
          }));
        } else {
          console.error("Invalid response format: Unable to fetch courses");
        }
      } catch (error) {
        console.error("Error fetching courses:", error);
      }
    },
    async deleteBlock() {
      try {
        // Check if there is a selected block
        if (!this.formData.block || !this.formData.block.id) {
          console.error("No block selected to delete.");
          return;
        }

        console.log("Selected Block:", this.formData.block);
        console.log("Block ID:", this.formData.block.id);

        // Make an HTTP DELETE request to delete the selected block
        const url = `https://forbesscheduling.000webhostapp.com/server/delete_blocks.php`;
        const requestData = { id: this.formData.block.id }; // Data to send in the request body

        const response = await axios.delete(url, { data: requestData });

        // Check if the deletion was successful
        if (response.data.success) {
          // Reset formData.block to null
          this.formData.block = null;

          // Optionally, display a success message
          this.$q.notify({
            type: "positive",
            message: "Block dissolved successfully.",
          });
        } else {
          // Handle deletion failure
          console.error("Failed to dissolve the block:", response.data.message);
          this.$q.notify({
            type: "negative",
            message: "Failed to dissolve the block.",
          });
        }
      } catch (error) {
        // Handle any errors that occur during the deletion process
        console.error("Error dissolving block:", error);
        this.$q.notify({
          type: "negative",
          message: "An error occurred while dissolving the block.",
        });
      }
    },
    async addSchoolYear() {
      try {
        // Check if the user is logged in
        if (!auth.isLoggedIn) {
          console.error("User is not logged in");
          return;
        }

        // Make a request to add the school year using the user's email
        const response = await axios.post(
          "https://forbesscheduling.000webhostapp.com/server/add_schoolyear.php",
          {
            email: auth.email, // Pass the user's email
            schoolYear: this.newSchoolYear, // Assuming you have a variable for the school year
          }
        );

        console.log(response.data);

        if (response.data.success) {
          console.log("School year added successfully");
          this.schoolYearDialog = false;
          this.newSchoolYear = ""; // Clear the newSchoolYear variable
          this.$q.notify({
            type: "positive",
            message: "New School Year Added!",
          });
        } else {
          console.error("Error adding school year:", response.data.message);
        }
      } catch (error) {
        console.error("Error saving school year", error);
      }
    },

    openEventDialog(event) {
      this.selectedEvent = event;
      this.showEventDialog = true;
    },

    closeEventDialog() {
      this.showEventDialog = false;
    },

    enableEditing() {
      this.selectedEvent = { ...this.selectedEvent };
      this.isEditing = true;
    },
    async addNewBlock() {
      try {
        if (!auth.isLoggedIn) {
          console.error("User is not logged in");
          return;
        }
        const response = await axios.post(
          "https://forbesscheduling.000webhostapp.com/server/add_block.php",
          { email: auth.email, name: this.newBlockName }
        );

        if (response.data.success) {
          this.showBlockDialog = false;
          this.newBlockName = "";

          // Refresh ng mga bloke pagkatapos ng pagsalin
          await this.fetchBlocks();
          this.$q.notify({
            type: "positive",
            message: "New Block Added!",
          });
        } else {
          console.error("Error adding new block:", response.data.error);
        }
      } catch (error) {
        console.error("Error adding new block:", error);
      }
    },

    async fetchBlocks() {
      try {
        const userEmail = auth.email;
        const response = await axios.get(
          `https://forbesscheduling.000webhostapp.com/server/get_block.php?email=${userEmail}`
        );

        console.log("Response from server:", response.data); // Log the response data

        // Check if the response data is an array
        if (Array.isArray(response.data)) {
          // Map the response data to objects with label and value properties
          const blocks = response.data.map((block) => ({
            label: block,
            value: block,
          }));

          // Set the filteredBlock to the mapped blocks
          this.filteredBlock = blocks;
        } else {
          console.error("Invalid response format: Expected an array");
        }
      } catch (error) {
        console.error("Error fetching blocks:", error);
      }
    },

    async saveEvent() {
      try {
        this.selectedEvent.subjectname = this.formData.subjectname;
        const response = await axios.put(
          `https://forbesscheduling.000webhostapp.com/server/update_schedule.php?id=${this.selectedEvent.id}`,
          this.selectedEvent
        );

        if (response.data.success) {
          const index = this.events.findIndex(
            (event) => event.id === this.selectedEvent.id
          );
          if (index !== -1) {
            this.$set(this.events, index, this.selectedEvent);
          }

          this.showEventDialog = false;

          this.$q.notify({
            type: "positive",
            message: "Event details updated successfully",
          });
        } else {
          this.$q.notify({
            type: "negative",
            message: "Failed to update event details",
          });
        }
      } catch (error) {
        this.showEventDialog = false;
        this.$q.notify({
          type: "positive",
          message: "Tama",
        });
      }
    },
    removeBadge(resourceId, date) {
      // Implementation of removeBadge function
    },

    async deleteEvent() {
      try {
        if (!this.selectedEvent || !this.selectedEvent.id) {
          console.error(
            "Error deleting event: Selected event or its day is undefined"
          );
          this.$q.notify({
            type: "negative",
            message:
              "Error deleting event: Selected event or its day is undefined",
          });
          return;
        }
        const eventId = this.selectedEvent.id;
        const response = await axios.delete(
          `https://forbesscheduling.000webhostapp.com/server/delete_schedule.php?id=${eventId}`
        );

        if (response.data.success) {
          const resourceId = this.getResourceId(this.selectedEvent.day);
          if (
            resourceId !== undefined &&
            Array.isArray(this.events[resourceId])
          ) {
            const index = this.events[resourceId].findIndex(
              (event) => event.id === this.selectedEvent.id
            );
            if (index !== -1) {
              this.$delete(this.events[resourceId], index);
            }

            // Extracting the date from the selectedEvent
            const date = this.selectedEvent.start;

            // Remove the corresponding badge from the UI
            this.$refs.calendar.removeBadge(resourceId, date);
          } else {
            this.$q.notify({
              type: "negative",
              message:
                "Failed to delete event: Resource ID or events array is undefined",
            });
          }
        }

        // Refresh the calendar after successfully deleting the event
        this.$refs.calendar.getScheduler().refresh();

        this.showEventDialog = false;
      } catch (error) {
        console.error("Error deleting event:", error);
        this.$q.notify({
          type: "positive",
          message: "Event deleted successfully",
        });
        this.showEventDialog = false;
      }
    },
    onChangeBlock() {
      this.$refs.calendar.getScheduler().refresh();
    },

    selectItem(item) {
      this.selectedItem = item;
      const block = this.block.find((block) => block.name === item);
      if (block) {
        this.modelSingle = block;
        this.formData.block = block; // Update formData.block with the selected block's name
      } else {
        console.error("Block not found:", item);
      }
    },
    async fetchUnitsForSubject() {
      if (this.formData.subjectname && this.formData.subjectname.value) {
        console.log("Subject name:", this.formData.subjectname.value); // Console log for selected subject name value
        axios
          .get(
            `https://forbesscheduling.000webhostapp.com/server/get_subject_units.php?subject=${this.formData.subjectname.value}`
          )
          .then((response) => {
            // Check if units data is found for the specified subject
            if (response.data.units) {
              this.formData.units = response.data.units; // Set the units value to the retrieved units from the response
            } else {
              console.error("No units data found for the specified subject");
            }
          })
          .catch((error) => {
            console.error("Error fetching units data:", error);
          });
      } else {
        this.formData.units = ""; // Reset units if no subject selected
      }
    },

    async fetchYearsAndSubjects() {
      try {
        // Retrieve user's department from the server
        const response = await axios.get(
          "https://forbesscheduling.000webhostapp.com/server/get_user_department.php",
          {
            params: {
              email: auth.email, // Assuming auth.email contains the user's email address
            },
          }
        );
        const userData = response.data;
        const userDepartment = userData.department;

        // Fetch curriculum data based on user's department
        const responseCurriculum = await axios.get(
          "https://forbesscheduling.000webhostapp.com/server/get_curriculum.php",
          {
            params: {
              department: userDepartment,
            },
          }
        );
        const curriculumData = responseCurriculum.data;

        // Extract unique years from the curriculum data and ensure it always starts from year 1
        const uniqueYears = Array.from(
          new Set(curriculumData.map((item) => parseInt(item.Year)))
        ).sort(); // Sort the years in ascending order

        // Set the selectYear options to the extracted unique years starting from year 1
        this.selectYear = Array.from(
          { length: uniqueYears.length },
          (_, i) => i + 1
        );

        // Filter curriculum data based on the selected year
        const filteredSubjectsByYear = curriculumData.filter(
          (item) => parseInt(item.Year) === this.selectedYearLevel
        );

        // Extract unique subjects from the filtered curriculum data
        const uniqueSubjects = Array.from(
          new Set(filteredSubjectsByYear.map((item) => item.Subject))
        );

        // Set the availableSubjects to the extracted unique subjects
        this.availableSubjects = uniqueSubjects;

        await this.fetchEventsFromBackend();
      } catch (error) {
        console.error("Error fetching years and subjects:", error);
      }
    },

    handleTimeFromChange() {
      const timeFrom = this.formData.time_from;
      if (timeFrom) {
        const [hour, minute] = timeFrom.split(":").map(Number);
        const selectedTime = hour * 60 + minute;
        this.disableTimeTo = hour >= 8 && hour < 20;
      }
    },

    async getAvailabilityDays() {
      try {
        // Retrieve the user's email from the auth module
        const userEmail = auth.email;

        // Make a GET request to fetch instructor availability from the database
        const response = await axios.get(
          `https://forbesscheduling.000webhostapp.com/server/getAvailabilityFullnames.php?email=${userEmail}`
        );

        // Fetch saved days for the user
        const savedDays = await this.fetchSavedDays();

        // Extract selected instructor and day
        const selectedInstructor = this.formData.instructor.value;
        const selectedDay = this.formData.day;

        // Initialize array to hold available days
        let availableDays = [];

        // Find data for the selected instructor
        const instructorData = response.data.find(
          (instructor) => instructor.fullname === selectedInstructor
        );

        if (instructorData && instructorData.availability_days) {
          // Extract available days for the selected instructor
          const instructorAvailableDays =
            instructorData.availability_days.flatMap((day) => {
              const [dayOfWeek, timeRange] = day.split(":");
              return {
                label: dayOfWeek,
                value: dayOfWeek,
                timeRange,
                instructor: selectedInstructor,
              };
            });

          // Filter out saved days from available days
          availableDays = instructorAvailableDays.filter((day) => {
            // Check if this day is not saved by the instructor
            return !savedDays.some(
              (savedDay) =>
                savedDay.day === day.value &&
                savedDay.instructor === day.instructor &&
                this.timeRangeOverlap(
                  savedDay.time_from,
                  savedDay.time_to,
                  day.timeRange
                )
            );
          });

          // Filter out the selected day, if selected
          if (selectedDay) {
            availableDays = availableDays.filter(
              (day) =>
                !(
                  day.value === selectedDay &&
                  day.instructor === selectedInstructor
                )
            );
          }

          this.availabilityDays = availableDays;

          // Update form data if a day is selected
          if (selectedDay) {
            const selectedDayData = availableDays.find(
              (day) => day.value === selectedDay
            );
            if (selectedDayData) {
              const [timeFrom, timeTo] = selectedDayData.timeRange.split("-");
              this.formData.time_from = timeFrom;
              this.formData.time_to = timeTo;
            }
          }
        } else {
          this.availabilityDays = [];
        }
      } catch (error) {
        console.error("Error fetching availability days:", error);
      }
    },
    // Function to check if two time ranges overlap
    timeRangeOverlap(startTime1, endTime1, timeRange2) {
      const [startTime2, endTime2] = timeRange2.split("-");
      return (
        (startTime1 <= startTime2 && startTime2 < endTime1) ||
        (startTime1 < endTime2 && endTime2 <= endTime1) ||
        (startTime2 <= startTime1 && endTime2 >= endTime1)
      );
    },

    async fetchSavedDays() {
      try {
        const response = await axios.get(
          "https://forbesscheduling.000webhostapp.com/server/get_saved_days.php"
        );

        const savedDays = Array.isArray(response.data) ? response.data : [];

        return savedDays;
      } catch (error) {
        console.error("Error fetching saved days:", error);
        return [];
      }
    },

    async saveSelectedDays(selectedDays) {
      try {
        const response = await axios.post(
          "https://forbesscheduling.000webhostapp.com/server/get_saved_days.php",
          { selectedDays }
        );
        console.log("Selected days saved successfully:", response.data);
      } catch (error) {
        console.error("Error saving selected days:", error);
      }
    },
    async fetchInstructors() {
      try {
        // Retrieve the user's email from the auth module
        const userEmail = auth.email;

        // Make a GET request to fetch instructors from the database
        const response = await axios.get(
          `https://forbesscheduling.000webhostapp.com/server/getAvailabilityFullnames.php?email=${userEmail}`
        );

        // Check if response data is valid
        if (Array.isArray(response.data)) {
          // Map the response data to options format
          this.instructors = response.data.map((item) => ({
            label: item.fullname,
            value: item.fullname,
          }));
          console.log(response.data);
        } else {
          console.error(
            "Invalid response format for instructors data:",
            response.data
          );
        }
      } catch (error) {
        console.error("Error fetching instructors:", error);
      }
    },

    async fetchEventsFromBackend() {
      try {
        const response = await axios.get(
          `https://forbesscheduling.000webhostapp.com/server/get_schedule.php`
        );
        if (Array.isArray(response.data)) {
          // Filter events based on selected school year, semester, course, and year
          const filteredEvents = response.data.filter(
            (event) =>
              event.school_year === this.selectedSchoolYear.value &&
              event.semester === this.semesterModel &&
              event.course === this.courseModel.label &&
              event.block === this.selectedBlocks.label
          );

          console.log("Filtered Events", filteredEvents);
          this.clearEvents(); // Clear existing events
          this.processEvents(filteredEvents);
        } else {
          console.error("Error fetching events: Response data is not an array");
        }
      } catch (error) {
        console.error("Error fetching events:", error);
      }
    },
    clearEvents() {
      // Clear existing events
      this.events = {};
      this.eventWidths = {};
    },
    async fetchRooms() {
      try {
        const availableRoomsResponse = await axios.get(
          "https://forbesscheduling.000webhostapp.com/server/get_room.php"
        );

        const savedRoomsResponse = await axios.get(
          "https://forbesscheduling.000webhostapp.com/server/get_saved_rooms.php"
        );

        const savedRooms = savedRoomsResponse.data.map(
          (room) => room.room_number
        );

        // Filter rooms based on selected building
        const selectedBuildingRooms = availableRoomsResponse.data.filter(
          (room) => room.building === this.buildingModel
        );

        this.selectRoom = selectedBuildingRooms
          .filter((room) => !savedRooms.includes(room.room_number))
          .map((room) => room.room_number);

        this.selectType = [
          ...new Set(selectedBuildingRooms.map((item) => item.type)),
        ];

        if (
          this.formData.type === "Lecture" ||
          this.formData.type === "Laboratory"
        ) {
          this.selectRoom = this.selectRoom.filter((roomNumber) => {
            const room = selectedBuildingRooms.find(
              (room) => room.room_number === roomNumber
            );
            return room.type === this.formData.type;
          });
        }

        this.selectRoom = this.selectRoom.filter(
          (roomNumber) => !savedRooms.includes(roomNumber)
        );
      } catch (error) {
        console.error("Error fetching rooms:", error);
      }
    },

    selectRoomFromBadge() {
      if (this.selectRoom.length > 0) {
        this.formData.room = this.selectRoom[0];
        this.selectRoom.splice(0, 1);
        this.showRoomBadge = false;
      }
    },

    selectAvailabilityDayFromBadge() {
      if (this.availabilityDays.length > 0) {
        this.formData.day = this.availabilityDays[0].value;
        const selectedDayData = this.availabilityDays[0];
        if (selectedDayData) {
          const [timeFrom, timeTo] = selectedDayData.timeRange.split("-");
          this.formData.time_from = timeFrom;
          this.formData.time_to = timeTo;
        }
        this.availabilityDays.splice(0, 1);
        this.showAvailabilityBadge = false;
      }
    },
    removeRoom(index) {
      this.selectRoom.splice(index, 1);
    },

    processEvents(data) {
      const eventWidths = {};
      const newEvents = {};

      // Add school year property to each event
      data.forEach((event) => {
        event.school_year = this.selectedSchoolYear.value;
        event.semester = this.semesterModel.label;
        !this.courseModel || event.course === this.courseModel.label;
        event.block = this.selectedBlocks;
      });

      data.forEach((event) => {
        const resourceId = this.getResourceId(event.day);
        const eventId = event.id;
        const eventKey =
          resourceId + "-" + event.time_from + "-" + event.time_to;

        // Check if the event already exists in the events object
        const existingEventIndex = (this.events[resourceId] || []).findIndex(
          (e) => e.id === eventId
        );

        if (existingEventIndex === -1) {
          const startTime = new Date(`2024-02-12T${event.time_from}`);
          const endTime = new Date(`2024-02-12T${event.time_to}`);
          const durationInMinutes = this.calculateDuration(startTime, endTime);

          const newEvent = {
            id: eventId,
            start: startTime,
            end: endTime,
            title: `${event.subjectname} - ${event.instructor} - ${event.room} - ${event.time_from} to ${event.time_to} `,
            duration: durationInMinutes,
            instructor: event.instructor,
            type: event.type,
            subjectName: event.subjectname,
            room: event.room,
            year: event.year,
            time_from: event.time_from,
            time_to: event.time_to,
            block: event.block,
            school_year: event.school_year, // Add school_year property
          };

          if (!Array.isArray(newEvents[resourceId])) {
            newEvents[resourceId] = [];
          }

          newEvents[resourceId].push(newEvent);

          if (!eventWidths[eventKey]) {
            eventWidths[eventKey] = durationInMinutes;
          } else {
            if (eventWidths[eventKey] < durationInMinutes) {
              eventWidths[eventKey] = durationInMinutes;
            }
          }
        }
      });

      this.events = { ...this.events, ...newEvents };
      this.eventWidths = { ...this.eventWidths, ...eventWidths };
    },

    getEvents(scope) {
      const resourceId = scope.resource.id;
      // I-filter ang mga event na nararapat na ipakita base sa resourceId
      const filteredEvents = this.events[resourceId] || [];
      return filteredEvents;
    },
    getResourceId(day) {
      if (!day) {
        console.error("Day parameter is undefined or null");
        return "1"; // Default to Monday or handle this case according to your logic
      }
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
          return "1";
      }
    },
    calculateDuration(startTime, endTime) {
      const durationInMilliseconds = endTime - startTime;
      const durationInMinutes = durationInMilliseconds / (1000 * 60);
      return durationInMinutes;
    },

    getStyle(event, index, scope) {
      const resourceId = scope.resource.id;

      const startHour = event.start.getHours();
      const startMinute = event.start.getMinutes();
      const totalStartMinutes = startHour * 60 + startMinute;
      const left = (totalStartMinutes - 6 * 60) * (1200 / (15 * 21.8));

      const durationInMinutes = event.duration;
      const width = durationInMinutes * (1200 / (15 * 21.8));

      const lineHeight = 15;
      const numLines = Math.ceil(event.title.length / 50);
      const height = numLines * lineHeight + 5;

      let top;
      if (index === 0) {
        top = (totalStartMinutes - 6 * 60) * (140 / (95 * 60));
      } else {
        const prevEvent = this.events[resourceId][index - 1];
        const prevStartHour = prevEvent.start.getHours();
        const prevStartMinute = prevEvent.start.getMinutes();
        const prevTotalStartMinutes = prevStartHour * 60 + prevStartMinute;
        const prevHeight = Math.ceil(prevEvent.title.length / 20) * lineHeight;
        top = prevTotalStartMinutes * (180 / (170 * 145)) + 26;
      }

      return {
        position: "absolute",
        background: "white",
        left: left + "px",
        top: top + "px",
        width: width + "px",
        height: height + "px",
        "text-wrap": "pretty",
      };
    },

    async submitForm() {
      try {
        const requiredFields = [
          "instructor",
          "subjectname",
          "type",
          "day",
          "room",
          "time_from",
          "time_to",
        ];
        const missingFields = requiredFields.filter(
          (field) => !this.formData[field]
        );

        if (missingFields.length > 0) {
          console.error("Missing required fields:", missingFields.join(", "));
          return;
        }

        const response = await axios.post(
          "https://forbesscheduling.000webhostapp.com/server/schedule.php",
          {
            email: auth.email,
            newEvent: this.formData,
          }
        );
        if (response.data.success) {
          await this.fetchEventsFromBackend();

          // Clear only specific fields
          this.formData.instructor = "";
          this.formData.subjectname = "";
          this.formData.type = "";
          this.formData.day = "";
          this.formData.room = "";
          this.formData.time_from = "";
          this.formData.time_to = "";
          this.formData.building = "";

          this.showDialog = false;

          // Notify user about new schedule added
          this.$q.notify({
            message: "New schedule added successfully!",
            color: "positive",
            position: "bottom",
            timeout: 2000, // Adjust timeout as needed
          });
        } else {
          console.error("Error adding event:", response.data.message);
        }
      } catch (error) {
        console.error("Error:", error);
      }
    },
  },
});
