<template>
  <q-page>
    <q-card class="card-size">
      <q-card-section>
        <div class="text-h5 q-ml-sm cite-caption">Marketing</div>
      </q-card-section>

      <!--Desktop-->
      <div class="" v-if="$q.screen.width >= 856">
        <div class="row">
          <div class="col-3">
            <div class="row q-px-md">
              <q-card class="my-card">
                <q-card-section class="q-px-lg">
                  <div class="text-h6 animation-color" color="#">Digital Marketing <q-icon style="color: #57BA98;"
                      name="animation"></q-icon></div>
                  <div class="text-h3 animation-color q-ml-md q-mb-sm">{{ getInstructorCount('Digital Marketing') }}
                  </div>
                  <div class="animation-color">Total Availabilities </div>
                </q-card-section>


              </q-card>
            </div>
          </div>
          <div class="col-3">

            <div class="row q-px-md">
              <q-card class="my-card">
                <q-card-section>
                  <div class="text-h6 animation-color IT-size">Brand Management <q-icon style="color: #dbc300;"
                      name="lightbulb_outline"></q-icon></div>

                  <div class="text-h3 animation-color q-ml-md q-mb-sm">
                    {{ getInstructorCount('Brand Management') }}
                  </div>
                  <div class="animation-color">Total Availabilities </div>
                </q-card-section>
              </q-card>
            </div>
          </div>
          <div class="col-6">

            <div class="row q-px-md">
              <q-card class="my-card" style="background-color:#57BA98">
                <q-card-section class="q-px-lg" style="color: #182628">
                  Subjects!
                  <!-- <div class="text-h6 animation-color" color="#">Animation <q-icon style="color: #57BA98;"
                    name="animation"></q-icon></div>
                <div class="text-h3 animation-color q-ml-md q-mb-sm">{{  getInstructorCount('Animation') }}</div>
                <div class="animation-color">Total Availabilities </div> -->
                </q-card-section>


              </q-card>
            </div>
          </div>
        </div>
      </div>

      <!--Tablet-->
      <div class="" v-if="$q.screen.width >= 473 && $q.screen.width <= 856">
        <div class="row">
          <div class="col-6">
            <div class="row q-px-md">
              <q-card class="my-card">
                <q-card-section class="q-px-lg">
                  <div class="text-h6 animation-color" color="#">Digital Marketing <q-icon style="color: #57BA98;"
                      name="animation"></q-icon></div>
                  <div class="text-h3 animation-color q-ml-md q-mb-sm">{{ getInstructorCount('Digital Marketing') }}
                  </div>
                  <div class="animation-color">Total Availabilities </div>
                </q-card-section>


              </q-card>
            </div>
          </div>
          <div class="col-6">

            <div class="row q-px-md">
              <q-card class="my-card">
                <q-card-section>
                  <div class="text-h6 animation-color IT-size">Brand Management <q-icon style="color: #dbc300;"
                      name="lightbulb_outline"></q-icon></div>

                  <div class="text-h3 animation-color q-ml-md q-mb-sm">
                    {{ getInstructorCount('Brand Management') }}
                  </div>
                  <div class="animation-color">Total Availabilities </div>
                </q-card-section>
              </q-card>
            </div>
          </div>
          <div class="col-12">

            <div class="row q-px-md">
              <q-card class="my-card" style="background-color:#57BA98; margin-top: 20px;">
                <q-card-section class="q-px-lg" style="color: #182628">
                  Subjects!
                  <!-- <div class="text-h6 animation-color" color="#">Animation <q-icon style="color: #57BA98;"
                    name="animation"></q-icon></div>
                <div class="text-h3 animation-color q-ml-md q-mb-sm">{{  getInstructorCount('Animation') }}</div>
                <div class="animation-color">Total Availabilities </div> -->
                </q-card-section>


              </q-card>
            </div>
          </div>
        </div>
      </div>

      <!--Mobile-->
      <div class="" v-if="$q.screen.width <= 473">
        <div class="row">
          <div class="col-12">
            <div class="row q-px-md">
              <q-card class="my-card">
                <q-card-section class="q-px-lg">
                  <div class="text-h6 animation-color" color="#">Animation <q-icon style="color: #57BA98;"
                      name="animation"></q-icon></div>
                  <div class="text-h3 animation-color q-ml-md q-mb-sm">{{ getInstructorCount('Animation') }}</div>
                  <div class="animation-color">Total Availabilities </div>
                </q-card-section>


              </q-card>
            </div>
          </div>
          <div class="col-12">

            <div class="row q-px-md">
              <q-card class="my-card q-mt-md">
                <q-card-section>
                  <div class="text-h6 animation-color IT-size">Brand Management <q-icon style="color: #dbc300;"
                      name="lightbulb_outline"></q-icon></div>

                  <div class="text-h3 animation-color q-ml-md q-mb-sm">
                    {{ getInstructorCount('') }}
                  </div>
                  <div class="animation-color">Total Availabilities </div>
                </q-card-section>
              </q-card>
            </div>
          </div>
          <div class="col-12">

            <div class="row q-px-md">
              <q-card class="my-card" style="background-color:#57BA98; margin-top: 20px;">
                <q-card-section class="q-px-lg" style="color: #182628">
                  Subjects!
                  <!-- <div class="text-h6 animation-color" color="#">Animation <q-icon style="color: #57BA98;"
                    name="animation"></q-icon></div>
                <div class="text-h3 animation-color q-ml-md q-mb-sm">{{  getInstructorCount('Animation') }}</div>
                <div class="animation-color">Total Availabilities </div> -->
                </q-card-section>


              </q-card>
            </div>
          </div>
        </div>
      </div>
    </q-card>
  </q-page>
</template>

<script src="pages/programhead-folder/programhead-scripts/ProgramHeadSubject"></script>

<style lang="scss" scoped>
@import "pages/programhead-folder/programhead-style/ProgramHead-Subject.scss";
</style>
