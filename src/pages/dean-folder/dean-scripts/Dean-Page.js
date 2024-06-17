import { defineComponent, ref, onMounted } from "vue";
import { Notify, Dialog } from "quasar";
import { useQuasar } from "quasar";
import { useRouter, useRoute } from "vue-router";
import auth from "src/Auth/auth";

export default defineComponent({
  data() {
    return {
      logoutDialog: false,
      email: auth.email, // You may set this value after successful login
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
  methods: {
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
