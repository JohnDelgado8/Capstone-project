import axios from "axios";
import { ref, reactive, onMounted, getCurrentInstance, watch } from "vue";
import auth from "src/Auth/auth";

export default {
  data() {
    return {
      showDialog: false,
      year: "",
      subject: "",
      courseCode: "",
      units: "",
      unitsOptions: ["1", "2", "3"],
      schoolYear: "",
      semester: "",
      semesterModel: null,
      semesterOptions: ["1st", "2nd"],
      yearOptions: ["1", "2", "3", "4"],
      selectedSchoolYear: "",
      schoolYearOptions: [],
      schoolYearDialog: false,
      newSchoolYear: "",
      selectedCourse: "", // Holds the selected course
      courseOptions: [],
    };
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
    // Initialize reactive curriculum data array
    const curriculums = ref([]);

    // Initialize grouped curriculum data
    const groupedCurriculums = reactive({});
    const instance = getCurrentInstance();

    // Fetch curriculum data from server
    const fetchCurriculumData = async () => {
      try {
        const response = await axios.get(
          `https://forbesscheduling.000webhostapp.com/server/curriculum.php?email=${auth.email}`
        );
        console.log("Curriculum API Response:", response.data);

        let curriculumData = [];
        if (Array.isArray(response.data)) {
          curriculumData = response.data.map((curriculum) => ({
            ...curriculum,
            checked: curriculum.checked === "1",
          }));
        } else if (typeof response.data === "object") {
          curriculumData = [response.data];
        } else {
          console.error("Unexpected response format:", response.data);
        }

        // Update the reactive variable
        curriculums.value = curriculumData;
        // Group curriculum data by year
        groupCurriculumsByYear();
      } catch (error) {
        console.error("Error fetching curriculum data:", error);
      }
    };
    // Group curriculum data by year
    const groupCurriculumsByYear = () => {
      for (const curriculum of curriculums.value) {
        if (!groupedCurriculums[curriculum.Year]) {
          groupedCurriculums[curriculum.Year] = [];
        }
        groupedCurriculums[curriculum.Year].push(curriculum);
      }
    };

    // Handle checkbox click event
    const handleCheckboxClick = (curriculum) => {
      // Disable the checkbox temporarily
      curriculum.pending = true;

      // Send checkbox data to the server
      saveCheckboxData(curriculum);
    };

    // Function to send checkbox data to the server
    const saveCheckboxData = (curriculum) => {
      // Determine the new state of the checkbox
      const newState = curriculum.checked ? 1 : 0;

      const checkboxData = {
        subject: curriculum.Subject,
        year: curriculum.Year,
        course_code: curriculum.course_code,
        units: curriculum.units,
        checked: newState, // Include checkbox state in the data sent to the server
      };

      axios
        .post(
          "https://forbesscheduling.000webhostapp.com/server/new_curriculum.php",
          checkboxData
        )
        .then((response) => {
          console.log(response.data);
          // Update the checked state based on server response
          if (response.data.success) {
            // No need to update the checked state here
          } else {
            // If the request fails, revert back to the previous state
            curriculum.checked = !curriculum.checked;
          }
        })
        .catch((error) => {
          console.error("Error saving checkbox data:", error);
          // If there's an error, revert back to the previous state
          curriculum.checked = !curriculum.checked;
        })
        .finally(() => {
          // Re-enable the checkbox after the request is completed
          curriculum.pending = false;
        });
    };

    // Fetch curriculum data from server when component is mounted
    onMounted(fetchCurriculumData);

    // Return values and functions for setup
    return {
      curriculums,
      groupedCurriculums,

      fetchCurriculumData,
    };
  },
  mounted() {
    // Fetch courses from the database when the component is mounted
    this.fetchCourses();
  },
  computed: {
    isValidForm() {
      return (
        this.year.trim() !== "" &&
        this.subject.trim() !== "" &&
        this.courseCode.trim() !== ""
      );
    },
    filteredCurriculums() {
      if (!this.semesterModel || !this.selectedSchoolYear.value) {
        return {};
      }

      if (this.selectedCourse) {
        // Filter curriculum data based on selectedCourse
        const filteredData = Object.fromEntries(
          Object.entries(this.groupedCurriculums).map(([year, curriculums]) => [
            year,
            curriculums.filter(
              (curriculum) =>
                curriculum.semester === this.semesterModel &&
                curriculum.school_year === this.selectedSchoolYear.value &&
                curriculum.course_name === this.selectedCourse.label // Check course_name
            ),
          ])
        );

        // Remove duplicates from the filtered data
        const uniqueFilteredData = {};
        for (const year in filteredData) {
          const uniqueCurriculums = Array.from(
            new Set(filteredData[year].map((curriculum) => curriculum.Subject))
          ).map((subject) =>
            filteredData[year].find(
              (curriculum) => curriculum.Subject === subject
            )
          );
          uniqueFilteredData[year] = uniqueCurriculums;
        }

        return uniqueFilteredData;
      } else {
        // If no course is selected, return all curriculum data
        return this.groupedCurriculums;
      }
    },
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
    async addSchoolYear() {
      try {
        const response = await axios.post(
          "https://forbesscheduling.000webhostapp.com/server/add_schoolyear.php",
          { name: this.newSchoolYear }
        );

        if (response.data.success) {
          this.schoolYearDialog = false;
          this.newSchoolYear = "";
        } else {
          console.error("Error adding new block:", response.data.error);
        }
      } catch (error) {
        console.error("Error adding new block:", error);
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
    // Sa loob ng addCurriculum method:
    async addCurriculum() {
      if (!this.isValidForm) return; // Exit if form is not valid

      // Check if selectedCourse is not null and has the label property
      if (this.selectedCourse && this.selectedCourse.label) {
        try {
          // Check if the curriculum already exists before adding
          const exists = this.curriculums.some((curriculum) => {
            return (
              curriculum.year === this.year &&
              curriculum.subject === this.subject &&
              curriculum.courseCode === this.courseCode &&
              curriculum.units === this.units &&
              curriculum.selectedSchoolYear === this.selectedSchoolYear.value &&
              curriculum.semesterModel === this.semesterModel &&
              curriculum.selectedCourse.label === this.selectedCourse.label
            );
          });

          if (exists) {
            console.log("Curriculum already exists!");
            return; // Exit if curriculum already exists
          }

          // If curriculum does not exist, proceed to add it
          const formData = new FormData();
          formData.append("year", this.year);
          formData.append("subject", this.subject);
          formData.append("courseCode", this.courseCode);
          formData.append("units", this.units);
          formData.append("selectedSchoolYear", this.selectedSchoolYear.value);
          formData.append("semesterModel", this.semesterModel);
          formData.append("selectedCourse", this.selectedCourse.label);
          formData.append("user_email", auth.email); // Replace 'user@example.com' with the actual user email

          const response = await fetch(
            "https://forbesscheduling.000webhostapp.com/server/add_curriculum.php",
            {
              method: "POST",
              body: formData,
            }
          );

          const data = await response.json();
          console.log(data); // Log response from server

          if (data.success) {
            // Clear form fields after adding curriculum
            this.year = "";
            this.subject = "";
            this.courseCode = "";
            this.units = "";

            // Close the dialog after adding curriculum
            this.showDialog = false;

            // Fetch curriculum data again to refresh the database
            await this.fetchCurriculumData(); // Wait for the data to be fetched

            // Alternatively, you can directly call groupCurriculumsByYear() here
            // to group the newly fetched curriculum data by year
          } else {
            // Handle server error response if needed
            console.error("Error adding curriculum:", data.error);
          }
        } catch (error) {
          console.error("Error:", error);
        }
      } else {
        console.error(
          "Selected course is null or does not have a label property"
        );
      }
    },

    cancelAddCurriculum() {
      // Reset form fields and close dialog
      this.year = "";
      this.subject = "";
      this.courseCode = "";
      this.units = "";
      this.showDialog = false;
    },
  },
};
