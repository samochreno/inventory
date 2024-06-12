<template>
  <TableLayout>
    <template #title>Autá</template>

    <template #filter>
      <div class="col-12 col-md-6">
        <SearchBar :text="props.search" @text="(t) => (search = t)"></SearchBar>
      </div>
      <div class="col">
        <div class="h-100 d-flex gap-3">
          <select
            id="filter"
            class="form-select"
            aria-label="Zobraziť iba"
            v-model="filter"
          >
            <option v-for="filter in filters" :value="filter.slug">
              {{ filter.name }}
            </option>
          </select>
          <button
            type="button"
            class="h-100 btn btn-primary d-flex gap-1 align-items-center justify-content-center"
            @click="create"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              style="margin-left: -5px"
              fill="currentColor"
              stroke="currentColor"
              stroke-width="0.5"
              class="bi bi-plus"
              viewBox="0 0 16 16"
            >
              <path
                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"
              />
            </svg>
            Pridať auto
          </button>
        </div>
      </div>
    </template>

    <template #table>
      <table class="table">
        <thead :class="{ 'border-0': !cars?.data?.length }">
          <tr>
            <th scope="col">Názov</th>
            <th scope="col">Stav registrácie</th>
            <th scope="col">Registračné číslo</th>
            <th scope="col">
              <Pagination
                :data="cars"
                :limit="1"
                keep-length
                @pagination-change-page="(p) => (page = p)"
              ></Pagination>
            </th>
          </tr>
        </thead>
        <tbody>
          <template v-if="editingUuid == newUuid">
            <EditCarRow
              :car="null"
              :query="query"
              @save="saveEdit"
              @cancel="cancelEdit"
            ></EditCarRow>
          </template>
          <template v-for="car in cars.data">
            <template v-if="car.uuid == editingUuid">
              <EditCarRow
                :car="car"
                @save="saveEdit"
                @cancel="cancelEdit"
              ></EditCarRow>
            </template>
            <template v-else>
              <DisplayCarRow
                :car="car"
                :query="query"
                @edit="edit"
                @delete="selectDeleting"
              ></DisplayCarRow>
            </template>
          </template>
        </tbody>
        <tfoot v-if="cars?.data?.length">
          <tr>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col">
              <Pagination
                :data="cars"
                :limit="1"
                keep-length
                @pagination-change-page="(p) => (page = p)"
              ></Pagination>
            </th>
          </tr>
        </tfoot>
      </table>
    </template>
  </TableLayout>

  <DeleteModal
    :name="deletingCar?.name"
    :item="deletingCar"
    :url="`/api/cars/${deletingCar?.uuid}`"
    @confirm="confirmDelete"
  ></DeleteModal>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue';

const props = defineProps({
  page: Number,
  search: String,
  filter: String,
});

const filters = [
  { slug: 'all', name: 'Všetky' },
  { slug: 'registered', name: 'Registrované' },
  { slug: 'unregistered', name: 'Neregistrované' },
];

const page = ref(props.page);
const search = ref(props.search);
const filter = ref(props.filter ?? filters[0].slug);

watch(page, fetch);
watch(search, () => {
  page.value = 1;
  fetch();
});
watch(filter, () => {
  page.value = 1;
  fetch();
});

const query = computed(() => {
  let params = {};

  if (page.value && page.value != 1) {
    params.page = page.value;
  }
  if (search.value) {
    params.search = search.value;
  }
  if (filter.value && filter.value != filters[0].slug) {
    params.filter = filter.value;
  }

  let query;
  query = new URLSearchParams(params)?.toString();
  query = query ? `?${query}` : '';

  const url = new URL(query, window.location.origin + window.location.pathname);
  window.history.pushState({}, '', url);

  return query;
});

const cars = ref([]);

async function fetch() {
  cars.value = (await axios.get(`/api/cars${query.value}`)).data;
}
onMounted(fetch);

const newUuid = 'new';
const editingUuid = ref(null);

function create() {
  edit(newUuid);
}

function edit(uuid) {
  editingUuid.value = uuid;
}

function cancelEdit() {
  editingUuid.value = null;
}

function saveEdit(car) {
  if (car) {
    const index = cars.value.data.findIndex((c) => c.uuid === car.uuid);
    if (index === -1) {
      cars.value.data.unshift(car);
    } else {
      cars.value.data[index] = car;
    }
  }

  cancelEdit();
}

const deletingCar = ref(null);

function selectDeleting(car) {
  deletingCar.value = car;
}

function confirmDelete() {
  cars.value.data = cars.value.data.filter(
    (c) => c.uuid !== deletingCar.value.uuid,
  );
  deletingCar.value = null;
}
</script>
