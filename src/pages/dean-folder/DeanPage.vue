<template>
  <q-layout view="hHh Lpr lff" container style="height: 100vh">
    <q-header flat class="text-grey-9 header-style">
      <q-toolbar class="flex">
        <q-btn class="q-mt-sm menu-button" flat @click="drawer = !drawer" round dense icon="menu" />
        <q-toolbar-title class="text-h6 q-pt-sm logo-style">Forbes College</q-toolbar-title>
        <div class="notification q-pr-xl">
          <q-btn dense round flat icon="notifications" class="q-mt-sm">
            <q-badge color="red" floating transparent>
              <!-- No. of Notification -->
              1
            </q-badge>
          </q-btn>
        </div>
        <div class="account_name flex flex-center justify-end q-mr-md"></div>
        <div class="account q-pt-sm">
          <q-avatar size="40px" v-if="userData && userData.avatar">
            <img :src="userData.avatar" alt="Avatar">
          </q-avatar>
          <q-avatar size="40px" v-else>
            <img src="../../assets/user.png" alt="Avatar">
          </q-avatar>

          <q-btn-dropdown flat class="dropdown-btn">
            <div class="row no-wrap flex">
              <div class="column">
                <div class="text-h6 bg-amber-5 avatar-position">
                  <!-- Account content Here -->

                  <q-avatar class="q-pt-lg" size="80px" v-if="userData && userData.avatar">
                    <img :src="userData.avatar" alt="Avatar">
                  </q-avatar>

                </div>
                <div class="profile-info q-pa-sm">
                  <p class="User-Account text-center q-mt-sm">
                    <!-- email -->

                    <br />
                    <span>{{ email }}</span>
                    <br />

                    <span class="text-amber-6">
                      <!-- Position -->
                      {{ department }}</span>
                  </p>
                  <q-list>
                    <q-item clickable v-ripple to="/dean/dean-account" class="it-1">
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

    <q-drawer class="q-pt-lg" v-model="drawer" show-if-above :mini="!drawer || miniState" @click.capture="drawerClick"
      :width="230" :breakpoint="689" bordered :class="$q.dark.isActive" style="background-color: #182628;">
      <q-scroll-area class="fit" :horizontal-thumb-style="{ opacity: 0 }">
        <q-list padding>
          <q-item clickable v-ripple to="/dean/dean-page" style="color: #F2F2F2;">
            <q-item-section avatar>
              <q-icon name="dashboard" />
            </q-item-section>

            <q-item-section> Dashboard </q-item-section>
          </q-item>


          <q-item clickable v-ripple to="/dean/dean-subject" style="color: #F2F2F2;">
            <q-item-section avatar>
              <q-icon name="people" />
            </q-item-section>

            <q-item-section> Curriculum </q-item-section>
          </q-item>
          <q-item clickable v-ripple to="/dean/dean-schedule" style="color: #F2F2F2;">
            <q-item-section avatar>
              <q-icon name="schedule" />
            </q-item-section>

            <q-item-section> Schedule </q-item-section>
          </q-item>

          <q-item clickable v-ripple to="" style="color: #F2F2F2;">
            <q-item-section avatar>
              <q-icon name="history" />
            </q-item-section>

            <q-item-section> History Logs</q-item-section>
          </q-item>



        </q-list>
      </q-scroll-area>
      <div class="q-mini-drawer-hide absolute" style="top: 15px; right: -17px">
        <q-btn class="back-button" dense round unelevated icon="chevron_left" @click="miniState = true" />
      </div>
    </q-drawer>
    <q-page-container>
      <router-view></router-view>
    </q-page-container>
  </q-layout>
</template>

<script src="src/pages/admin-folder/admin-scripts/AdminPage.js"></script>

<style lang="scss" scoped>
@import "pages/admin-folder/admin-style/Admin-Page.scss";
</style>
