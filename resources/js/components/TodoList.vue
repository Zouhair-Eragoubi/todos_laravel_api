<template>
    <div id="todoList">
        <!-- Loading Spinner -->
        <div v-if="loading" class="loading-container text-center py-5">
            <div class="spinner-wrapper">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3 text-muted fw-bold">Loading tasks...</p>
            </div>
        </div>

        <!-- Todo Items -->
        <div v-else>
            <todo-item v-for="task in allTodos" :key="task.id" :task="task"></todo-item>
            <div v-if="allTodos.length === 0" id="emptyState" class="text-center py-5">
                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">No tasks found</h4>
                <p class="text-muted">Add a new task to get started!</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import TodoItem from '@components/TodoItem.vue';
import { storeToRefs } from 'pinia';
import { useTodosStore } from '@stores/TodosStore';

const store = useTodosStore();
const { allTodos, loading } = storeToRefs(store);
</script>

<style scoped>
.loading-container {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 15px;
    padding: 40px 20px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

.spinner-wrapper {
    animation: fadeIn 0.3s ease-in;
}

.spinner-border {
    border-width: 0.3rem;
    color: #667eea !important;
    animation: spin 0.8s linear infinite;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
