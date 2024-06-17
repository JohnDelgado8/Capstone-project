<template>
  <q-page>
    <q-card class="q-px-sm" style="height: 635px; background-color: #f2f2f2;">
      <q-card-section>
        <div class="text-h5 text-bold">Specializations</div>
      </q-card-section>

      <div class="q-px-md">
        <div class="q-pa-md" style="background-color: white; height: 200px;">
          <div class="text-h5">Add Specialization</div>

          <div class="row">
            <div class="col-6">

              <div class="q-mt-md">

                <q-select filled v-model="selectyear" label="Select Year" :options="yearOptions" />

              </div>
            </div>
            <div class="col-6 q-px-sm">

              <div class="q-mt-md">
                <q-input filled v-model="specialization" label="Specialization Name" />
              </div>
              <div class="q-mt-md text-right">
                <q-btn label="Add Specialization" style="background-color: #3b945e; color: #f2f2f2;"
                  @click="saveSpecialization" />
              </div>

            </div>

          </div>
        </div>
      </div>
    </q-card>
  </q-page>
</template>

<script>
import auth from "src/Auth/auth";
import { ref, onMounted } from "vue";
import axios from "axios";
import { Notify } from 'quasar';

export default {
  setup() {
    const specialization = ref('');
    const selectyear = ref('');


    const yearOptions = ["1st", "2nd", "3rd", "4th"];

    const saveSpecialization = async () => {
      try {
        const response = await axios.post(
          "https://forbesscheduling.000webhostapp.com/server/add_specialization.php",
          {
            email: auth.email,
            select_year: selectyear.value,
            specialization_name: specialization.value
          }
        );

        if (response.data.success) {
          Notify.create({
            type: 'positive',
            message: 'Specialization Added Successfully!'
          });
          specialization.value = ''; // Clear the input field after successful save
        } else {
          Notify.create({
            type: 'negative',
            message: 'Failed to add specialization. Please try again.'
          });
        }
      } catch (error) {
        console.error('Error saving specialization:', error);
        Notify.create({
          type: 'negative',
          message: 'An error occurred while saving specialization. Please try again later.'
        });
      }
    };

    return {
      specialization,
      selectyear,

      saveSpecialization,
      yearOptions
    };
  },
  beforeRouteEnter(to, from, next) {
    if (!auth.isLoggedIn) {
      next({ name: "login" });
    } else {
      next();
    }
  }
};
</script>



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
