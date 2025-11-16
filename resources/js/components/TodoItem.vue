<template>
    <div :class="['card todo-item mb-3','todo-item', task.completed ? 'completed' : '', 'priority-' + task.priority.toLowerCase()]">
        <div class="card-body">
            <div class="d-flex align-items-start">
                <input type="checkbox" class="form-check-input me-3 mt-1" style="width: 20px; height: 20px;"
                    :checked=" task.completed " @change="toggleComplete(task.id)">
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <span class="category-badge priority-${task.priority}">
                                <i class="fas fa-flag me-1"></i>{{task.priority.toUpperCase()}}
                            </span>
                            <span class="category-badge" style="background: #e9ecef; color: #495057;">
                                <i class="fas fa-folder me-1"></i>{{task.category_name}}
                            </span>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <delete-button :task="task"></delete-button>
                            <edit-button :task="task"></edit-button>
                        </div>
                    </div>
                    <h5 class="todo-text mb-2">{{task.name}}</h5>
                    <p class="text-muted mb-2 small">{{task.desc}}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="tag" v-for="t in parseTags(task.tags)" :key="t">{{t}}</span>
                        </div>

                        <small class="due-date" :class="{ 'overdue': isOverdue }">
                            <i class="fas fa-calendar me-1"></i>
                            {{isOverdue ? 'OVERDUE: ' : ''}} {{formatDate(task.due_date)}}
                        </small>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import EditButton from '@components/EditButton.vue';
import DeleteButton from '@components/DeleteButton.vue';
import { useTodosStore } from '@/stores/TodosStore';

const todosStore = useTodosStore();

const props = defineProps({
  task: {
    type: Object,
    required: true
  }
});

const isOverdue = props.task.due_date && new Date(props.task.due_date) < new Date() && !props.task.completed;

// function getPriorityClass(priority) {
//   return {
//     'priority-high': priority.toLowerCase() === 'high',
//     'priority-medium': priority.toLowerCase() === 'medium',
//     'priority-low': priority.toLowerCase() === 'low'
//   }
// }

function parseTags(tagsString) {
  if (!tagsString) return []
  try {
    const tags = JSON.parse(tagsString)
    return Array.isArray(tags) ? tags : []
  } catch (error) {
    return []
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
</script>

<style scoped>

    .todo-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    .todo-header {
        background: var(--primary-gradient);
        color: white;
        padding: 25px;
        border-radius: 15px 15px 0 0;
    }

    .category-badge {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 10px;
    }

    .priority-high { background: #ff6b6b; color: white; }
    .priority-medium { background: #feca57; color: #333; }
    .priority-low { background: #48dbfb; color: white; }

    .todo-item {
        transition: all 0.3s ease;
        border-left: 4px solid #667eea;
        position: relative;
        overflow: hidden;
    }

    .todo-item:hover {
        background-color: #f8f9fa;
        color:#333;
        transform: translateX(5px);
    }

    .todo-item.completed {
        opacity: 0.6;
        border-left-color: #28a745;
    }

    .todo-item.completed .todo-text {
        text-decoration: line-through;
    }

    .todo-item.priority-high { border-left-color: #ff6b6b; }
    .todo-item.priority-medium { border-left-color: #feca57; }
    .todo-item.priority-low { border-left-color: #48dbfb; }

    .category-item {
        padding: 12px;
        margin-bottom: 8px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .due-date {
        font-size: 0.85rem;
        color: #666;
    }

    .overdue {
        color: #ff6b6b;
        font-weight: bold;
    }

    .tag {
        display: inline-block;
        padding: 3px 10px;
        background: #e9ecef;
        border-radius: 12px;
        font-size: 0.75rem;
        margin-right: 5px;
        color: #495057;
    }

    .subtask {
        padding: 8px;
        background: #f8f9fa;
        border-radius: 5px;
        margin-top: 5px;
        font-size: 0.9rem;
    }
    </style>
