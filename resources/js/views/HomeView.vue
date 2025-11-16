<template>
  <div class="container main-container">
    <!-- Error Alert -->
    <div v-if="errorMessage" class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
      <i class="fas fa-exclamation-circle me-2"></i>
      <strong>Error:</strong> {{ errorMessage }}
      <button type="button" class="btn-close" @click="clearError" aria-label="Close"></button>
    </div>

    <div class="row g-4">
      <!-- Sidebar -->
      <div class="col-lg-3">
        <side-bar></side-bar>
      </div>

      <!-- Main Content -->
      <div class="col-lg-9">
        <header-bar></header-bar>
        <main-content></main-content>
      </div>
    </div>
  </div>
</template>

<script setup>
import SideBar from '@/components/SideBar.vue';
import HeaderBar from '@/components/HeaderBar.vue';
import MainContent from '@/components/MainContent.vue';
import { useTodosStore } from '@/stores/TodosStore';
import { storeToRefs } from 'pinia';
import { onMounted } from 'vue';

const todosStore = useTodosStore();
const { errorMessage } = storeToRefs(todosStore);

onMounted(() => {
  todosStore.loadCategories();
  todosStore.loadTodos();
});

function clearError() {
  todosStore.errorMessage = '';
}
</script>

<style scoped>
.main-container {
  padding: 20px 0;
}

.alert {
  animation: slideDown 0.3s ease-out;
  border: none;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  border-radius: 10px;
}

.alert-danger {
  background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
  color: white;
}

.alert-danger .btn-close {
  filter: brightness(0) invert(1);
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
