<template>
  <q-page>
    <q-card style="height: 700px; background-color: #F2F2F2;" v-if="$q.screen.width >= 445">


      <q-card-section>
        <div class="text-h5 q-ml-sm text-bold">Account</div>
      </q-card-section>


      <div class="search-field q-px-md">
        <q-select v-model="selectedPosition" label="Filter by Position" filled dense clearable style="min-width: 200px;"
          :options="positions">
        </q-select>


        <q-btn class="add-button" outline icon-right="add" to="/admin/register">
          <span class="q-mr-sm add-caption">New User</span>
        </q-btn>
      </div>

      <div class="q-pa-md">
        <q-table :rows="tableData" :columns="columns" row-key="id">


          <template v-slot:body-cell-status="props">
            <q-td :props="props">
              <q-chip style="margin-left: -12px;" :class="{ 'inactive-label': props.row.status !== 'active' }"
                :color="props.row.status === 'active' ? 'positive' : 'negative'"
                :label="props.row.status === 'active' ? 'Active' : 'Inactive'" />
            </q-td>
          </template>

          <template v-slot:body-cell-action="props">
            <q-td :props="props">
              <q-btn flat dropdown icon="more_vert" style="margin-left: -12px;">
                <q-menu>
                  <q-list>
                    <q-item clickable @click="toggleStatus(props.row.id, 'inactive', props)">
                      <q-item-section>Activate</q-item-section>
                    </q-item>
                    <q-item clickable @click="toggleStatus(props.row.id, 'active', props)">
                      <q-item-section>Deactivate</q-item-section>
                    </q-item>
                    <q-item clickable @click="redirectToEditPage(props.row.id)">
                      <q-item-section>Edit</q-item-section>
                    </q-item>

                  </q-list>
                </q-menu>
              </q-btn>

            </q-td>
          </template>
        </q-table>
      </div>
    </q-card>
    <q-card style="height: 700px; background-color: #F2F2F2;" v-if="$q.screen.width <= 445">


      <q-card-section>
        <div class="text-h5 q-ml-sm">Account</div>
      </q-card-section>


      <div class="search-field q-px-md">
        <q-input v-model="searchQuery" label="Search by Email" dense filled clearable @clear="clearSearch"
          style="width: 200px;" />
        <q-btn class="search-button" icon="search" @click="searchByEmail" />
        <q-btn class="add-button" outline icon-right="add" to="/admin/register">
        </q-btn>
      </div>

      <div class="q-pa-md">
        <q-table :rows="tableData" :columns="columns" row-key="id">


          <template v-slot:body-cell-status="props">
            <q-td :props="props">
              <q-chip style="margin-left: -12px;" :class="{ 'inactive-label': props.row.status !== 'active' }"
                :color="props.row.status === 'active' ? 'positive' : 'negative'"
                :label="props.row.status === 'active' ? 'Active' : 'Inactive'" />
            </q-td>
          </template>

          <template v-slot:body-cell-action="props">
            <q-td :props="props">
              <q-btn flat dropdown icon="more_vert" style="margin-left: -12px;">
                <q-menu>
                  <q-list>
                    <q-item clickable @click="toggleStatus(props.row.id, 'inactive', props)">
                      <q-item-section>Activate</q-item-section>
                    </q-item>
                    <q-item clickable @click="toggleStatus(props.row.id, 'active', props)">
                      <q-item-section>Deactivate</q-item-section>
                    </q-item>
                    <q-item clickable @click="redirectToEditPage(props.row.id)">
                      <q-item-section>Edit</q-item-section>
                    </q-item>
                  </q-list>
                </q-menu>
              </q-btn>

            </q-td>
          </template>
        </q-table>
      </div>
    </q-card>
  </q-page>
</template>

<script src="src/pages/admin-folder/admin-scripts/Account.js"></script>

<style lang="scss" scoped>
@import "pages/admin-folder/admin-style/Account.scss";
</style>
