<template>
  <q-page>
    <q-card class="main-card">
      <q-card-section>
        <div class="text-h5 q-ml-sm">My Account</div>
      </q-card-section>

      <!-- Desktop-->
      <div class="row q-ml-lg desktop-style" v-if="$q.screen.width >= 768">
        <div class="q-ml-sm q-mt-sm desktop-caption">Personal Information</div>
        <!-- Display user data -->
        <div class="col-sm-12  q-px-xl" v-if="userData">
          <div class="desktop-item">Fullname:</div>
          <div class="desktop-field">
            <template v-if="!isEditing">
              <input class="text-center q-ml-lg desktop-input" :value="userData.fullname" readonly />
            </template>
            <template v-else>
              <input v-model="editedUserData.fullname" id="fullnameInput" name="fullname" />
            </template>
          </div>
        </div>

        <div class="col-sm-12  q-px-xl" v-if="userData">
          <div class="desktop-item">Department:</div>
          <div class="desktop-field">
            <template v-if="!isEditing">
              <input outlined class="text-center q-ml-lg desktop-input" :value="userData.department" readonly />
            </template>
            <template v-else>
              <input v-model="editedUserData.department" id="departmentInput" name="department" />
            </template>
          </div>
        </div>

        <div class="col-sm-12  q-px-xl" v-if="userData">
          <div class="desktop-item">Role:</div>
          <div class="desktop-field">
            <template v-if="!isEditing">
              <input outlined class="text-center q-ml-lg desktop-input" :value="userData.position" readonly />
            </template>
            <template v-else>
              <input v-model="editedUserData.position" id="roleInput" name="position" />
            </template>
          </div>
        </div>

        <div class="col-sm-12  q-px-xl" v-if="userData">
          <div class="desktop-item">Username:</div>
          <div class="desktop-field">
            <template v-if="!isEditing">
              <input class="text-center q-ml-lg desktop-input" :value="userData.email" readonly />
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


      <!--Mobile-->
      <div class="row q-mx-md mobile-style" v-if="$q.screen.width <= 768">
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
          <div class="mobile-item">Role:</div>
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
          <div class="mobile-item">Username:</div>
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
@import "pages/academic-coordinator-folder/academic-style/AcademicAccount.scss";
</style>
