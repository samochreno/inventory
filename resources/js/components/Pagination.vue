<template>
  <div style="height: var(--height-pagination)">
    <Bootstrap5Pagination
      :data="data"
      :limit="limit"
      :keep-length="keepLength"
      @pagination-change-page="(p) => $emit('pagination-change-page', p)"
    ></Bootstrap5Pagination>
  </div>
</template>

<script setup>
import { Bootstrap5Pagination } from 'laravel-vue-pagination';

const props = defineProps({
  data: Object,
  limit: Number,
  keepLength: Boolean,
});

const emit = defineEmits(['pagination-change-page']);
</script>
