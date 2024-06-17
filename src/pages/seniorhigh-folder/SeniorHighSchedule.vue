<template>
  <!--Desktop-->
  <div class="subcontent" style="background-color: #f2f2f2;" v-if="$q.screen.width >= 877">
    <div class="row row-btn">
      <div class="col-12">

        <div class="q-mt-md text-h5 text-bold">Schedule</div>
      </div>
    </div>
    <div class="row q-px-xl">
      <div class="col-10" style="align-self: center;">
        <div class="row">

          <q-select v-model="selectedSchoolYear" :options="schoolYearOptions" class="q-ml-lg" label="School Yr." filled
            dense clearable style="min-width: 120px;">
          </q-select>


          <div class="q-mx-sm text-center" style="width: 10px; padding-top: 8px;">
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
                    <q-btn padding="none" type="submit" icon="add" color="primary" />
                  </div>
                </q-form>
              </q-card-section>
            </q-card>
          </q-dialog>

          <q-select v-model="semesterModel" :options="semesterOptions" class=" q-ml-lg" label="Semester" filled dense
            clearable style="min-width: 110px;">
          </q-select>
          <q-select v-model="selectedYearLevel" :options="selectYear" class=" q-ml-sm" label="Year" filled dense
            clearable style="min-width: 80px;">
          </q-select>
          <q-select v-model="courseModel" :options="courseOptions" label="Course" filled dense clearable
            style="min-width: 120px;" class="q-ml-sm">
          </q-select>
          <div class="q-px-sm row">
            <div class="col-6">
              <q-select v-model="selectedBlocks" :options="filteredBlock" class="q-pr-sm" label="Block" filled dense
                clearable style="min-width: 140px;"></q-select>
            </div>
            <div class="col-6 text-center" style="width: 80px; padding-left: 8px;">
              <div style="height: 100%;">
                <!-- Render the delete button only when a block is selected -->
                <q-btn v-if="formData.block" icon="delete_outline" @click="deleteBlock" color="red" flat
                  style="padding-right: 0; padding-left: 0; margin-top: 3px;">
                </q-btn>
                <q-btn v-else style="margin-top: 8px;" class="add-block" padding="none" color="primary" icon="add"
                  @click="showBlockDialog = true">
                </q-btn>
              </div>
            </div>

            <q-dialog v-model="showBlockDialog" persistent>
              <q-card>
                <q-card-section class="row items-center">
                  <q-form @submit="addNewBlock">
                    <q-input class="q-mb-sm" v-model="newBlockName" label="Block Name" outlined dense />
                    <div class="row justify-center mt-5">
                      <q-btn class="q-px-sm" padding="none" icon="close" color="negative"
                        @click="showBlockDialog = false" />
                      <q-btn padding="none" type="submit" icon="add" color="primary" :disable="!newBlockName" />
                    </div>
                  </q-form>
                </q-card-section>
              </q-card>
            </q-dialog>
          </div>


        </div>
      </div>
      <div class="col-2 text-right q-pr-lg">
        <!-- <q-btn @click="exportPdf" color="white" text-color="black" label="Export Calendar" /> -->
        <q-btn class="q-mt-lg q-mb-md add-btn" label="Add Schedule" icon="add" @click="showDialog = true" />
      </div>
    </div>
    <q-dialog v-model="showDialog">
      <q-card>
        <!-- Form for adding new event -->
        <q-form @submit="submitForm" style=" height: 450px;" class="q-py-lg">
          <div class="row">
            <div class="col-6 q-pl-md q-pr-sm ">
              <q-select class="q-mb-md" v-model="formData.subjectname" label="Subject Name" outlined
                :options="availableSubjects.map(subject => ({ label: subject, value: subject }))" />

            </div>
            <div class="col-6 q-pr-sm">
              <q-select v-model="formData.instructor" :options="instructors" label="Instructor" outlined />
            </div>
            <div class="col-6 q-pl-md q-pr-sm q-mb-md">
              <q-select v-model="formData.day" :options="availabilityDays" label="Availability Day" outlined />
              <q-badge class="q-mt-sm"
                v-if="showAvailabilityBadge && formData.instructor && availabilityDays.length > 0"
                style=" cursor: pointer;" outline color="secondary" @click="selectAvailabilityDayFromBadge">
                Available Day: {{ availabilityDays[0].label }}
              </q-badge>
            </div>

            <div class="col-6 q-pr-sm">
              <q-input label="Time From" outlined v-model="formData.time_from" mask="time">
                <template v-slot:append>
                  <q-icon name="access_time" class="cursor-pointer">
                    <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                      <q-time v-model="formData.time_from">
                        <div class="row items-center justify-end">
                          <q-btn v-close-popup label="Okay" color="primary" flat />
                        </div>
                      </q-time>
                    </q-popup-proxy>
                  </q-icon>
                </template>
              </q-input>
            </div>
            <div class="col-6 q-pl-md q-pr-sm">
              <q-input class="q-mb-md" label="Time to" outlined v-model="formData.time_to" mask="time">

                <template v-slot:append>
                  <q-icon name="access_time" class="cursor-pointer">
                    <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                      <q-time v-model="formData.time_to">
                        <div class="row items-center justify-end">
                          <q-btn v-close-popup label="Close" color="primary" flat />
                        </div>
                      </q-time>
                    </q-popup-proxy>
                  </q-icon>
                </template>
              </q-input>
            </div>
            <div class="col-6 q-pr-sm ">
              <q-select class="q-mb-md" v-model="buildingModel" :options="buildingOptions" label="Building" outlined />
            </div>

            <div class="col-6 q-pl-md q-pr-sm">
              <q-select class="q-mb-md" v-model="formData.type" :options="selectType" label="Type of Room" outlined
                :disable="!buildingModel" />
            </div>
            <div class="col-6 q-pr-sm">
              <q-select class="q-mb-md" outlined v-model="formData.room" :options="selectRoom" label="Room" />
              <q-badge class="q-ml-sm" v-if="showRoomBadge && formData.type && selectRoom.length > 0"
                style="margin-bottom: 20px; cursor: pointer;" outline color="secondary" @click="selectRoomFromBadge">
                Available Room: {{ selectRoom[0] }}
              </q-badge>

            </div>


            <div class="col-6 q-pl-md q-pr-sm">
              <q-input class="q-mb-md" v-model="formData.course" readonly label="Course" outlined />
            </div>

            <div class="col-3 q-pr-sm">
              <q-input readonly v-model="formData.school_year" label="School Yr" outlined />

            </div>
            <div class="col-3 q-pr-sm ">
              <q-input readonly v-model="formData.semester" :options="semesterOptions" label="Semester" outlined />

            </div>


            <div class="col-2 q-pl-md q-pr-sm ">
              <q-input class="q-mb-md" v-model="formData.block" readonly label="Block" outlined />
            </div>
            <div class="col-2 q-pr-sm">
              <q-input class="q-mb-md" v-model="formData.year" readonly label="Year" outlined />
            </div>
            <div class="col-2 q-pr-sm">
              <q-input class="q-mb-md" v-model="formData.units" label="Units" outlined readonly />
            </div>

            <div class="col-6 q-mt-sm q-pr-sm " style="text-align-last: center;">
              <q-btn class="q-mr-sm text-bold" label="Cancel" @click="showDialog = false"
                style="color: #182628; background-color: goldenrod; " />

              <!-- Submit button with :disabled attribute -->
              <q-btn :disabled="isFormInvalid" type="submit" label="Add"
                style="background-color: #3B945E; color: #f2f2f2" />

            </div>
          </div>

        </q-form>

      </q-card>
    </q-dialog>
    <div ref="pdf">
      <!-- <div class="row q-px-xl">
        <div class="col q-px-xl" style="text-align: -webkit-center;">
          <q-badge v-if="modelSingle" style="height: 30px; width: 100px; background-color: #3B945E;" class="q-mb-sm">
            <div style="width: 100%; font-size: 20px;">{{ modelSingle.name }}</div>
          </q-badge>
        </div>
      </div> -->

      <div class="row justify-center">

        <div class="calendar-table">
          <q-dialog v-model="showEventDialog">
            <q-card>
              <q-card-section>
                <!-- Display event details inside the dialog -->
                <div class="text-h6">{{ selectedEvent.title }}</div>

                <!-- Show input fields only when editing is enabled -->
                <template v-if="isEditing">
                  <q-input v-model="selectedEvent.instructor" label="Instructor" />
                  <q-input v-model="selectedEvent.block" label="Block" />
                  <!-- Make sure year and subjectname have default values or are properly set -->
                  <q-input v-model="selectedEvent.year" label="Year" />
                  <q-input v-model="selectedEvent.type" label="Type of Room" />
                  <q-input v-model="selectedEvent.room" label="Room" />

                  <q-input v-model="selectedEvent.time_from" label="From" />
                  <q-input v-model="selectedEvent.time_to" label="To" />
                </template>
              </q-card-section>
              <q-card-actions align="right">
                <!-- Show different buttons based on editing state -->
                <q-btn v-if="!isEditing" label="Edit" color="primary" @click="enableEditing" />
                <q-btn v-else label="Save" color="primary" @click="saveEvent" />
                <q-btn label="Delete" color="negative" @click="deleteEvent" />
                <q-btn label="Close" @click="closeEventDialog" />
              </q-card-actions>
            </q-card>
          </q-dialog>



          <q-calendar-resource ref="calendar" v-model="selectedDate" v-model:model-resources="resources"
            resource-key="id" resource-label="name" :interval-start="6" :interval-count="13" animated bordered
            :resource-width="resourceWidth" :resource-height="resourceHeight" :cell-width="cellWidth" @change="onChange"
            @moved="onMoved" @resource-expanded="onResourceExpanded" @click-date="onClickDate" @click-time="onClickTime"
            @click-resource="onClickResource" @click-head-resources="onClickHeadResources"
            @click-interval="onClickInterval">

            <template #resource-intervals="{ scope }">
              <template v-for="(event, index) in getEvents(scope)" :key="index">
                <q-badge @click="openEventDialog(event)" filled color="primary" :label="event.title"
                  :style="getStyle(event, index, scope)" />
              </template>
            </template>

          </q-calendar-resource>
        </div>
      </div>
    </div>
  </div>




</template>

<script src="../programhead-folder/programhead-scripts/ProgramHeadSchdeule">
</script>



<style lang="scss" scoped>
@import "pages/programhead-folder/programhead-style/Schedule-Page.scss";

.select-size {
  width: 120px;
}
</style>
