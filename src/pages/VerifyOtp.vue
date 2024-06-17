<template>
  <div>
    <!-- If user is logged in, show OTP verification form -->
    <div style="text-align: -webkit-center; background-color: #f2f2f2; height: 100vh;">
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
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      otp: '',
      sending: false,
      email: '', // Email address ng user na nakuha mula sa forgotpassword.vue
    };
  },
  created() {
    // Retrieve email from props upon component creation
    this.email = this.$route.params.email || '';
  },
  methods: {
    verifyOTP() {
      console.log('clicked');
      // if (!this.otp) {
      //   alert('Please enter OTP');
      //   return;
      // }

      // if (!this.email) {
      //   alert('Please enter email');
      //   return;
      // }

      // this.sending = true;
      // const formData = {
      //   otp: this.otp,
      //   email: this.email, // Ipadala ang email address sa verify_otp.php
      // };

      // axios.post('http://localhost/Capstone-System/scheduling-system/API/verify_otp.php/', formData)
      //   .then(response => {
      //     console.log(response.data)
      //     // if (response.data.success) {
      //     //   // OTP verification successful, redirect to change password page
      //     //   this.$router.push('changepass');
      //     // } else {
      //     //   let errorMessage = response.data.message || 'Invalid OTP';
      //     //   alert(errorMessage);
      //     // }
      //   })
      //   .catch(error => {
      //     console.error('Error verifying OTP:', error);
      //     alert('Failed to verify OTP');
      //   })
      //   .finally(() => {
      //     this.sending = false;
      //   });
    }
  }
};
</script>
