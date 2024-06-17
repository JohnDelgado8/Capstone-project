<template>
  <q-page>
    <q-card class="card-size">
      <q-card-section>
        <div class="text-h5 q-ml-sm cite-caption text-bold">Curriculum</div>
      </q-card-section>

      <!--Destkop-->
      <div v-if="$q.screen.width >= 435">
        <div class="row">
          <q-select v-model="selectedSchoolYear" :options="schoolYearOptions" class="q-pl-md q-pr-sm" label="School Yr."
            filled dense clearable style="min-width: 150px;">
          </q-select>
          <div class="q-mr-lg text-center" style="width: 10px; padding-top: 8px;">
            <div style="height: 100%;">
              <q-btn class="add-block" padding="none" color="primary" icon="add" @click="schoolYearDialog = true" />
            </div>
          </div>
          <q-dialog v-model="schoolYearDialog" persistent>
            <q-card>
              <q-card-section class="row items-center">
                <q-form @submit.prevent="addSchoolYear">
                  <q-input class="q-mb-sm" v-model="newSchoolYear" label="Add School Year" outlined dense />
                  <div class="row justify-center mt-5">
                    <q-btn class="q-px-sm" padding="none" icon="close" color="negative"
                      @click="schoolYearDialog = false" />
                    <q-btn padding="none" type="submit" icon="add" color="primary" :disable="!newSchoolYear" />
                  </div>
                </q-form>
              </q-card-section>
            </q-card>
          </q-dialog>

          <q-select v-model="semesterModel" :options="semesterOptions" label="Semester" filled dense clearable
            style="min-width: 150px;">
          </q-select>
          <q-select v-model="selectedCourse" :options="courseOptions" label="Course" filled dense clearable
            style="min-width: 150px;" class="q-ml-sm">
          </q-select>

          <div class="col q-px-md text-right">
            <q-btn style="background-color: #182628; color: white" @click="showDialog = true" label="Add Curriculum" />
            <q-dialog v-model="showDialog" persistent>
              <q-card>
                <q-card-section>
                  <q-form @submit.prevent="addCurriculum" style="width: 250px;">
                    <q-select filled v-model="year" :options="yearOptions" label="Year" />
                    <q-input filled class="q-mt-sm" v-model="subject" label="Subject" />
                    <q-input filled class="q-mt-sm q-mb-md" v-model="courseCode" label="Course Code" />
                    <q-select filled class="q-mt-sm q-mb-md" v-model="units" :options="unitsOptions" label="Units" />
                    <q-input filled class="q-mt-sm q-mb-md" v-model="selectedSchoolYear.value" readonly
                      label="School Year" />
                    <q-input filled class="q-mt-sm q-mb-md" v-model="semesterModel" readonly label="Semester" />
                    <q-input filled class="q-mt-sm q-mb-md" v-model="selectedCourse.label" readonly label="Course" />
                    <div style="text-align: -webkit-center;">
                      <q-btn class="q-mr-sm" label="Cancel" color="negative" @click="cancelAddCurriculum" />
                      <q-btn style="background-color: #3b945e; color:white;  " type="submit"
                        :disable="!isValidForm">Add</q-btn>
                    </div>
                  </q-form>
                </q-card-section>
              </q-card>
            </q-dialog>
          </div>
        </div>
        <div v-if="selectedCourse">
          <div v-if="!semesterModel" class="text-h6 text-center my-3">
            <div class="row" style="height: 350px;">
              <div class="col" style="align-self: center;">
                Please select a semester
              </div>
            </div>
          </div>
          <div class="row">
            <div v-for="(yearCurriculums, year) in filteredCurriculums" :key="year" class="col-6 q-mt-md">
              <q-card class="q-mx-md my-content">
                <div class="text-center q-mb-md" style="font-weight: bold;">Year {{ year }}</div>
                <!-- Display curriculum data for each year dynamically -->
                <div v-for="(curriculum, index) in yearCurriculums" :key="index">
                  <div>{{ curriculum.Subject }} ({{ curriculum.course_code || 'No Course Code' }}) ({{ curriculum.units
                    }}
                    units)</div>
                </div>
              </q-card>
            </div>
          </div>
        </div>
      </div>

      <!--Mobile-->
      <div v-if="$q.screen.width <= 435">
        <div class="row">
          <q-select v-model="selectedSchoolYear" :options="schoolYearOptions" class="q-pl-md q-pr-sm" label="School Yr."
            filled dense clearable style="min-width: 150px;">
          </q-select>
          <div class="q-mr-lg text-center" style="width: 10px; padding-top: 8px;">
            <div style="height: 100%;">
              <q-btn class="add-block" padding="none" color="primary" icon="add" @click="schoolYearDialog = true" />
            </div>
          </div>
          <q-dialog v-model="schoolYearDialog" persistent>
            <q-card>
              <q-card-section class="row items-center">
                <q-form @submit.prevent="addSchoolYear">
                  <q-input class="q-mb-sm" v-model="newSchoolYear" label="Add School Year" outlined dense />
                  <div class="row justify-center mt-5">
                    <q-btn class="q-px-sm" padding="none" icon="close" color="negative"
                      @click="schoolYearDialog = false" />
                    <q-btn padding="none" type="submit" icon="add" color="primary" :disable="!newSchoolYear" />
                  </div>
                </q-form>
              </q-card-section>
            </q-card>
          </q-dialog>

          <q-select v-model="semesterModel" :options="semesterOptions" label="Semester" filled dense clearable
            style="min-width: 150px;">
          </q-select>

          <div class="col q-px-md text-right">
            <q-btn color="primary" @click="showDialog = true" label="Add Curriculum" />
            <q-dialog v-model="showDialog" persistent>
              <q-card>
                <q-card-section>
                  <q-form @submit.prevent="addCurriculum" style="width: 250px;">
                    <q-select filled v-model="year" :options="yearOptions" label="Year" />
                    <q-input filled class="q-mt-sm" v-model="subject" label="Subject" />
                    <q-input filled class="q-mt-sm q-mb-md" v-model="courseCode" label="Course Code" />
                    <q-select filled class="q-mt-sm q-mb-md" v-model="units" :options="unitsOptions" label="Units" />
                    <q-input filled class="q-mt-sm q-mb-md" v-model="selectedSchoolYear" readonly label="School Year" />
                    <q-input filled class="q-mt-sm q-mb-md" v-model="semesterModel" readonly label="Semester" />
                    <div style="text-align: -webkit-center;">
                      <q-btn class="q-mr-sm" label="Cancel" color="negative" @click="cancelAddCurriculum" />
                      <q-btn style="background-color: #3b945e; color:white;  " type="submit"
                        :disable="!isValidForm">Add</q-btn>
                    </div>
                  </q-form>
                </q-card-section>
              </q-card>
            </q-dialog>
          </div>
        </div>

        <div v-if="!semesterModel" class="text-h6 text-center my-3">
          <div class="row" style="height: 350px;">
            <div class="col" style="align-self: center;">
              Please select a semester
            </div>
          </div>
        </div>
        <div class="row">
          <div v-for="(yearCurriculums, year) in filteredCurriculums" :key="year" class="col-6 q-mt-md">
            <q-card class="q-mx-md my-content">
              <div class="text-center q-mb-md" style="font-weight: bold;">Year {{ year }}</div>
              <!-- Display curriculum data for each year dynamically -->
              <div v-for="(curriculum, index) in yearCurriculums" :key="index">
                <!-- Display curriculum data without checkboxes -->
                <div>{{ curriculum.Subject }} ({{ curriculum.course_code || 'No Course Code' }}) ({{ curriculum.units
                  }}units)</div>div>
              </div>
            </q-card>
          </div>
        </div>
      </div>
    </q-card>
  </q-page>
</template>

<script src="../dean-folder/dean-scripts/Curriculum">
</script>

<style lang="scss" scoped>
.my-card {
  width: 100%;
  max-width: 300px;
  background-color: #57ba98;
  color: white;
}

.card-size {
  height: 1050px;
  background-color: #f2f2f2;
}

@media only screen and (max-width: 435px) {
  .card-size {
    height: 1800px;
    background-color: #f2f2f2;
  }
}

.course-caption {
  color: #182628;
  font-size: 20px;
  font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif;
}

.animation-color {
  color: #182628;
  font-weight: bold;
}

.it-color {
  color: #fef250;
}

.my-content {
  padding: 10px 15px;
  background: white;
  border: 1px solid rgba(#999, .2);
  height: 400px;
}
</style>
