<template>
  <DisplayRowLayout>
    <td>{{ car.name }}</td>
    <td>
      <span
        v-if="car.isRegistered"
        class="badge rounded bg-success-subtle text-success border border-success-subtle"
      >
        Registrované
      </span>
      <span
        v-else
        class="badge rounded bg-danger-subtle text-danger border border-danger-subtle"
      >
        Neregistrované
      </span>
    </td>
    <td>{{ car.registrationNumber }}</td>
    <td>
      <div class="row-display-btn-container">
        <EditButton @click="emit('edit', car.uuid)" />
        <DeleteButton @click="emit('delete', car)" />
      </div>
    </td>
  </DisplayRowLayout>
</template>

<script setup>
const props = defineProps({
  car: Object,
});

const emit = defineEmits(['edit', 'delete']);
</script>
