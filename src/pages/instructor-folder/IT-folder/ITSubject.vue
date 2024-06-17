<template>
  <q-page>
    <q-card class="card-size" v-if="$q.screen.width >= 785">
      <q-card-section>
        <div class="text-h5 q-ml-sm">Information Technology</div>
      </q-card-section>

      <div class="row q-px-xl">
        <div class="col">
          <q-card class="my-card q-mb-lg">
            <div class="q-pa-md">
              <div class="q-gutter-sm row q-pt-sm" style="justify-content: center;">
                <q-select class="input-field q-mb-md select-field" standout="bg-teal text-white" v-model="selectedDay"
                  :options="options_day" label="Select Day" />
                <q-icon name="arrow_right_alt" class="arrow-icon" style="margin-top: 44px; font-size: 32px;"></q-icon>
                <div>
                  <q-form>
                    <label style="margin-top: 0; color: #65CCB8;">
                      From
                      <q-input class="input-time" id="selectedTimeAM" filled cp v-model="selectedTimeAM" mask="time"
                        :rules="['time']">
                        <template v-slot:append>
                          <q-icon name="access_time" class="cursor-pointer">
                            <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                              <q-time v-model="modalTimeAM">
                                <div class="row items-center justify-end">
                                  <q-btn v-close-popup label="OK" color="primary" @click="onOKClick('AM')" flat />
                                  <q-btn v-close-popup label="Close" color="primary" flat />
                                </div>
                              </q-time>
                            </q-popup-proxy>
                          </q-icon>
                        </template>
                      </q-input>
                    </label>
                  </q-form>
                </div>

                <q-btn outline color="white" disable style="height: 40px; margin-top: 38px;">
                  <div class="formatted-time">{{ formattedSelectedTimeAM }}</div>
                </q-btn>
                <q-icon name="navigate_next" class="arrow-icon" style="margin-top: 44px; font-size: 32px;"></q-icon>

                <div>
                  <q-form>
                    <label style="margin-top: 0; color: #65CCB8;">To
                      <q-input class="input-time" id="selectedTimePM" filled cp v-model="selectedTimePM" mask="time"
                        :rules="['time']">
                        <template v-slot:append>
                          <q-icon name="access_time" class="cursor-pointer">
                            <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                              <q-time v-model="modalTimePM">
                                <div class="row items-center justify-end">
                                  <q-btn v-close-popup label="OK" color="primary" @click="onOKClick('PM')" flat />
                                  <q-btn v-close-popup label="Close" color="primary" flat />
                                </div>
                              </q-time>
                            </q-popup-proxy>
                          </q-icon>
                        </template>
                      </q-input>
                    </label>
                  </q-form>
                </div>

                <q-btn class="" outline disable style="height: 40px; margin-top: 38px; color: #f2f2f2;">
                  <div class="formatted-time">{{ formattedSelectedTimePM }}</div>
                </q-btn>


                <!-- Add v-if and v-else to conditionally render "Save" or "Edit" button -->
                <q-btn icon="add" @click="saveAvailability"
                  style="height: 40px; width: 60px; margin-top: 38px; background-color: #3b945e; color: white" />

              </div>
            </div>
          </q-card>

          <div class="q-pa-md" style="background-color: white;">
            <div class="course-caption text-center q-mb-lg">
              Your Availabilities
            </div>
            <q-table card-class="bg-custom-green" flat bordered grid :rows="availabilities" :columns="columns"
              row-key="id" :filter="filter" hide-header>
              <template v-slot:top-right>
                <q-input borderless dense debounce="300" v-model="filter" placeholder="Search"
                  style="background-color: #f2f2f2;" class="q-pl-sm">
                  <template v-slot:append>
                    <q-icon name="search" style="color: #3b945e;" />
                  </template>
                </q-input>
              </template>

              <template v-slot:item-DAY="props">
                <q-td :props="props">
                  <div class="custom-row">
                    <div class="custom-title">{{ props.row.DAY }}
                    </div>
                    <div class="custom-value">{{ props.row.VALUE }}</div>

                  </div>
                </q-td>
              </template>
            </q-table>
          </div>


        </div>
      </div>

    </q-card>

    <!--Tablet-->
    <q-card class="card-size" v-if="$q.screen.width >= 634 && $q.screen.width <= 785">
      <q-card-section>
        <div class="text-h5 q-ml-sm">Information Technology</div>
      </q-card-section>

      <div class="row q-px-xl">
        <div class="col">
          <q-card class="my-card q-mb-lg">
            <div class="q-pa-md">
              <div class="row q-pt-sm row-position">
                <q-select class="input-field q-mb-md select-field" standout="bg-teal text-white" v-model="selectedDay"
                  :options="options_day" label="Select Day" />
                <q-icon name="arrow_right_alt" class="arrow-icon" style="margin-top: 44px; font-size: 32px;"></q-icon>
                <div class="AM-position">
                  <q-form>

                    <label style="margin-top: 0; color: #65CCB8;">From
                      <q-input class="input-time" id="selectedTimeAM" filled cp v-model="selectedTimeAM" mask="time"
                        :rules="['time']">
                        <template v-slot:append>
                          <q-icon name="access_time" class="cursor-pointer">
                            <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                              <q-time v-model="modalTimeAM">
                                <div class="row items-center justify-end">
                                  <q-btn v-close-popup label="OK" color="primary" @click="onOKClick('AM')" flat />
                                  <q-btn v-close-popup label="Close" color="primary" flat />
                                </div>
                              </q-time>
                            </q-popup-proxy>
                          </q-icon>
                        </template>
                      </q-input>
                    </label>
                  </q-form>
                </div>

                <q-btn outline color="white" class="q-ml-sm AM-time" disable>
                  <div class="formatted-time">{{ formattedSelectedTimeAM }}</div>
                </q-btn>
                <q-icon name="navigate_next" class="arrow-icon AM-icon"></q-icon>

                <div>
                  <q-form>
                    <label style="margin-top: 0; color: #65CCB8;">To
                      <q-input class="input-time" id="selectedTimePM" filled cp v-model="selectedTimePM" mask="time"
                        :rules="['time']">
                        <template v-slot:append>
                          <q-icon name="access_time" class="cursor-pointer">
                            <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                              <q-time v-model="modalTimePM">
                                <div class="row items-center justify-end">
                                  <q-btn v-close-popup label="OK" color="primary" @click="onOKClick('PM')" flat />
                                  <q-btn v-close-popup label="Close" color="primary" flat />
                                </div>
                              </q-time>
                            </q-popup-proxy>
                          </q-icon>
                        </template>
                      </q-input>
                    </label>
                  </q-form>
                </div>

                <q-btn class="q-ml-sm" outline disable style="height: 40px; margin-top: 30px; color: #f2f2f2;">
                  <div class="formatted-time">{{ formattedSelectedTimePM }}</div>
                </q-btn>


                <!-- Add v-if and v-else to conditionally render "Save" or "Edit" button -->
                <q-btn icon="add" @click="saveAvailability" class="q-ml-md"
                  style="height: 40px; width: 60px; margin-top: 30px; background-color: #3b945e; color: white" />

              </div>
            </div>
          </q-card>

          <div class="q-pa-md" style="background-color: white;">
            <div class="course-caption text-center q-mb-lg">
              Your Availabilities
            </div>
            <q-table card-class="bg-custom-green" flat bordered grid :rows="availabilities" :columns="columns"
              row-key="id" :filter="filter" hide-header>
              <template v-slot:top-right>
                <q-input borderless dense debounce="300" v-model="filter" placeholder="Search"
                  style="background-color: #f2f2f2;" class="q-pl-sm">
                  <template v-slot:append>
                    <q-icon name="search" style="color: #3b945e;" />
                  </template>
                </q-input>
              </template>

              <template v-slot:item-DAY="props">
                <q-td :props="props">
                  <div class="custom-row">
                    <div class="custom-title">{{ props.row.DAY }}
                    </div>
                    <div class="custom-value">{{ props.row.VALUE }}</div>

                  </div>
                </q-td>
              </template>
            </q-table>
          </div>


        </div>
      </div>

    </q-card>

    <!--Mobile-->
    <q-card class="card-size" v-if="$q.screen.width <= 634">
      <q-card-section>
        <div class="text-h5 q-ml-sm">Information Technology</div>
      </q-card-section>

      <div class="row main-padding">
        <div class="col">
          <q-card class="my-card q-mb-lg">
            <div class="q-pa-md">
              <div class="row q-pt-sm row-position">
                <q-select class="input-field q-mb-md select-field" standout="bg-teal text-white" v-model="selectedDay"
                  :options="options_day" label="Select Day" />


                <q-icon name="keyboard_double_arrow_down" class="arrow-mobile"></q-icon>
                <div class="AM-position">
                  <div class="col-sm-10">
                    <q-form>
                      <label style=" color: #65CCB8;">From

                        <q-input class="mobile-input" id="selectedTimeAM" filled cp v-model="selectedTimeAM" mask="time"
                          :rules="['time']">
                          <template v-slot:append>
                            <q-icon name="access_time" class="cursor-pointer">
                              <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                                <q-time v-model="modalTimeAM">
                                  <div class="row items-center justify-end">
                                    <q-btn v-close-popup label="OK" color="primary" @click="onOKClick('AM')" flat />
                                    <q-btn v-close-popup label="Close" color="primary" flat />
                                  </div>
                                </q-time>
                              </q-popup-proxy>
                            </q-icon>
                          </template>
                        </q-input>
                      </label>
                    </q-form>
                  </div>
                </div>
                <div class="col-sm-2">
                  <q-btn outline color="white" class="q-ml-sm mobile-time" disable>
                    <div class="formatted-time">{{ formattedSelectedTimeAM }}</div>
                  </q-btn>
                </div>

                <q-icon name="keyboard_double_arrow_down" class="arrow-mobile q-mt-md"></q-icon>

                <div>
                  <div class="col-sm-10">
                    <q-form>
                      <label style="margin-top: 0; color: #65CCB8;">To
                        <q-input class="mobile-input" id="selectedTimePM" filled cp v-model="selectedTimePM" mask="time"
                          :rules="['time']">
                          <template v-slot:append>
                            <q-icon name="access_time" class="cursor-pointer">
                              <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                                <q-time v-model="modalTimePM">
                                  <div class="row items-center justify-end">
                                    <q-btn v-close-popup label="OK" color="primary" @click="onOKClick('PM')" flat />
                                    <q-btn v-close-popup label="Close" color="primary" flat />
                                  </div>
                                </q-time>
                              </q-popup-proxy>
                            </q-icon>
                          </template>
                        </q-input>
                      </label>
                    </q-form>
                  </div>
                </div>
                <div class="col-sm-2">
                  <q-btn class="q-ml-sm mobile-time-PM" outline disable>
                    <div class="formatted-time">{{ formattedSelectedTimePM }}</div>
                  </q-btn>
                </div>
                <div class="add-btn" style="width: 100%; text-align: right;">
                  <!-- Add v-if and v-else to conditionally render "Save" or "Edit" button -->
                  <q-btn label="ADD" icon="add" @click="saveAvailability"
                    style="height: 40px; width: 100px; margin-top: 30px; background-color: #3b945e; color: white" />
                </div>
              </div>
            </div>
          </q-card>

          <div class="q-pa-md" style="background-color: white;">
            <div class="course-caption text-center q-mb-lg">
              Your Availabilities
            </div>
            <q-table card-class="bg-custom-green" flat bordered grid :rows="availabilities" :columns="columns"
              row-key="id" :filter="filter" hide-header>
              <template v-slot:top-right>
                <q-input borderless dense debounce="300" v-model="filter" placeholder="Search"
                  style="background-color: #f2f2f2;" class="q-pl-sm">
                  <template v-slot:append>
                    <q-icon name="search" style="color: #3b945e;" />
                  </template>
                </q-input>
              </template>

              <template v-slot:item-DAY="props">
                <q-td :props="props">
                  <div class="custom-row">
                    <div class="custom-title">{{ props.row.DAY }}
                    </div>
                    <div class="custom-value">{{ props.row.VALUE }}</div>

                  </div>
                </q-td>
              </template>
            </q-table>
          </div>


        </div>
      </div>

    </q-card>

  </q-page>
</template>

<script src="pages/instructor-folder/instructor-scripts/instructorsScripts.js"></script>

<style lang="scss" scoped>
@import "pages/instructor-folder/instructor-style/InstructorSubject.scss";
</style>

<style>
.bg-custom-green {
  background-color: #57BA98;
  /* Replace with your desired hex color */
}

.q-table__grid-item-title {
  font-size: 15px;
  font-weight: bold;
  opacity: 1;
  color: #182628;

}

.q-table__grid-item-value {
  font-size: 18px;
  font-weight: 500;
}

.q-table__grid-item-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-left: 30px;
  padding-right: 70px;
}
</style>


