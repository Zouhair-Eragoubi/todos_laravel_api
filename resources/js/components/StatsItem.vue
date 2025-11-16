<template>
    <div class="col-md-4 col-6">
        <div class="stats-card">
            <div class="stats-icon" :class="iconClass">
                <i :class="icon"></i>
            </div>
            <h3>{{ completedCount }}</h3>
            <small class="text-muted">{{ label }}</small>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { useTodosStore } from '@/stores/TodosStore';
const props = defineProps({
    icon: {
        type: String,
        required: true
    },
    iconClass: {
        type: String,
        required: true
    },
    label: {
        type: String,
        required: true
    },
    completed: {
        type: Boolean,
        required: false,
        default: undefined
    }
});

const todosStore = useTodosStore();
const completedCount = computed(() => {
    return todosStore.getCompletedTodosCount(props.completed);
});
</script>

<style>
    .stats-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }

    .stats-card:hover {
        transform: translateY(-5px);
    }

    .stats-icon {
        font-size: 2rem;
        margin-bottom: 10px;
    }
</style>
