import auth from "src/Auth/auth";

import axios from "axios";

export default {
  data() {
    return {
      userData: null,
      editedUserData: {},
      isEditing: false,
      email: auth.email,
      originalEmail: null, // You may set this value after successful
      avatarPreview: null, // Para sa preview ng bagong avatar
      selectedFile: null,
      showUploadButton: false,
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
    handleAvatarUpload(event) {
      const file = event.target.files[0];
      this.selectedFile = file; // Itala ang piniling file

      // Update the avatar preview immediately
      this.avatarPreview = URL.createObjectURL(file);

      // Update the userData.avatar immediately
      this.userData.avatar = this.avatarPreview;

      // Ipakita agad ang "Upload Image" button
      this.showUploadButton = true;
    },

    uploadAvatar() {
      // Siguruhing may piniling file ang user bago iproseso ang upload
      if (this.selectedFile) {
        const formData = new FormData();
        formData.append("avatar", this.selectedFile);
        formData.append("email", this.email);

        axios
          .post(
            "https://forbesscheduling.000webhostapp.com/server/save_avatar.php",
            formData,
            {
              headers: {
                "Content-Type": "multipart/form-data",
              },
            }
          )
          .then((response) => {
            console.log(response.data);
            // Update the userData to display the new avatar
            this.userData.avatar = response.data.avatar;

            // Refresh userData to display the new information
            this.fetchData();
          })
          .catch((error) => {
            console.error("Error uploading avatar:", error);
          });
      }
    },
    saveAvatarToBackend(file) {
      const formData = new FormData();
      formData.append("avatar", file);

      // Send the image file to the backend for saving
      axios
        .post(
          "https://forbesscheduling.000webhostapp.com/server/save_avatar.php",
          formData
        )
        .then((response) => {
          // Handle success if needed
        })
        .catch((error) => {
          // Handle error if needed
        });
    },

    editUser() {
      this.originalEmail = this.userData.email;
      // Copy the original user data to the editedUserData object
      this.editedUserData = {
        ...this.userData,
        email: this.originalEmail,
      };
      this.isEditing = true;

      // Disable editing for the 'Position' field
      this.disablePositionEditing = true; // Add this line
    },
    cancelEdit() {
      // Reset the editedUserData to the original userData
      this.editedUserData = { ...this.userData };
      this.isEditing = false;

      this.$q.notify({
        color: "warning",
        type: "warning",
        message: "Changes cancelled!",
      });
    },

    saveChanges() {
      // Adjust payload structure to include both email and updatedData
      const payload = {
        originalEmail: this.email,
        updatedData: this.editedUserData,
      };

      console.log("Payload:", payload);

      axios
        .put(
          "https://forbesscheduling.000webhostapp.com/server/updateUserData.php",
          payload
        )
        .then((response) => {
          console.log(response.data);
          // Update the userData with the editedUserData
          this.userData = { ...this.editedUserData };
          this.isEditing = false;
          this.$q.notify({
            color: "positive",
            icon: "check",
            message: "Changes saved successfully!",
          });
        })
        .catch((error) => {
          console.error("Error updating data:", error);
          this.$q.notify({
            color: "negative",
            icon: "warning",
            message: "Error saving changes. Please try again.",
          });

          // Add additional error handling if needed
          // For example, you can display an error message to the user
        });
    },

    handleLogout() {
      // Handle the logout event

      auth.logout();
      window.location.reload();

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
          this.userData = response.data;
        })
        .catch((error) => {
          console.error("Error fetching data:", error);
        });
    },
  },
};
