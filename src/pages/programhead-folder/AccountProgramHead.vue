<template>
  <q-page>
    <q-card class="main-card">
      <q-card-section>
        <div class="text-h5 q-ml-sm text-bold">My Account</div>
      </q-card-section>


      <!-- Desktop-->
      <div class="row">
        <div class="col" style="text-align: -webkit-center;">
          <div class="desktop-style" v-if="$q.screen.width >= 1084">
            <div class="q-ml-md q-pt-md desktop-caption">Personal Information</div>
            <!-- Display user data -->
            <div class="row q-mt-md">
              <div class="col-6  q-pl-xl q-mt-sm" style="text-align: center;">
                <!-- Display user avatar -->
                <q-avatar size="100px" v-if="userData && userData.avatar">
                  <img :src="userData.avatar" alt="Avatar">
                </q-avatar>
                <q-avatar size="75px" v-else>
                  <img src="../../assets/user.png" alt="Avatar">
                </q-avatar>


                <input class="q-mt-sm" style="text-align-last: center;" type="file" @change="handleAvatarUpload">

                <!-- Display upload button only when a file is selected -->
                <q-btn v-if="showUploadButton" class="q-mt-sm" label="Upload Image" @click="uploadAvatar" />
              </div>
              <div class="col-6 q-mt-sm q-pr-xl" style="align-self: end;" v-if="userData">
                <div class="desktop-item" style="text-align: left;">Fullname:</div>
                <div class="desktop-field">
                  <template v-if="!isEditing">
                    <input class="text-center  desktop-input" :value="userData.fullname" readonly />
                  </template>
                  <template v-else>
                    <input v-model="editedUserData.fullname" id="fullnameInput" name="fullname" />
                  </template>
                </div>
              </div>

              <div class="col-6 q-pl-xl q-mt-sm" v-if="userData">
                <div class="desktop-item" style="text-align: left;">Department:</div>
                <div class="desktop-field">
                  <template v-if="!isEditing">
                    <input outlined class="text-center  desktop-input" :value="userData.department" readonly />
                  </template>
                  <template v-else>
                    <input v-model="editedUserData.department" id="departmentInput" name="department" />
                  </template>
                </div>
              </div>

              <div class="col-6 q-pr-xl q-mt-sm" v-if="userData">
                <div class="desktop-item" style="text-align: left;">Position:</div>
                <div class="desktop-field">
                  <template v-if="!isEditing">
                    <input outlined class="text-center  desktop-input" :value="userData.position" readonly />
                  </template>
                  <template v-else>
                    <input v-model="editedUserData.position" id="roleInput" name="position"
                      :disabled="disablePositionEditing" />
                  </template>
                </div>
              </div>

              <div class="col-6 q-pl-xl q-mt-sm" v-if="userData">
                <div class="desktop-item" style="text-align: left;">Email:</div>
                <div class="desktop-field">
                  <template v-if="!isEditing">
                    <input class="text-center  desktop-input" :value="userData.email" readonly />
                  </template>
                  <template v-else>
                    <input v-model="editedUserData.email" id="emailInput" name="email" />
                  </template>
                </div>
              </div>
              <div class="col-6 q-pr-xl q-mt-sm" v-if="userData">
                <div class="desktop-item" style="text-align: left;">Password:</div>
                <div class="desktop-field">
                  <template v-if="!isEditing">
                    <input class="text-center  desktop-input" readonly />

                  </template>
                  <template v-else>
                    <input v-model="editedUserData.password" id="passwordInput" name="password"
                      :type="showPassword ? 'text' : 'password'" maxlength="20" />

                  </template>
                </div>
              </div>
            </div>
            <div class="row q-mt-sm q-mr-lg ">
              <div class="col q-px-xl" style="text-align: end;">
                <template v-if="!isEditing">
                  <q-btn class="color-green" label="Edit" @click="editUser" />
                </template>
                <template v-else>
                  <div class="row">
                    <div class="col q-mr-sm">
                      <q-btn label="Cancel" color="negative" @click="cancelEdit" />
                    </div>
                    <form @submit.prevent="saveChanges">
                      <!-- Your input fields go here -->
                      <q-btn class="color-green" label="Save" type="submit" />
                    </form>

                  </div>
                </template>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--Mobile-->
      <div class="row q-mx-md mobile-style" v-if="$q.screen.width <= 1084">
        <div class="q-ml-lg mobile-caption">Personal Information</div>
        <!-- Display user data -->
        <div class="col-sm-12 q-px-xl" v-if="userData">
          <div class="mobile-item">Fullname:</div>
          <div class="mobile-field">
            <template v-if="!isEditing">
              <input class="text-center q-ml-lg mobile-input" :value="userData.fullname" readonly />
            </template>
            <template v-else>
              <input v-model="editedUserData.fullname" id="fullnameInput" name="fullname" />
            </template>
          </div>
        </div>

        <div class="col-sm-12 q-px-xl" v-if="userData">
          <div class="mobile-item">Department:</div>
          <div class="mobile-field">
            <template v-if="!isEditing">
              <input outlined class="text-center q-ml-lg mobile-input" :value="userData.department" readonly />
            </template>
            <template v-else>
              <input v-model="editedUserData.department" id="departmentInput" name="department" />
            </template>
          </div>
        </div>

        <div class="col-sm-12 q-px-xl" v-if="userData">
          <div class="mobile-item">Position:</div>
          <div class="mobile-field">
            <template v-if="!isEditing">
              <input outlined class="text-center q-ml-lg mobile-input" :value="userData.position" readonly />
            </template>
            <template v-else>
              <input v-model="editedUserData.position" id="roleInput" name="position" />
            </template>
          </div>
        </div>

        <div class="col-sm-12  q-px-xl" v-if="userData">
          <div class="mobile-item">Email:</div>
          <div class="mobile-field">
            <template v-if="!isEditing">
              <input class="text-center q-ml-lg mobile-input" :value="userData.email" readonly />
            </template>
            <template v-else>
              <input v-model="editedUserData.email" id="emailInput" name="email" />
            </template>
          </div>
        </div>
        <div class="row q-mt-sm q-mr-lg desktop-edit">
          <div class="col">
            <template v-if="!isEditing">
              <q-btn class="color-green" label="Edit" @click="editUser" />
            </template>
            <template v-else>
              <div class="row">
                <div class="col q-mr-sm">
                  <q-btn label="Cancel" color="negative" @click="cancelEdit" />
                </div>
                <form @submit.prevent="saveChanges">
                  <!-- Your input fields go here -->
                  <q-btn class="color-green" label="Save" type="submit" />
                </form>

              </div>
            </template>
          </div>
        </div>
      </div>


    </q-card>
  </q-page>
</template>

<script src="src/pages/scripts/AccountManagement.js"></script>

<style lang="scss" scoped>
@import "pages/admin-folder/admin-style/AccountManagement.scss";
</style>
