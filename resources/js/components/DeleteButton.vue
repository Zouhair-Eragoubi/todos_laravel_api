<template>
    <button class="btn btn-outline-danger" @click="openModal" title="Delete">
        <i class="fas fa-trash"></i>
    </button>
    <Teleport to="body">
        <div
            class="modal fade"
            :class="{ show: showModal }"
            role="dialog"
            tabindex="-1"
            aria-labelledby="deleteModalLabel"
            aria-hidden="true"
            v-if="showModal"
            style="display: block; background: rgba(0,0,0,0.5);"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deleteModalLabel">
                            <i class="fas fa-exclamation-triangle me-2"></i>Confirm Delete
                        </h5>
                        <button type="button" class="btn-close btn-close-white" @click="closeModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-trash-alt text-danger" style="font-size: 3rem;"></i>
                        </div>
                        <h6 class="text-center mb-3">Are you sure you want to delete this task?</h6>
                        <div class="alert alert-warning">
                            <strong>Task:</strong> {{ task.name }}
                        </div>
                        <p class="text-muted text-center mb-0">
                            <i class="fas fa-info-circle me-1"></i>
                            This action cannot be undone.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="closeModal" :disabled="loading">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="button" class="btn btn-danger" @click="confirmDelete" :disabled="loading">
                            <span v-if="loading">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                Deleting...
                            </span>
                            <span v-else>
                                <i class="fas fa-trash me-2"></i>Delete Task
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script setup>
import { ref } from 'vue';
import { useTodosStore } from '@/stores/TodosStore';
import { storeToRefs } from 'pinia';

const props = defineProps({
  task: {
    type: Object,
    required: true
  }
});

const todosStore = useTodosStore();
const { loading } = storeToRefs(todosStore);

const showModal = ref(false);

function openModal() {
  showModal.value = true;
}

function closeModal() {
  showModal.value = false;
}

async function confirmDelete() {
  const success = await todosStore.deleteTodo(props.task.id);

  if (success) {
    closeModal();
  }
}
</script>

<style scoped>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1050;
    overflow-y: auto;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal.show {
    display: flex;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-dialog {
    max-width: 500px;
    width: 90%;
}

.modal-content {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    position: relative;
    border: none;
}

.modal-header.bg-danger {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
}

.btn-close-white {
    filter: brightness(0) invert(1);
}

.alert-warning {
    background-color: #fff3cd;
    border-color: #ffc107;
    color: #856404;
    border-radius: 8px;
}
</style>
