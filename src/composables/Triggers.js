import { ref } from "vue";

let DialogState = ref(false);
let LeftDrawerState = ref(false);
let FilterDialogState = ref(false);
let MenuBtnState = ref(false);
let SearchBtnState = ref(true);
let ActiveModule = ref(null);
let AddExamScheduleState = ref(false);
let UpdateExamScheduleState = ref(false);
let UpdateExamScheduleId = ref(null);
let ImportFileState = ref(false);
let DeleteExamScheduleState = ref(false);
let DeleteExamScheduleId = ref(null);

const ToggleMainDialogState = () => {
  DialogState.value = !DialogState.value;
};

const ToggleLeftDrawer = () => {
  LeftDrawerState.value = !LeftDrawerState.value;
};

const ToggleFilterDialogState = () => {
  FilterDialogState.value = !FilterDialogState.value;
};

const ToggleMenuBtnState = () => {
  MenuBtnState.value = !MenuBtnState.value;
};

const ToggleSearchBtnState = (value) => {
  SearchBtnState.value = value;
};

const ToggleAddExamSchedule = () => {
  AddExamScheduleState.value = !AddExamScheduleState.value;
};

const ToggleUpdateExamSchedule = (id) => {
  UpdateExamScheduleState.value = !UpdateExamScheduleState.value;

  if (UpdateExamScheduleState.value) UpdateExamScheduleId.value = id;
};

const ToggleImportFile = () => {
  ImportFileState.value = !ImportFileState.value;
};

const ToggleDeleteExamSchedule = (id) => {
  DeleteExamScheduleState.value = !DeleteExamScheduleState.value;

  if (DeleteExamScheduleState.value) DeleteExamScheduleId.value = id;
};
/**
 * Export  DialogState as readonly (real time copy of Dialog)
 */
export {
  ActiveModule,
  AddExamScheduleState,
  DeleteExamScheduleId,
  DeleteExamScheduleState,
  DialogState,
  FilterDialogState,
  ImportFileState,
  LeftDrawerState,
  MenuBtnState,
  SearchBtnState,
  ToggleAddExamSchedule,
  ToggleDeleteExamSchedule,
  ToggleFilterDialogState,
  ToggleImportFile,
  ToggleLeftDrawer,
  ToggleMainDialogState,
  ToggleMenuBtnState,
  ToggleSearchBtnState,
  ToggleUpdateExamSchedule,
  UpdateExamScheduleId,
  UpdateExamScheduleState,
};
