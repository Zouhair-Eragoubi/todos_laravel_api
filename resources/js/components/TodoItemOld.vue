<template>
    <div class="todo-item">
        <div class="todo-content">
            <h5 :class="{ 'completed': task.completed }">
                {{ task.title }}
            </h5>
            <p class="description">{{ task.description }}</p>
            <div class="tags">
                <span class="tag priority-tag" :class="getPriorityClass(task.priority)">
                    {{ task.priority }}
                </span>
                <span class="tag category-tag">{{ task.category }}</span>
                <span v-if="task.dueDate" class="tag date-tag">
                    <i class="fas fa-calendar me-1"></i>{{ formatDate(task.dueDate) }}
                </span>
            </div>
        </div>
        <div class="actions">
            <button class="action-btn complete-btn" @click="toggleComplete(task.id)" :title="task.completed ? 'Mark as incomplete' : 'Mark as complete'">
                <i :class="task.completed ? 'fas fa-undo' : 'fas fa-check'"></i>
            </button>
            <button class="action-btn delete-btn" @click="deleteTask(task.id)" title="Delete task">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
</template>

<script setup>
import { useTodosStore } from '@/stores/TodosStore';

const todosStore = useTodosStore();

defineProps({
  task: {
    type: Object,
    required: true
  }
})

function getPriorityClass(priority) {
  return {
    'priority-high': priority.toLowerCase() === 'high',
    'priority-medium': priority.toLowerCase() === 'medium',
    'priority-low': priority.toLowerCase() === 'low'
  }
}

function formatDate(dateString) {
  if (!dateString) return ''
  return new Intl.DateTimeFormat('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric'
  }).format(new Date(dateString))
}

function toggleComplete(taskId) {
    todosStore.toggleTodoCompletion(taskId)
}

function deleteTask(taskId) {
  if (confirm('Are you sure you want to delete this task?')) {
    todosStore.deleteTodo(taskId)
  }
}
</script>

<style scoped>
.todo-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem;
    margin-bottom: 1rem;
    border-radius: 12px;
    background: #ffffff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.todo-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
}

.todo-content {
    flex-grow: 1;
}

h5 {
    margin: 0 0 0.5rem;
    font-size: 1.1rem;
    color: #1a1a1a;
    transition: all 0.3s ease;
}

h5.completed {
    text-decoration: line-through;
    color: #9ca3af;
}

.description {
    color: #4b5563;
    font-size: 0.95rem;
    margin-bottom: 0.75rem;
    line-height: 1.5;
}

.tags {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.tag {
    padding: 0.35rem 0.75rem;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
}

.priority-high { background: #fee2e2; color: #dc2626; }
.priority-medium { background: #fef3c7; color: #d97706; }
.priority-low { background: #e0f2fe; color: #0284c7; }
.category-tag { background: #f3f4f6; color: #4b5563; }
.date-tag { background: #dbeafe; color: #2563eb; }

.actions {
    display: flex;
    gap: 0.75rem;
}

.action-btn {
    padding: 0.5rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    color: white;
}

.complete-btn {
    background-color: #10b981;
}

.delete-btn {
    background-color: #ef4444;
}

.action-btn:hover {
    transform: scale(1.1);
    filter: brightness(110%);
}

@media (max-width: 640px) {
    .todo-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .actions {
        margin-top: 1rem;
        align-self: flex-end;
    }
}
</style>
