<template>
  <TableLayout>
    <template #title>Diely</template>

    <template #filter>
      <div class="d-flex gap-3">
        <div class="flex-grow-1">
          <SearchBar
            :text="props.search"
            @text="(t) => (search = t)"
          ></SearchBar>
        </div>
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
          Pridať diel
        </button>
      </div>
    </template>

    <template #table>
      <table class="table">
        <thead :class="{ 'border-0': !parts?.data?.length }">
          <tr>
            <th scope="col">Názov</th>
            <th scope="col">Sériové číslo</th>
            <th scope="col">Auto</th>
            <th scope="col">
              <Pagination
                :data="parts"
                :limit="1"
                keep-length
                @pagination-change-page="(p) => (page = p)"
              ></Pagination>
            </th>
          </tr>
        </thead>
        <tbody>
          <template v-if="editingUuid == newUuid">
            <EditPartRow
              :part="null"
              :query="query"
              @save="saveEdit"
              @cancel="cancelEdit"
            ></EditPartRow>
          </template>
          <template v-for="part in parts.data">
            <template v-if="part.uuid == editingUuid">
              <EditPartRow
                :part="part"
                @save="saveEdit"
                @cancel="cancelEdit"
              ></EditPartRow>
            </template>
            <template v-else>
              <DisplayPartRow
                :part="part"
                :query="query"
                @edit="edit"
                @delete="selectDeleting"
              ></DisplayPartRow>
            </template>
          </template>
        </tbody>
        <tfoot v-if="parts?.data?.length">
          <tr>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col">
              <Pagination
                :data="parts"
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
    :name="deletingPart?.name"
    :item="deletingPart"
    :url="`/api/parts/${deletingPart?.uuid}`"
    @confirm="confirmDelete"
  ></DeleteModal>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue';

const props = defineProps({
  page: Number,
  search: String,
});

const page = ref(props.page);
const search = ref(props.search);

watch(page, fetch);
watch(search, () => {
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

  let query;
  query = new URLSearchParams(params)?.toString();
  query = query ? `?${query}` : '';

  const url = new URL(query, window.location.origin + window.location.pathname);
  window.history.pushState({}, '', url);

  return query;
});

const parts = ref([]);

async function fetch() {
  console.log(query.value);
  parts.value = (await axios.get(`/api/parts${query.value}`)).data;
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

function saveEdit(part) {
  if (part) {
    const index = parts.value.data.findIndex((p) => p.uuid === part.uuid);
    if (index === -1) {
      parts.value.data.unshift(part);
    } else {
      parts.value.data[index] = part;
    }
  }

  cancelEdit();
}

const deletingPart = ref(null);

function selectDeleting(part) {
  deletingPart.value = part;
}

function confirmDelete() {
  parts.value.data = parts.value.data.filter(
    (c) => c.uuid !== deletingPart.value.uuid,
  );
  deletingPart.value = null;
}
</script>
