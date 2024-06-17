<template>
  <q-layout view="hHh Lpr lff" container class="layout-size">
    <q-header flat class="text-grey-9 header-style">
      <q-toolbar class="flex">
        <q-btn class="q-mt-sm drawer-color" flat @click="drawer = !drawer" round dense icon="menu" />
        <q-toolbar-title class="text-h6 q-pt-sm">Forbes College</q-toolbar-title>

        <div class="notification q-pr-xl">
          <q-btn dense round flat icon="notifications" class="q-mt-sm notification-color">
            <q-badge color="red" floating transparent>
              <!-- No. of Notification -->
              1
            </q-badge>
          </q-btn>
        </div>
        <div class="account_name flex flex-center justify-end q-mr-md"></div>
        <div class="account q-pt-sm">
          <q-avatar>
            <img src="src/assets/user.png" />
          </q-avatar>
          <q-btn-dropdown flat class="dropdown-btn">
            <div class="row no-wrap flex">
              <div class="column">
                <div class="avatar-space text-h6 q-mb-md bg-amber-5">
                  <!-- Account content Here -->

                  <q-avatar class="flex q-pt-lg avatar-size">
                    <img src="src/assets/user.png" />
                  </q-avatar>
                </div>
                <div class="profile-info q-pa-sm">
                  <p class="User-Account text-center q-mt-sm" style="font-size: small; font-weight: 600">
                    <!-- email -->

                    <br />
                    <span>{{ email }}</span>
                    <br />


                  </p>
                  <q-list>
                    <q-item clickable v-ripple to="" class="it-1">
                      <div class="item q-pa-xs">
                        <q-icon name="settings"></q-icon>
                      </div>
                      <div class="item q-pa-xs" style="width: 200px">
                        Account Settings
                      </div>
                    </q-item>

                    <q-item clickable v-ripple class="text-red" @click="showLogoutConfirmation">
                      <div class="item q-pa-xs">
                        <q-icon name="logout"></q-icon>
                      </div>
                      <div class="item q-pa-xs" style="width: 200px">
                        Logout
                      </div>

                      <!-- Logout confirmation dialog -->
                      <q-dialog v-model="logoutDialog" persistent>
                        <q-card style="width: 300px;">
                          <q-card-section class="q-pt-md">
                            <q-card-title class="text-h6">
                              Confirm Logout
                            </q-card-title>
                          </q-card-section>

                          <q-card-section class="text-center">
                            Are you sure you want to logout?
                          </q-card-section>

                          <q-card-actions align="right">
                            <q-btn label="Cancel" color="green" @click="cancelLogout" />
                            <q-btn label="Logout" color="negative" @click="handleLogout" />
                          </q-card-actions>
                        </q-card>
                      </q-dialog>
                    </q-item>

                  </q-list>
                </div>
              </div>
            </div>
          </q-btn-dropdown>
        </div>
      </q-toolbar>
    </q-header>
    <q-drawer v-model="drawer" show-if-above :mini="!drawer || miniState" @click.capture="drawerClick" :width="230"
      :breakpoint="787" bordered :class="$q.dark.isActive" style="background-color: #182628;">
      <q-scroll-area class="fit" :horizontal-thumb-style="{ opacity: 0 }">
        <q-list padding>
          <q-item clickable v-ripple to="/tvl-dashboard/TVL-subject" style="color: #F2F2F2;">
            <q-item-section avatar>
              <q-icon name="book" />
            </q-item-section>

            <q-item-section> Subjects </q-item-section>
          </q-item>

          <q-item clickable v-ripple to="" style="color: #F2F2F2;">
            <q-item-section avatar>
              <q-icon name="people" />
            </q-item-section>

            <q-item-section> Accounts </q-item-section>
          </q-item>
          <q-item clickable v-ripple to="" style="color: #F2F2F2;">
            <q-item-section avatar>
              <q-icon name="history" />
            </q-item-section>

            <q-item-section> History Logs</q-item-section>
          </q-item>
          <q-expansion-item expand-separator icon="list_alt" label=" Clients Records" style="color: #F2F2F2;">
            <q-item clickable v-ripple to="/SecretaryDashboard/Marriage">
              <q-item-section avatar> </q-item-section>

              <q-item-section class="text-grey-8"> Marriage </q-item-section>
            </q-item>
            <q-item clickable v-ripple to="/SecretaryDashboard/Baptism">
              <q-item-section avatar> </q-item-section>

              <q-item-section class="text-grey-8"> Baptism </q-item-section>
            </q-item>
            <q-item clickable v-ripple to="/SecretaryDashboard/Records">
              <q-item-section avatar> </q-item-section>

              <q-item-section class="text-grey-8"> Confirmation</q-item-section>
            </q-item>
            <q-item clickable v-ripple to="/SecretaryDashboard/Records">
              <q-item-section avatar> </q-item-section>

              <q-item-section class="text-grey-8"> Burial </q-item-section>
            </q-item>
          </q-expansion-item>


        </q-list>
      </q-scroll-area>
      <div class="q-mini-drawer-hide absolute drawer-space" style="top: 15px; right: -17px">
        <q-btn class="back-button" dense round unelevated icon="chevron_left" @click="miniState = true" />
      </div>
    </q-drawer>
    <q-page-container>
      <router-view></router-view>
    </q-page-container>
  </q-layout>
</template>



<script src="pages/instructor-folder/instructor-scripts/InstructorPage"></script>

<style lang="scss" scoped>
@import "pages/instructor-folder/instructor-style/InstructorPage.scss";
</style>



