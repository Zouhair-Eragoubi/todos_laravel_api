<template>
    <button class="btn btn-outline-primary" @click="openOrCloseModal" title="Edit">
        <i class="fas fa-edit"></i>
    </button>
    <Teleport to="body">
        <div
            class="modal fade"
            :class="{ show: showModal }"
            role="dialog"
            id="editModal"
            tabindex="-1"
            aria-labelledby="taskModalLabel"
            aria-hidden="true"
            ref="modalRef"
            v-if="showModal"
            style="display: block; background: rgba(0,0,0,0.5);"
        >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary">
                    <h5 class="modal-title " id="taskModalLabel">
                        <i class="fas fa-edit me-2"></i>Edit Task
                    </h5>
                    <button type="button" class="btn-close btn-close-white" @click="openOrCloseModal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Task Name *</label>
                        <input type="text" class="form-control" v-model="newTask.name" placeholder="Enter task name">
                        <p v-if="errors && errors.name" class="text-danger mt-2">
                            {{ Array.isArray(errors.name) ? errors.name[0] : errors.name }}
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" v-model="newTask.desc" rows="3" placeholder="Add details..."></textarea>
                        <p v-if="errors && errors.desc" class="text-danger mt-2">
                            {{ Array.isArray(errors.desc) ? errors.desc[0] : errors.desc }}
                        </p>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Category *</label>
                            <select class="form-select" v-model="newTask.category_id">
                                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                            </select>
                            <p v-if="errors && errors.category_id" class="text-danger mt-2">
                                {{ Array.isArray(errors.category_id) ? errors.category_id[0] : errors.category_id }}
                            </p>
                            
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Priority *</label>
                            <select class="form-select" v-model="newTask.priority">
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                            <p v-if="errors && errors.priority" class="text-danger mt-2">
                                {{ Array.isArray(errors.priority) ? errors.priority[0] : errors.priority }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Due Date</label>
                        <input type="date" class="form-control" v-model="newTask.due_date">
                        <p v-if="errors && errors.due_date" class="text-danger mt-2">
                            {{ Array.isArray(errors.due_date) ? errors.due_date[0] : errors.due_date }}
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Tags (comma separated)</label>
                        <input type="text" class="form-control" v-model="newTask.tags" placeholder="e.g., urgent, meeting, report">
                        <p v-if="errors && errors.tags" class="text-danger mt-2">
                            {{ Array.isArray(errors.tags) ? errors.tags[0] : errors.tags }}
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="openOrCloseModal" :disabled="loading">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-primary" @click="updateTask" :disabled="loading">
                        <span v-if="loading">
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            Updating...
                        </span>
                        <span v-else>
                            <i class="fas fa-save me-2"></i>Update Task
                        </span>
                    </button>
                </div>
            </div>
        </div>
        </div>
    </Teleport>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { useTodosStore } from '@/stores/TodosStore';
import { computed } from 'vue';
import { storeToRefs } from 'pinia';

const props = defineProps({
  task: {
    type: Object,
    required: true
  }
});

const todosStore = useTodosStore();
const { errors, loading } = storeToRefs(todosStore);
const categories = computed(() => todosStore.allCategories);

const modalRef = ref(null)
const showModal = ref(false)
const newTask = reactive({
  name: '',
  desc: '',
  category_id: '',
  priority: '',
  due_date: '',
  tags: ''
})

function parseTags(tagsString) {
  if (!tagsString) return '';
  try {
    const tags = JSON.parse(tagsString);
    return Array.isArray(tags) ? tags.join(', ') : '';
  } catch (error) {
    return '';
  }
}

function populateForm() {
  newTask.name = props.task.name || '';
  newTask.desc = props.task.desc || '';
  newTask.category_id = props.task.category_id || '';
  newTask.priority = props.task.priority || '';
  newTask.due_date = props.task.due_date || '';
  newTask.tags = parseTags(props.task.tags);
}

function resetForm() {
  newTask.name = ''
  newTask.desc = ''
  newTask.category_id = ''
  newTask.priority = ''
  newTask.due_date = ''
  newTask.tags = ''
}

function openOrCloseModal() {
  if (!showModal.value) {
    populateForm();
  }
  showModal.value = !showModal.value
  if (!showModal.value) resetForm()
}

async function updateTask() {
  console.log('EditButton - Task to update:', props.task.id, typeof props.task.id);

  const taskToUpdate = {
    name: newTask.name,
    desc: newTask.desc,
    category_id: newTask.category_id,
    priority: newTask.priority,
    due_date: newTask.due_date,
    tags: newTask.tags ? JSON.stringify(newTask.tags.split(',').map(t => t.trim()).filter(Boolean)) : '[]'
  }

  console.log('EditButton - Sending update:', taskToUpdate);

  const success = await todosStore.updateTodo(props.task.id, taskToUpdate);

  console.log('EditButton - Update success:', success);

  if (success) {
    openOrCloseModal();
  }
}
</script>

<style>
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
    margin: 1.75rem auto;
    max-width: 800px;
    width: 90%;
}

.modal-content {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    position: relative;
}

.btn-close-white {
    filter: brightness(0) invert(1);
}
</style>
