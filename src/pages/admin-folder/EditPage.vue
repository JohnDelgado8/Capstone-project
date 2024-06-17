<template>
  <q-page>
    <q-card class="q-pa-md" style="background-color: #f2f2f2; height: 100vh;">
      <div class="text-h5 q-mb-md text-bold">Edit User Details</div>
      <q-form @submit.prevent="updateUser">
        <!-- Full Name -->
        <div class="row">
          <div class="col-6 q-px-sm">
            <q-input filled v-model="user.fullname" label="Full Name" />
          </div>
          <div class="col-6 q-px-sm">
            <q-input filled v-model="user.department" label="Department" />
          </div>
        </div>

        <!-- Add spacing between rows -->
        <div class="row q-mt-sm">
          <div class="col-6 q-px-sm">
            <q-input filled v-model="user.position" label="Position" />
          </div>
          <div class="col-6 q-px-sm">
            <q-input filled v-model="user.email" label="Email" />
          </div>
        </div>

        <!-- Course (if position is Instructor) -->
        <div class="row q-mt-sm">
          <div class="col-6 q-px-sm">
            <q-input filled v-if="user.position === 'Instructor'" v-model="user.course" label="Course" />
          </div>
        </div>

        <!-- Submit Button -->
        <div class="row q-mt-md">
          <div class="col q-px-sm" style="text-align: end;">
            <q-btn class="q-mx-sm text-bold" @click="goToAccountTable" label="Back"
              style="background-color: #f2f2f2;" />
            <q-btn type="submit" label="Update" color="primary" />
          </div>
        </div>
      </q-form>
    </q-card>
  </q-page>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      user: {
        id: '',
        fullname: '',
        department: '',
        position: '',
        course: '',
        email: '',
        password: ''
      },
      originalUser: {} // Store original user data
    };
  },
  created() {
    const userId = this.$route.query.userId;
    this.fetchUserDetails(userId);
  },
  methods: {
    goToAccountTable() {
      this.$router.push({ name: 'account' });
    },
    fetchUserDetails(userId) {
      axios.get(`https://forbesscheduling.000webhostapp.com/server/get_account.php?userId=${userId}`)
        .then(response => {
          this.user = { ...response.data };
          this.originalUser = { ...response.data };
        })
        .catch(error => {
          console.error('Error fetching user details:', error);
        });
    },
    updateUser() {
      // Compare each field with the original value to determine which fields were edited
      const editedFields = {};
      for (const key in this.user) {
        if (this.user[key] !== this.originalUser[key]) {
          editedFields[key] = `${this.originalUser[key]} -> ${this.user[key]}`;
        }
      }

      // Save the edited details to history log if any field was edited
      if (Object.keys(editedFields).length > 0) {
        editedFields.id = this.user.id; // Include the user ID
        this.saveToHistoryLog(editedFields);
      }

      axios.put(`https://forbesscheduling.000webhostapp.com/server/update-user.php/${this.user.id}`, this.user)
        .then(response => {
          console.log('User details updated successfully:', response.data);
          this.$q.notify({
            message: 'User details updated successfully',
            color: 'positive',
            position: 'bottom',
            timeout: 2000
          });
          this.$router.push({ name: 'account' });
        })
        .catch(error => {
          console.error('Error updating user details:', error);
          this.$q.notify({
            message: 'Error updating user details',
            color: 'negative',
            position: 'bottom',
            timeout: 2000
          });
        });
    },
    saveToHistoryLog(editedFields) {
      axios.post("https://forbesscheduling.000webhostapp.com/server/history.php", editedFields)
        .then(response => {
          console.log('Successfully saved edited details to history log:', response.data);
        })
        .catch(error => {
          console.error('Error saving edited details to history log:', error);
        });
    }
  }
};
</script>

<style scoped>
.edit-card {
  max-width: 400px;
}
</style>
