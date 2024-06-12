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
        :placeholder="part?.name"
      />
    </div>
    <div>
      <label for="serialnumber" class="form-label">Sériové číslo</label>
      <input
        type="text"
        class="form-control"
        id="serialnumber"
        v-model="serialnumber"
        :placeholder="part?.serialnumber"
      />
    </div>
    <div class="position-relative">
      <label for="car" class="form-label">Auto</label>
      <input
        type="text"
        class="form-control autocomplete"
        id="car-uuid"
        name="car_uuid"
        @change="changeCar"
        :placeholder="part?.car.name"
        data-server="/api/cars/search"
        data-query-param="q"
        data-live-server="true"
        data-full-width="true"
        data-hidden-input="true"
      />
    </div>
  </EditRowLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import Autocomplete from 'bootstrap5-autocomplete';

const props = defineProps({
  part: Object,
  query: String,
});

const emit = defineEmits(['save', 'cancel']);

const error = ref(null);

onMounted(() => {
  Autocomplete.init();
});

const name = ref(props.part?.name);
const serialnumber = ref(props.part?.serialnumber);
const carUuid = ref(props?.part?.car.uuid);

function changeCar(e) {
  carUuid.value = e.target.parentNode.querySelector(
    'input[name="car_uuid"]',
  ).value;
}

function save() {
  if (!name.value) {
    error.value = 'Názov je povinný údaj';
    return;
  }

  if (!serialnumber.value) {
    error.value = 'Sériové číslo je povinný údaj';
    return;
  }

  if (!carUuid.value) {
    error.value = 'Auto je povinný údaj';
    return;
  }

  document.getElementById('save').disabled = true;
  document.getElementById('cancel').disabled = true;

  const body = {
    name: name.value,
    serialnumber: serialnumber.value,
    car_uuid: carUuid.value,
  };

  (props.part
    ? axios.put(`/api/parts/${props.part.uuid}`, body)
    : axios.post(`/api/parts${props.query}`, body)
  ).then((response) => {
    emit('save', response.data.data);
  });
}
</script>
