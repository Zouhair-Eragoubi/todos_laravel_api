<template>
    <h5 class="mb-3 mt-4"><i :class="icon + ' me-2'"></i>{{ title }}</h5>
</template>

<script setup>
defineProps({
    title: {
        type: String,
        required: true
    },
    icon: {
        type: String,
        required: true
    }
});
</script>

<style>

</style>
