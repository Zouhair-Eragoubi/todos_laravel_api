<template>
    <div class="btn-group w-100 mb-3" role="group">
        <filter-button icon="fas fa-list" label="All" :class="isActive" @filter="resetFilters()"></filter-button>
        <filter-button icon="fas fa-check" label="Completed" :class = "completionStatus(true)" @filter="filterByCompletion(true)"></filter-button>
        <filter-button icon="fas fa-times" label="Incompleted" :class = "completionStatus(false)" @filter="filterByCompletion(false)"></filter-button>
        <filter-button icon="fas fa-arrow-down" label="Low Priority" :class = "currentPriority('low')" @filter="filterByPriority('low')"></filter-button>
        <filter-button icon="fas fa-arrow-up" label="Medium Priority" :class = "currentPriority('medium')" @filter="filterByPriority('medium')"></filter-button>
        <filter-button icon="fas fa-exclamation" label="High Priority" :class = "currentPriority('high')" @filter="filterByPriority('high')"></filter-button>
    </div>
</template>

<script setup>
    import FilterButton from './FilterButton.vue';

    import { useTodosStore } from '@/stores/TodosStore';
    import { computed } from 'vue';
    const todosStore = useTodosStore();

    const filterByPriority = (priority) => {
        todosStore.setPriorityFilter(priority);
    };
    const filterByCompletion = (status) => {
         todosStore.setCompletionFilter(status);
    };
    const resetFilters = () => {
        todosStore.resetFilters();
    };


    const currentPriority = computed(() => (priority) => todosStore.getCurrentPriority === priority ? 'active' : '');
    const completionStatus = computed(() => (status) => todosStore.getCompletionStatus === status ? 'active' : '');
    const isActive = computed(() => {
        return todosStore.getCurrentPriority === undefined || todosStore.getCompletionStatus === undefined ? 'active' : '';
    });

</script>

<style>

</style>
