<template>
  <div class="" v-if="$q.screen.width >= 550">
    <div v-if="!otpVerified">
      <!-- Forgot Password Form -->
      <div style="text-align: -webkit-center; background-color: #f2f2f2; height: 100vh;">
        <div class="row" style="height: 100vh;">
          <div class="col" style="align-self: center;">
            <q-card style="max-width: 550px; height: 200px;">
              <div class="q-py-md" style="font-size: 30px; font-weight: bold;">Forgot Password</div>
              <q-form @submit.prevent="sendOTP">
                <q-input v-model="email" class="q-px-lg" filled label="Email" type="email" />
                <q-btn color="black" class="q-mt-md" :disable="sending" label="Send OTP" type="submit" />
                <q-spinner-gate :show="sending" />
              </q-form>
            </q-card>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <!-- Verify OTP Form -->
      <div v-if="!changePasswordFormVisible"
        style="text-align: -webkit-center; background-color: #f2f2f2; height: 100vh;">
        <div class="row" style="height: 100vh;">
          <div class="col" style="align-self: center;">
            <q-card style="max-width: 550px; height: 200px;">
              <div class="q-py-md" style="font-size: 30px; font-weight: bold;">Input your OTP</div>
              <q-form @submit.prevent="verifyOTP">
                <q-input v-model="otp" class="q-px-lg" name="otp" filled label="OTP Number" type="number" />
                <q-btn color="black" class="q-mt-md" :disable="sending" label="Verify OTP" type="submit" />
                <q-spinner-gate :show="sending" />
              </q-form>
            </q-card>
          </div>
        </div>
      </div>
      <!-- Change Password Form -->
      <div v-else style="text-align: -webkit-center; background-color: #f2f2f2; height: 100vh;">
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
    </div>
  </div>

  <div class="" v-if="$q.screen.width <= 549">
    <div v-if="!otpVerified">
      <!-- Forgot Password Form -->
      <div style="text-align: -webkit-center; background-color: #f2f2f2; height: 100vh;">
        <div class="row" style="height: 100vh;">
          <div class="col" style="align-self: center;">
            <q-card style="max-width: 320px; height: 200px;">
              <div class="q-py-md" style="font-size: 30px; font-weight: bold;">Forgot Password</div>
              <q-form @submit.prevent="sendOTP">
                <q-input v-model="email" class="q-px-lg" filled label="Email" type="email" />
                <q-btn color="black" class="q-mt-md" :disable="sending" label="Send OTP" type="submit" />
                <q-spinner-gate :show="sending" />
              </q-form>
            </q-card>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <!-- Verify OTP Form -->
      <div v-if="!changePasswordFormVisible"
        style="text-align: -webkit-center; background-color: #f2f2f2; height: 100vh;">
        <div class="row" style="height: 100vh;">
          <div class="col" style="align-self: center;">
            <q-card style="max-width: 320px; height: 200px;">
              <div class="q-py-md" style="font-size: 30px; font-weight: bold;">Input your OTP</div>
              <q-form @submit.prevent="verifyOTP">
                <q-input v-model="otp" class="q-px-lg" name="otp" filled label="OTP Number" type="number" />
                <q-btn color="black" class="q-mt-md" :disable="sending" label="Verify OTP" type="submit" />
                <q-spinner-gate :show="sending" />
              </q-form>
            </q-card>
          </div>
        </div>
      </div>
      <!-- Change Password Form -->
      <div v-else style="text-align: -webkit-center; background-color: #f2f2f2; height: 100vh;">
        <div class="row" style="height: 100vh;">
          <div class="col" style="align-self: center;">
            <q-card style="max-width: 320px; height: 200px;">
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
    </div>
  </div>
</template>


<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      otp: '',
      newPassword: '', // Added for Change Password form
      sending: false,
      otpVerified: false,
      changePasswordFormVisible: false // Added to control the visibility of the Change Password form
    };
  },
  methods: {
    sendOTP() {
      if (!this.email.trim()) {
        alert('Email address is missing');
        return;
      }

      this.sending = true;

      axios.post('https://forbesscheduling.000webhostapp.com/server/send_otp.php', { email: this.email })
        .then(response => {
          if (response.data.success) {
            this.otpVerified = true;
            alert('OTP sent!');
          }
        })
        .catch(error => {
          console.error('Error sending OTP:', error);
          alert('Failed to send OTP');
        })
        .finally(() => {
          this.sending = false;
        });
    },
    verifyOTP() {
      if (!this.otp) {
        alert('Please enter OTP');
        return;
      }

      this.sending = true;

      const formData = {
        otp: this.otp,
        email: this.email
      };

      axios.post('https://forbesscheduling.000webhostapp.com/server/verify_otp.php/', formData)
        .then(response => {
          console.log(response.data)
          if (response.data.success) {
            // OTP verification successful, show Change Password form
            this.changePasswordFormVisible = true;
            alert('OTP verified! You can now change your password.');
          } else {
            let errorMessage = response.data.message || 'Invalid OTP';
            alert(errorMessage);
          }
        })
        .catch(error => {
          console.error('Error verifying OTP:', error);
          alert('Failed to verify OTP');
        })
        .finally(() => {
          this.sending = false;
        });
    },
    changePassword() {
      // Log the email before making the request (optional)
      console.log("Email:", this.email);

      // Make a POST request to the PHP script with email and new password data
      axios.post('https://forbesscheduling.000webhostapp.com/server/change_password.php', {
        email: this.email,
        newPassword: this.newPassword
      })
        .then(response => {
          // Check if the password change was successful based on the response
          if (response.data.success) {
            alert('Password changed successfully');
            // Optionally, redirect the user to a login page or another route
          } else {
            alert('Failed to change password');
          }
        })
        .catch(error => {
          // Log and handle errors if the request fails
          console.error('Error changing password:', error);
          alert('Failed to change password');
        });
    }
  }
};

</script>
