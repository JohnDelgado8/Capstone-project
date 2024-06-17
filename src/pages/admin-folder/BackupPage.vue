<template>
  <q-page>
    <!--Desktop-->
    <q-card style="height: 700px; background-color: #F2F2F2;" v-if="$q.screen.width >= 820">
      <q-card-section>
        <div class="text-h5 q-ml-sm text-bold">Backup & Restore</div>
      </q-card-section>
      <div class="row q-pa-md example-row-equal-width q-px-xl">
        <div class="col q-px-sm">
          <q-card style="background: white; ">
            <q-card-section>
              <div class="row">
                <div class="col text-center">
                  <q-avatar size="80px" font-size="52px" class="custom-avatar" icon="restore" />
                  <div class="text-h6" style="color: black">Restore Data</div>
                  <div class="text-subtitle2" style="color: black">Select file to restore your data</div>
                </div>
              </div>
            </q-card-section>

            <q-card-section class="q-pt-none text-center">
              <q-btn label="Select File" @click="triggerFileInput" style="color: #3b945e; font-weight: bold;" />

            </q-card-section>
          </q-card>
        </div>
        <div class="col q-px-sm">
          <q-card class="bg-white" style="">
            <q-card-section>
              <div class="row">
                <div class="col text-center">
                  <q-avatar size="80px" font-size="52px" class="custom-avatar" icon="send_and_archive" />
                  <div class="text-h6" style="color: black">Email Backup</div>
                  <div class="text-subtitle2" style="color: black">Send your backup to your email</div>
                </div>
              </div>
            </q-card-section>
            <q-card-section class="q-pt-none text-center">
              <q-btn label="Send to Email" style="color: #3b945e; font-weight: bold;" @click="backuptoEmail" />
            </q-card-section>
          </q-card>
        </div>

        <div class="col q-px-sm">
          <q-card class="bg-white" style="">
            <q-card-section>
              <div class="row">
                <div class="col text-center">
                  <q-avatar size="80px" font-size="52px" class="custom-avatar" icon="folder_copy" />
                  <div class="text-h6" style="color: black">File Backup</div>
                  <div class="text-subtitle2" style="color: black">Download your database backups</div>
                </div>
              </div>
            </q-card-section>
            <q-card-section class="q-pt-none text-center">
              <q-btn class="q-mr-sm" style="color: #3b945e; font-weight: bold;" label="Download File"
                @click="backupLocal" />
            </q-card-section>
          </q-card>
        </div>

      </div>

      <q-card class="q-mx-xl" style="background-color: white; height: 220px;">
        <q-card-section class="q-px-lg" style="border-bottom: 2px solid; border-color: #F2F2F2;">

          <div class="text-subtitle2" style="font-weight: bold;">Upload backup data</div>
        </q-card-section>

        <q-card-section>
          <q-input label="Upload a file" filled class="q-pt-md q-px-sm" v-model="sqlFileName" />
          <input ref="fileInput" type="file" id="sql_file" style="display: none" @change="handleFileUpload" />
        </q-card-section>

        <q-btn class="q-ml-lg q-mx-sm" v-if="sqlFileName" style="color: #3b945e; font-weight: bold;" label="UPLOAD"
          @click="uploadFile" />

      </q-card>

    </q-card>

    <!--Tablet-->
    <q-card style="height: 840px; background-color: #F2F2F2;" v-if="$q.screen.width >= 440 && $q.screen.width <= 820">
      <q-card-section>
        <div class="text-h5 q-ml-sm text-bold">Backup & Restore</div>
      </q-card-section>
      <div class="row q-pa-md example-row-equal-width q-px-xl">
        <div class="col-6 q-px-sm">
          <q-card style="background: white; ">
            <q-card-section>
              <div class="row">
                <div class="col text-center">
                  <q-avatar size="80px" font-size="52px" class="custom-avatar" icon="restore" />
                  <div class="text-h6" style="color: black">Restore Data</div>
                  <div class="text-subtitle2" style="color: black">Select file to restore your data</div>
                </div>
              </div>
            </q-card-section>

            <q-card-section class="q-pt-none text-center">
              <q-btn label="Select File" @click="triggerFileInput" style="color: #3b945e; font-weight: bold;" />

            </q-card-section>
          </q-card>
        </div>
        <div class="col-6 q-px-sm">
          <q-card class="bg-white" style="">
            <q-card-section>
              <div class="row">
                <div class="col text-center">
                  <q-avatar size="80px" font-size="52px" class="custom-avatar" icon="send_and_archive" />
                  <div class="text-h6" style="color: black">Email Backup</div>
                  <div class="text-subtitle2" style="color: black">Send your backup to your email</div>
                </div>
              </div>
            </q-card-section>
            <q-card-section class="q-pt-none text-center">
              <q-btn label="Send to Email" style="color: #3b945e; font-weight: bold;" @click="backuptoEmail" />
            </q-card-section>
          </q-card>
        </div>

        <div class="col-6 q-px-sm q-mt-md">
          <q-card class="bg-white" style="">
            <q-card-section>
              <div class="row">
                <div class="col text-center">
                  <q-avatar size="80px" font-size="52px" class="custom-avatar" icon="folder_copy" />
                  <div class="text-h6" style="color: black">File Backup</div>
                  <div class="text-subtitle2" style="color: black">Download your database backups</div>
                </div>
              </div>
            </q-card-section>
            <q-card-section class="q-pt-none text-center">
              <q-btn class="q-mr-sm" style="color: #3b945e; font-weight: bold;" label="Download File"
                @click="backupLocal" />
            </q-card-section>
          </q-card>
        </div>

      </div>



      <q-card class="q-mx-xl" style="background-color: white; height: 220px;">
        <q-card-section class="q-px-lg" style="border-bottom: 2px solid; border-color: #F2F2F2;">

          <div class="text-subtitle2" style="font-weight: bold;">Upload backup data</div>
        </q-card-section>

        <q-card-section>
          <q-input label="Upload a file" filled class="q-pt-md q-px-sm" v-model="sqlFileName" />
          <input ref="fileInput" type="file" id="sql_file" style="display: none" @change="handleFileUpload" />
        </q-card-section>
        <q-btn style="color: #3b945e; font-weight: bold;" class="q-ml-lg" label="Select File"
          @click="triggerFileInput" />
        <q-btn class="q-mx-sm" v-if="sqlFileName" style="color: #3b945e; font-weight: bold;" label="UPLOAD"
          @click="uploadFile" />

      </q-card>

    </q-card>

    <!--Mobile-->
    <q-card style="height: 1040px; background-color: #F2F2F2;" v-if="$q.screen.width <= 440">
      <q-card-section>
        <div class="text-h5 q-ml-sm text-bold">Backup & Restore</div>
      </q-card-section>
      <div class="row q-pa-md example-row-equal-width q-px-xl">
        <div class="col-12 q-px-sm q-mb-md">
          <q-card style="background: white; ">
            <q-card-section>
              <div class="row">
                <div class="col text-center">
                  <q-avatar size="80px" font-size="52px" class="custom-avatar" icon="restore" />
                  <div class="text-h6" style="color: black">Restore Data</div>
                  <div class="text-subtitle2" style="color: black">Select file to restore your data</div>
                </div>
              </div>
            </q-card-section>

            <q-card-section class="q-pt-none text-center">
              <q-btn label="Select File" @click="triggerFileInput" style="color: #3b945e; font-weight: bold;" />

            </q-card-section>
          </q-card>
        </div>
        <div class="col-12 q-px-sm">
          <q-card class="bg-white" style="">
            <q-card-section>
              <div class="row">
                <div class="col text-center">
                  <q-avatar size="80px" font-size="52px" class="custom-avatar" icon="send_and_archive" />
                  <div class="text-h6" style="color: black">Email Backup</div>
                  <div class="text-subtitle2" style="color: black">Send your backup to your email</div>
                </div>
              </div>
            </q-card-section>
            <q-card-section class="q-pt-none text-center">
              <q-btn label="Send to Email" style="color: #3b945e; font-weight: bold;" @click="backuptoEmail" />
            </q-card-section>
          </q-card>
        </div>

        <div class="col-12 q-px-sm q-mt-md">
          <q-card class="bg-white" style="">
            <q-card-section>
              <div class="row">
                <div class="col text-center">
                  <q-avatar size="80px" font-size="52px" class="custom-avatar" icon="folder_copy" />
                  <div class="text-h6" style="color: black">File Backup</div>
                  <div class="text-subtitle2" style="color: black">Download your database backups</div>
                </div>
              </div>
            </q-card-section>
            <q-card-section class="q-pt-none text-center">
              <q-btn class="q-mr-sm" style="color: #3b945e; font-weight: bold;" label="Download File"
                @click="backupLocal" />
            </q-card-section>
          </q-card>
        </div>

      </div>



      <q-card class="q-mx-xl" style="background-color: white; height: 220px;">
        <q-card-section class="q-px-lg" style="border-bottom: 2px solid; border-color: #F2F2F2;">

          <div class="text-subtitle2" style="font-weight: bold;">Upload backup data</div>
        </q-card-section>

        <q-card-section>
          <q-input label="Upload a file" filled class="q-pt-md q-px-sm" v-model="sqlFileName" />
          <input ref="fileInput" type="file" id="sql_file" style="display: none" @change="handleFileUpload" />
        </q-card-section>
        <q-btn style="color: #3b945e; font-weight: bold;" class="q-ml-lg" label="Select File"
          @click="triggerFileInput" />
        <q-btn class="q-mx-sm" v-if="sqlFileName" style="color: #3b945e; font-weight: bold;" label="UPLOAD"
          @click="uploadFile" />

      </q-card>

    </q-card>
  </q-page>
