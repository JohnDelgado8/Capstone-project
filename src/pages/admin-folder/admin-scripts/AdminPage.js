import { defineComponent, ref, onMounted } from "vue";
import { Notify, Dialog } from "quasar";
import { useQuasar } from "quasar";
import { useRouter, useRoute } from "vue-router";
import auth from "src/Auth/auth";
import axios from "axios";

export default defineComponent({
  data() {
    return {
      logoutDialog: false,
      userData: null,
      editedUserData: {},
      isEditing: false,
      email: auth.email,
      originalEmail: null,
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
      const formData = new FormData();
      formData.append("avatar", file);
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
          // Optionally update the userData to display the new avatar
          this.fetchData(); // Update user data after successful upload
        })
        .catch((error) => {
          console.error("Error uploading avatar:", error);
        });
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
    showLogoutConfirmation() {
      this.logoutDialog = true;
    },
    cancelLogout() {
      this.logoutDialog = false;
    },

    handleLogout() {
      // Handle the logout event

      auth.logout();
      window.location.reload();

      Notify.create({
        type: "positive",
        message: "Logout successfully!",
      });

      // Redirect back to the login page
      this.$router.push({ name: "login" });
    },
  },
  setup() {
    const $q = useQuasar();
    const miniState = ref(false);

    // let logout = () => {
    //   $q.dialog({
    //     title: "",
    //     message: "Are you sure you want to logout?",
    //     cancel: true,
    //     persistent: true,
    //   })
    //     .onOk(() => {
    //       console.log(">>>> OK");
    //     })
    //     .onOk(() => {
    //       // console.log('>>>> second OK catcher')
    //     })
    //     .onCancel(() => {
    //       // console.log('>>>> Cancel')
    //     })
    //     .onDismiss(() => {
    //       // console.log('I am triggered on both OK and Cancel')
    //     });
    // };

    return {
      // logout,
      // Positiondata,
      // Namedata,

      drawer: ref(true),
      miniState,

      drawerClick(e) {
        // if in "mini" state and user
        // click on drawer, we switch it to "normal" mode
        if (miniState.value) {
          miniState.value = false;

          // notice we have registered an event with capture flag;
          // we need to stop further propagation as this click is
          // intended for switching drawer to "normal" mode only
          e.stopPropagation();
        }
      },
    };
  },
});
