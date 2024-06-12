<template>
  <tr>
    <td
      id="edit"
      :colspan="colspan"
      style="
        background-color: var(--bs-gray-300);
        --bs-border-color: var(--bs-gray-500);
      "
      class="p-4"
    >
      <div class="container-fluid g-0">
        <div class="row">
          <div class="col">
            <div class="row-edit d-flex flex-column flex-md-row gap-3">
              <slot></slot>
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col">
            <div class="d-flex flex-row-reverse gap-3 flex-md-row">
              <span
                style="white-space: break-spaces"
                class="flex-grow-1 align-self-center text-danger"
              >
                {{ error }}
              </span>
              <div
                class="flex-grow-0 align-self-end col d-flex gap-2 flex-md-row-reverse"
              >
                <button
                  id="save"
                  type="button"
                  @click="emit('save')"
                  class="align-self-end btn btn-primary"
                >
                  Uložiť
                </button>
                <button
                  id="cancel"
                  type="button"
                  @click="emit('cancel')"
                  class="align-self-end btn btn-secondary"
                >
                  Zrušiť
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </td>
  </tr>
</template>

<script setup>
const props = defineProps({
  colspan: Number,
  error: String,
});

const emit = defineEmits(['save', 'cancel']);
</script>