</template>

<script>
import axios from 'axios';
import { useQuasar } from 'quasar';
import auth from "src/Auth/auth";
import { Notify } from "quasar";


export default {
  setup() {
    const $q = useQuasar();
  },
  data() {
    return {
      sqlFileName: '',

    }
  },
  mounted() {

  },
  methods: {
    backuptoEmail() {
      console.log("Clicked");
      const formData = new FormData();
      formData.append('email', auth.email);
      console.log('EMAIL', auth.email);
      axios.post('https://forbesscheduling.000webhostapp.com/server/Backup_Email.php/', formData)
        .then(response => {
          Notify.create({
            type: "positive",
            message: "Email Sent!",
          });
        }).catch(error => {
          console.error('Error fetching data:', error);
        });
    },
    backupLocal() {
      console.log('CLICKED')
      axios.post('https://forbesscheduling.000webhostapp.com/server/backup.php')
        .then(response => {
          const content = response.data.content.substring(response.data.content.indexOf('content":"') + 100);
          const url = window.URL.createObjectURL(new Blob([content]));

          // Construct filename in Month-Day-Year format
          const currentDate = new Date();
          const month = String(currentDate.getMonth() + 1).padStart(2, '0');
          const day = String(currentDate.getDate()).padStart(2, '0');
          const year = currentDate.getFullYear();
          const filename = `backup_${month}-${day}-${year}.sql`;

          const link = document.createElement('a');
          link.href = url;
          link.setAttribute('download', filename); // Set the filename
          document.body.appendChild(link);
          link.click();

          Notify.create({
            type: "positive",
            message: "Backup downloaded successfully!",
          });

        }).catch(error => {
          console.error('Error fetching data:', error);
        });
    },


    // RESTORE SECTION
    triggerFileInput() {
      this.$refs.fileInput.click();
    },
    handleFileUpload(event) {
      const file = event.target.files[0];

      if (file && file.name.endsWith('.sql')) {
        this.sqlFileName = file.name;
        Notify.create({
          type: "positive",
          message: "Selected file successfully!",
        });
      } else {
        Notify.create({
          type: "warning",
          message: "Unsupported File!",
        });
      }
    },
    // uploadFile() {
    //   console.log("File uploaded successfully");
    // },
    uploadFile() {
      if (!this.sqlFileName) {
        return;
      }

      const formData = new FormData();
      formData.append('sql_file', this.$refs.fileInput.files[0]);

      axios.post('https://forbesscheduling.000webhostapp.com/server/Restore.php', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
        .then(response => {
          console.log(response.data);

          // Clear the input field after successful upload
          this.sqlFileName = '';

          // Add notification for successful upload
          Notify.create({
            type: "positive",
            message: "File uploaded successfully!",
          });
        })
        .catch(error => {
          console.error('Error restoring SQL:', error);
          // Add notification for upload error
          Notify.create({
            type: "negative",
            message: "Error uploading file!",
          });
        });
    },

  },
}
</script>

<style lang="scss" scoped>
@import "pages/styles/Dashboard.scss";

.custom-avatar {
  background-color: #f2f2f2;
  color: #3b945e;
}
</style>
