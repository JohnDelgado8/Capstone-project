<template>
  <q-page>
    <q-card class="q-px-md card-desktop" v-if="$q.screen.width >= 550">
      <div class="text-h5 q-ml-sm q-py-md">Registration</div>
      <div class="form-size q-pa-md">
        <p>The new account for the users of Forbes.</p>
        <q-form @submit.prevent="register" class="form-space q-mt-xl q-px-lg">
          <div class="row" style="gap: 20px;">
            <div class="">
              <!-- Fullname -->
              <span class="q-ml-sm">Fullname</span>
              <q-input class="input-field q-mb-md" standout="bg-teal text-white" v-model="fullname" label="Full name" />

              <!-- Department -->
              <span class="q-ml-sm">Department</span>
              <q-select class="input-field q-mb-md" standout="bg-teal text-white" v-model="department"
                :options="options_department" label="Choose Department" />

              <!-- Role -->
              <span class="q-ml-sm">Role</span>
              <q-select class="input-field q-mb-sm" standout="bg-teal text-white" v-model="position"
                :options="options_position" label="What Role" />

            </div>
            <div class="">
              <template v-if="position === 'Instructor'">
                <!-- Specialization -->
                <span class="q-ml-sm">Specialization</span>
                <q-select class="input-field q-mb-md" standout="bg-teal text-white" v-model="course"
                  :options="courseOptions" label="Choose Specialization" />
              </template>
              <!-- Username -->
              <span class="q-ml-sm">Email</span>
              <q-input class="input-field q-mb-md" standout="bg-teal text-white" v-model="email" label="Email" />


              <!-- Password -->
              <span class="q-ml-sm">Password</span>
              <q-input class="input-field" standout="bg-teal text-white" v-model="password"
                :type="showPassword ? 'text' : 'password'" label="Password">
                <template v-slot:append>
                  <q-icon :name="showPassword ? 'visibility_off' : 'visibility'" class="cursor-pointer"
                    @click="togglePasswordVisibility" />
                </template>
              </q-input>

              <!-- Add User Button -->
              <div class="input-field q-mt-lg text-right">
                <q-btn class="q-mr-md back-button" label="Back" @click="goToDashboard" />
                <q-btn type="submit" label="Add User" color="green" :disable="!isFormValid" />
              </div>
            </div>
          </div>
        </q-form>
      </div>
    </q-card>

    <q-card class="card-mobile q-px-md" v-if="$q.screen.width <= 550">
      <div class="text-h5 q-ml-sm q-py-md">Registration</div>
      <div class="form-size q-pa-md">
        <p>The new account for the users of Forbes.</p>
        <q-form @submit.prevent="register" class="form-space q-mt-xl">
          <div class="row">
            <div class="col-lg-6">
              <span class="q-ml-sm">Fullname</span>
              <q-input class="input-field q-mb-md" standout="bg-teal text-white" v-model="fullname" label="Full name" />

              <!-- Department -->
              <span class="q-ml-sm">Department</span>
              <q-select class="input-field q-mb-md" standout="bg-teal text-white" v-model="department"
                :options="options_department" label="Choose Department" />

              <!-- Role -->
              <span class="q-ml-sm">Role</span>
              <q-select class="input-field q-mb-md" standout="bg-teal text-white" v-model="position"
                :options="options_position" label="What Role" />

            </div>
            <div class="col-6">
              <template v-if="position === 'Instructor'">
                <!-- Specialization -->
                <span class="q-ml-sm">Specialization</span>
                <q-select class="input-field q-mb-md" standout="bg-teal text-white" v-model="course"
                  :options="courseOptions" label="Choose Specialization" />
              </template>
              <!-- Username -->
              <span class="q-ml-sm">Username</span>
              <q-input class="input-field q-mb-md" standout="bg-teal text-white" v-model="email" label="Username" />

              <!-- Password -->
              <span class="q-ml-sm">Password</span>
              <q-input class="input-field" standout="bg-teal text-white" v-model="password"
                :type="showPassword ? 'text' : 'password'" label="Password">
                <template v-slot:append>
                  <q-icon :name="showPassword ? 'visibility_off' : 'visibility'" class="cursor-pointer"
                    @click="togglePasswordVisibility" />
                </template>
              </q-input>

              <!-- Add User Button -->
              <div class="input-field q-mt-lg text-right">
                <q-btn class="q-mr-md back-button" label="Back" @click="goToDashboard" />
                <q-btn type="submit" label="Add User" color="green" :disable="!isFormValid" />
              </div>
            </div>
          </div>
        </q-form>
      </div>
    </q-card>
  </q-page>
</template>
<script src="src/pages/admin-folder/admin-scripts/Register.js"></script>

<style lang="scss" scoped>
@import "pages/admin-folder/admin-style/Registration.scss";
</style>
