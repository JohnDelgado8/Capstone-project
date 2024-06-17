<template>
  <div style="text-align: -webkit-center; background-color: #f2f2f2; height: 100vh;">
    <div class="row" style="height: 100vh;">
      <div class="col" style="align-self: center;">
        <q-card style="max-width: 550px; height: 200px;">
          <div class="q-py-md" style="font-size: 30px; font-weight: bold;">Change Password</div>
          <q-form @submit.prevent="changePassword">
            <q-input v-model="newPassword" class="q-px-lg" filled label="New Password" type="password" />
            <q-btn color="black" class="q-mt-md" label="Change Password" type="submit" />
            <q-spinner-gate :show="sending" />
          </q-form>
        </q-card>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      otp: '',
      newPassword: '',
      email: '',
    };
  },
  methods: {
    changePassword() {
      console.log(this.email)
      console.log("Input", this.newPassword)
      // axios.post('http://localhost/change_password.php', { email: this.email })
      //   .then(response => {
      //     if (response.data.success) {
      //       alert('Password changed successfully');
      //       // Optionally, redirect the user to a login page or another route
      //     } else {
      //       alert('Failed to change password');
      //     }
      //   })
      //   .catch(error => {
      //     console.error('Error changing password:', error);
      //     alert('Failed to change password');
      //   });
    }
  }
};
</script>
