<template>
    <div class="row g-3 mb-4">
        <stats-item icon="fas fa-tasks" iconClass="text-primary"  label="Total Tasks"></stats-item>
        <stats-item icon="fas fa-check-circle" iconClass="text-success"  label="Completed" :completed="true"></stats-item>
        <stats-item icon="fas fa-exclamation-circle" iconClass="text-danger" label="Overdue" :completed="false"></stats-item>
    </div>
</template>

<script setup>
    import StatsItem from './StatsItem.vue';
</script>

<style>

</style>
