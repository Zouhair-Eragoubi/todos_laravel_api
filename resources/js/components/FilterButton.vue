<template>
    <button type="button" class="btn btn-outline-secondary" @click="filterTodos()">
        <i class="me-1" :class="icon"></i>{{ label }}
    </button>
</template>

<script setup>
const emit = defineEmits(['filter']);
    defineProps({
        icon: String,
        label: String,
    });

    const filterTodos = () => {
        emit('filter');
    };
</script>

<style>

</style>