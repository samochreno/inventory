<template>
  <div
    class="modal fade"
    id="delete-modal"
    tabindex="-1"
    aria-labelledby="delete-modal-label"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="delete-modal-label">
            <span class="text-danger">Odstrániť </span>
            <span class="fst-italic">{{ name }}</span>
          </h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Zavrieť"
          ></button>
        </div>
        <div class="modal-body">
          Naozaj chcete <span class="text-danger">odstrániť </span>
          <span class="fst-italic">{{ name }}</span
          >?
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            Zrušiť
          </button>
          <button type="button" class="btn btn-danger" @click="confirm">
            Odstrániť
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { Modal } from 'bootstrap';

const props = defineProps({
  name: String,
  item: Object,
  url: String,
});

const emit = defineEmits(['confirm']);

let deleteModal;
onMounted(() => {
  deleteModal = new Modal(document.getElementById('delete-modal'));
});

function confirm() {
  axios.delete(props.url).then(() => {
    emit('confirm', props.item);
    deleteModal.hide();
  });
}
</script>
