<template>
  <input
    type="text"
    class="form-control"
    id="search"
    placeholder="Hľadať"
    :value="props.text"
    @input="
      (e) => {
        text = e.target.value;
        search();
      }
    "
  />
</template>

<script setup>
import { ref } from 'vue';
import debounce from 'debounce';

const props = defineProps(['text']);

const emit = defineEmits(['text']);

const text = ref(props.text);

const search = debounce(() => emit('text', text.value), 500);
</script>
