<template>
  <EditRowLayout
    :colspan="4"
    :error="error"
    @save="save"
    @cancel="emit('cancel')"
  >
    <div>
      <label for="name" class="form-label">Názov</label>
      <input
        type="text"
        class="form-control"
        id="name"
        v-model="name"
        :placeholder="car?.name"
      />
    </div>
    <div>
      <label for="registration-state" class="form-label"
        >Stav registrácie</label
      >
      <select class="form-select" id="registration-state" v-model="state">
        <option v-for="state in states" :value="state">
          {{ state }}
        </option>
      </select>
    </div>
    <div>
      <label for="registration-number" class="form-label"
        >Registračné číslo</label
      >
      <input
        type="text"
        class="form-control"
        id="registration-number"
        v-model="registrationNumber"
        :placeholder="isRegistered() ? car?.registrationNumber : null"
      />
    </div>
  </EditRowLayout>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';

const props = defineProps({
  car: Object,
  query: String,
});

const emit = defineEmits(['save', 'cancel']);

const error = ref(null);

const name = ref(props?.car?.name);

const states = ['Registrované', 'Neregistrované'];
const state = ref(props.car?.isRegistered ? states[0] : states[1]);
function isRegistered() {
  return state.value == states[0];
}

const registrationNumber = ref(props.car?.registrationNumber);

function save() {
  if (!name.value) {
    error.value = 'Názov je povinný údaj';
    return;
  }

  if (isRegistered() && !registrationNumber.value) {
    error.value = 'Registračné číslo je povinný údaj';
    return;
  }

  document.getElementById('save').disabled = true;
  document.getElementById('cancel').disabled = true;

  let body = {
    name: name.value,
    is_registered: isRegistered(),
  };

  if (isRegistered()) {
    body.registration_number = registrationNumber.value;
  }

  (props.car
    ? axios.put(`/api/cars/${props.car.uuid}`, body)
    : axios.post(`/api/cars${props.query}`, body)
  ).then((response) => {
    emit('save', response.data.data);
  });
}

let registrationNumberInput;
onMounted(() => {
  registrationNumberInput = document.getElementById('registration-number');
});

onMounted(updateRegistrationNumberInput);
watch(state, updateRegistrationNumberInput);
function updateRegistrationNumberInput() {
  if (isRegistered()) {
    registrationNumber.value = props.car?.registrationNumber;
    registrationNumberInput.disabled = false;
  } else {
    registrationNumber.value = '';
    registrationNumberInput.disabled = true;
  }
}
</script>
