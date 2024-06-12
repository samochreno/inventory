<template>
  <DisplayRowLayout>
    <td>{{ part.name }}</td>
    <td>{{ part.serialnumber }}</td>
    <td>
      <a :href="part.car.href" class="link-primary">{{ part.car.name }}</a>
    </td>
    <td>
      <div class="row-display-btn-container">
        <EditButton @click="emit('edit', part.uuid)" />
        <DeleteButton @click="emit('delete', part)" />
      </div>
    </td>
  </DisplayRowLayout>
</template>

<script setup>
const props = defineProps({
  part: Object,
});

const emit = defineEmits(['edit', 'delete']);
</script>
