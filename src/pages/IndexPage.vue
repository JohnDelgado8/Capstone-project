<template>
  <div class="" v-if="$q.screen.width >= 550">
    <q-page>
      <q-card v-if="!loggedIn" style="height: 100vh;">
        <div class="row">
          <div class="col-7" style="height: 100vh;">
            <q-card-section>
              <div class="sign-caption text-center text-weight-bold q-mb-lg">
                Sign in
              </div>
              <div class="text-center">
                <q-btn class="q-mr-md" round icon="public" style="background-color: #3B945E; color: #f2f2f2;" />
                <q-btn round icon="star" style="color: orange;" />
                <q-btn class="q-ml-md" round icon="school" style="background-color: red; color: #f2f2f2;" />
              </div>
            </q-card-section>
            <q-card-section>
              <div class="gmail-caption text-center q-mt-sm">
                use only your g-suite account
              </div>
              <q-form @submit="login" class="form-space q-pt-lg">

                <q-input class="q-mb-sm" standout="bg-teal text-white" v-model="email" label="Email" />
                <q-input standout="bg-teal text-white" v-model="password" :type="showPassword ? 'text' : 'password'"
                  label="Password">
                  <template v-slot:append>
                    <q-icon :name="showPassword ? 'visibility_off' : 'visibility'" class="cursor-pointer"
                      @click="togglePasswordVisibility" />
                  </template>
                </q-input>
                <q-spinner-v9 v-if="loading" />
                <div class="forgot-text text-center q-mt-lg">
                  <q-btn class="forgot-password-btn" flat @click="redirectToForgotPasswordPage"
                    label="Forgot your password?" />
                </div>
                <div class="row text-center">
                  <div class="col">
                    <q-btn label="Sign In" type="submit" class="login-button q-mt-sm" rounded />
                  </div>
                </div>
              </q-form>
            </q-card-section>
          </div>
          <div class="col-5 " style="
          background-color: #023020;
        ">
            <div class="row">
              <div class="col text-right q-pt-md q-pr-md">
                <img src="../assets/Forbes-logo.png" style="width: 100px; ">
              </div>
            </div>
            <div class="hello-caption text-center text-weight-bold q-mb-lg">
              Forbes College
            </div>
            <p class="hello-text text-center">
              "Guiding minds, igniting passions.<br> Meet our exceptional educators!"
            </p>



          </div>
        </div>
      </q-card>

      <router-view v-if="loggedIn" @logout="handleLogout"></router-view>
    </q-page>
  </div>

  <div class="" v-if="$q.screen.width <= 549">
    <q-page>
      <q-card v-if="!loggedIn" style="height: 100vh;">

        <div class="row">
          <div class="col-12" style="height: 100vh;">
            <q-card-section>
              <div class="text-center text-weight-bold q-mb-lg mobile-caption">
                Sign in
              </div>
              <div class="text-center">
                <q-btn class="q-mr-md" round icon="public" style="background-color: #3B945E; color: #f2f2f2;" />
                <q-btn round icon="star" style="color: orange;" />
                <q-btn class="q-ml-md" round icon="school" style="background-color: red; color: #f2f2f2;" />

              </div>
            </q-card-section>
            <q-card-section>
              <div class="gmail-caption text-center q-mt-sm">
                use only your g-suite account
              </div>
              <q-form @submit="login" class="q-pa-lg">

                <q-input class="q-mb-sm" standout="bg-teal text-white" v-model="email" label="Email" />
                <q-input standout="bg-teal text-white" v-model="password" :type="showPassword ? 'text' : 'password'"
                  label="Password">
                  <template v-slot:append>
                    <q-icon :name="showPassword ? 'visibility_off' : 'visibility'" class="cursor-pointer"
                      @click="togglePasswordVisibility" />
                  </template>
                </q-input>
                <q-spinner-v9 v-if="loading" />
                <div class="row">
                  <div class="col" style="text-align: -webkit-center; color: #5a5a5a;">
                    <q-btn class="q-mt-md" flat @click="redirectToForgotPasswordPage" label="Forgot your password?" />
                  </div>
                </div>

                <div class="row text-center">
                  <div class="col">
                    <q-btn label="Sign In" type="submit" class="login-button q-mt-sm" rounded />
                  </div>
                </div>
              </q-form>
            </q-card-section>
          </div>

        </div>
      </q-card>
      <router-view v-if="loggedIn" @logout="handleLogout"></router-view>
    </q-page>
  </div>
</template>
<style lang="scss" scoped>
@import "../pages/styles/LoginPage.scss";
</style>
<script src="./scripts/LoginScript"></script>
