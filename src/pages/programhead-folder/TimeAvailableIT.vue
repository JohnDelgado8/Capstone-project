<template>
  <q-page>
    <q-card class="card-size">
      <q-card-section>
        <div class="text-h5 q-ml-sm cite-caption text-bold">Instructors</div>
      </q-card-section>

      <q-card class="q-mx-lg" style="background-color: white; height: 100vh;">
        <div class="course-caption text-center q-mb-lg q-pt-md" style="font-size: 20px;">
          IT Instructor
        </div>
        <div class="row q-px-md">
          <div class="col-md-6">
            <div v-if="loading">
              Loading...
            </div>

            <div v-else>



              <!-- Display IT instructors -->
              <div v-if="itInstructors.length > 0">

                <q-card class="my-card" v-for="instructor in itInstructors" :key="instructor.name">
                  <q-card-section>
                    <div class="text-h6 text-center">{{ instructor.name }}</div>
                    <div class="text-subtitle2 animation-color text-center">{{ instructor.course }}</div>
                  </q-card-section>
                </q-card>
              </div>
            </div>
          </div>

        </div>
      </q-card>
    </q-card>
  </q-page>
</template>
<script src="pages/programhead-folder/programhead-scripts/ProgramHeadTime"></script>

<style lang="scss" scoped>
@import "pages/programhead-folder/programhead-style/Instructor-Availability.scss";
</style>




