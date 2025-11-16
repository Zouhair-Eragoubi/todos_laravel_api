<template>
  <div class="category-item " :class="activeClass" @click="setCurrentCategory">
    <span><i class="fas me-2" :class="'fa-'+icon"></i>{{ title }}</span>
    <span class="badge bg-secondary" id="shoppingCount">{{ filterByCategory }}</span>
  </div>
</template>

<script setup>
import { useTodosStore } from '@/stores/TodosStore';
import { computed } from 'vue';
import { storeToRefs } from 'pinia';

const { currentCategory  } = storeToRefs(useTodosStore());
const todosStore = useTodosStore();
const props = defineProps({
  title: String,
  icon: String,
  category: {
    type: Number,
    required: false,
    default: undefined
  },
});

const activeClass = computed(() => {
  console.log('Current category:', currentCategory.value, 'Props category:', props.category);
  return currentCategory.value === props.category ? 'active' : '';
});

const filterByCategory = computed(() => {
  console.log('Filtering by category:', props.category);
  return todosStore.getCategoryTodosCount(props.category);
});

function setCurrentCategory() {
  todosStore.setCategoryFilter(props.category);
}
</script>

<style>

</style>
