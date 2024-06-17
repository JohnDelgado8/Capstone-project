<template>
  <div>
    <q-header class="enrollment-header enrollment-bg-secondary">
      <div>
        <MobileHeader />

        <div class="tablet-desktop-view row justify-between q-px-lg q-py-md">
          <div class="col-8 col-md-5 flex items-center">
            <q-input
              class="full-width main-search"
              dense
              borderless
              placeholder="Search Filter..."
            >
              <template v-slot:prepend>
                <q-icon
                  class="q-pl-md enrollment-text-accent-0"
                  name="search"
                />
              </template>
            </q-input>
          </div>
          <div class="col-4 col-md-6">
            <div class="row items-center enrollment-text-accent-0 justify-end">
              <div class="tablet-materials col-auto q-pr-sm">
                <q-icon
                  class="enrollment-text-accent-1 text-hover-accent-1 bg-hover-accent-0"
                  name="iconfont icon-activity"
                  size="sm"
                />
              </div>

              <div
                class="avatar col-auto cursor-pointer relative-position flex justify-between items-center"
              >
                <div>
                  <q-avatar class="bg-hover-accent-0">
                    <q-img
                      v-if="GetLoggedInUser.photo"
                      :src="`data:image/png;base64, ${GetLoggedInUser.photo}`"
                    />
                    <!-- <q-img v-else :src="require(`src/core/assets/${!GetLoggedInUser.sex ? 'male' : 'female'}-avatar.svg`)" /> -->
                  </q-avatar>
                </div>

                <div class="desktop-materials">
                  <q-icon
                    class="q-px-md enrollment-text-primary"
                    size="md"
                    name="notifications"
                    @click="toggleNotification"
                  />
                  <div
                    v-if="showNotification"
                    class="notification-container absolute"
                    style="right: 100px"
                    @click.stop
                  >
                    <div
                      class="content bg-white q-px-xs q-py-sm shadow-text-12 text-accent-1 enrollment-border-radius-15 enrollment-border-accent-0 shadow-2"
                      style="width: 400px"
                    >
                      <q-icon
                        class="enrollment-text-accent-1 float-right q-ma-none q-pr-md"
                        name="close"
                        @click="closeNotification"
                      >
                      </q-icon>
                      <div
                        class="flex justify-between q-px-xs items-center enrollment-text-accent-1 q-py-sm q-px-md"
                        style="font-family: 'Source Sans Pro', sans-serif"
                      >
                        <div class="text-24 text-bolder">Notifications</div>
                        <div class="text-accent-1 text-18">See All</div>
                      </div>
                      <div class="text-8 q-pa-xs bg-hover-accent-4">
                        <div class="text-left">
                          <div class="flex q-px-md">
                            <q-icon class="text-6 q-pt-xs" name="circle" />
                            <div
                              class="enrollment-text-accent-1 text-14 q-px-xs text-bold"
                              style="width: 300px"
                            >
                              The Client is Approaching
                            </div>
                          </div>
                          <q-table
                            :rows="tableData"
                            :columns="tableColumns"
                            hide-bottom
                            hide-header
                            flat
                            dense
                            separator="none"
                            class="text-19 q-pl-md"
                          />
                          <div
                            class="text-16 q-pl-lg q-ml-sm enrollment-text-accent-1 q-mt-sm text-bold"
                          >
                            September 16,2023 at 9:49 AM
                          </div>
                        </div>
                      </div>
                      <div>
                        <q-separator
                          class="bg-accent-2 q-mx-lg q-pl-xs"
                          style="width: 325px"
                        />
                      </div>
                      <div class="text-right">
                        <div
                          class="enrollment-text-accent-1 text-14 text-semibold q-mx-md q-mt-md q-pr-lg"
                        >
                          Mark as read
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="desktop-materials">
                  <q-icon
                    class="q-pa-xs enrollment-text-primary"
                    size="md"
                    name="account_circle"
                    @click="toggleProfileDropdown"
                  />
                  <div
                    v-if="showProfileDropdown"
                    class="profile-container absolute"
                    @click.stop
                  >
                    <div
                      class="content bg-white q-py-md shadow-1 text-12 text-accent-1 enrollment-border-accent-0"
                      style="width: 140px"
                    >
                      <div
                        class="q-px-md q-py-xs bg-hover-accent-4 cursor-pointer enrollment-text-primary"
                      >
                        Account
                      </div>
                      <div
                        class="q-px-md q-py-xs bg-hover-accent-4 cursor-pointer enrollment-text-primary"
                      >
                        My Profile
                      </div>
                      <div
                        @click="confirm = true"
                        class="q-px-md q-py-xs bg-hover-accent-4 cursor-pointer enrollment-text-primary"
                      >
                        Logout
                      </div>

                      <q-dialog
                        class="enrollment-dialog-background"
                        v-model="confirm"
                        persistent
                      >
                        <div
                          class="enrollment-dialog-container text-center text-white no-shadow flex justify-center items-center"
                        >
                          <div class="width-300">
                            <q-icon
                              name="help"
                              size="50px"
                              top
                              class="q-mt-none q-mb-md enrollment-text-accent-0"
                            />
                            <h4
                              :class="`text-semibold text-24 q-my-none ${
                                $q.screen.width < 768 ? 'q-mb-sm' : 'q-mb-md'
                              }`"
                            >
                              Are you sure?
                            </h4>
                            <div class="text-16 q-mb-xl q-pb-xl">
                              You are about to log out from the system.
                            </div>

                            <!-- Close and Confirm Buttons -->
                            <div class="row q-pt-md q-gutter-lg justify-center">
                              <q-btn
                                flat
                                no-caps
                                label="No"
                                v-close-popup
                                dense
                                class="text-12 bg-accent-0 q-py-none q-px-lg q-mb-s enrollment-border-radius-50 enrollment-bg-primary enrollment-text-primary"
                              />
                              <q-btn
                                flat
                                no-caps
                                label="Yes"
                                @click="logout()"
                                dense
                                class="text-12 bg-accent-0 q-py-none q-px-lg q-mb-s enrollment-border-radius-50 enrollment-bg-accent-0"
                              />
                            </div>
                          </div>
                        </div>
                      </q-dialog>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </q-header>
  </div>
</template>
<style lang="scss"></style>

<script>
import { ref } from "vue";
// import { useStore } from "vuex";
import { useQuasar } from "quasar";
import { useRouter } from "vue-router";
import MobileHeader from "../../components/MobileHeader.vue";
// import {LogoutUser, GetLoggedInUser} from 'src/core/composables/Authenticate';
export default {
  components: {
    MobileHeader,
  },
  setup() {
    // const store = useStore();
    const $q = useQuasar();
    const router = useRouter();
    const showProfileDropdown = ref(false);
    const showNotification = ref(false);

    const tableData = ref([
      { title: "Client Name", content: "James Karl Borras" },
      { title: "Client Number", content: "B1-023" },
      { title: "Starting Date/Time", content: "05/02/2023, 02:00 PM" },
      { title: "Expected Arrival time", content: "1:50 PM" },
    ]);

    const tableColumns = ref([
      {
        name: "title",
        required: true,
        label: "title",
        align: "left",
        field: "title",
        sortable: true,
      },
      {
        name: "content",
        align: "left",
        label: "content",
        field: "content",
        sortable: true,
        classes: "bold-content",
      },
    ]);

    const toggleNotification = () => {
      showNotification.value = !showNotification.value;
    };
    const toggleProfileDropdown = () => {
      showProfileDropdown.value = !showProfileDropdown.value;
    };
    const closeNotification = () => {
      showNotification.value = false;
    };
    const GetLoggedInUser = ref({
      id: null,
      photo: null,
      sex: null,
    });

    const logout = () => {
      router.push("/login");
      // Show a success notification
      $q.notify({
        position: $q.screen.width < 767 ? "top" : "bottom-right",
        classes: "enrollment-success-notif q-px-lg q-pt-none q-pb-none",
        html: true,
        message:
          '<div class="text-bold">Logged Out Successfully!</div>You have been logged out.',
      });
    };
    return {
      logout,
      GetLoggedInUser,
      confirm: ref(false),
      router,
      toggleNotification,
      showNotification,
      toggleProfileDropdown,
      showProfileDropdown,
      closeNotification,
      tableColumns,
      tableData,
    };
  },
};
</script>

<style lang="scss">
@import "../styles/Header.scss";
</style>
