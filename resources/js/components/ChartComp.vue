<template>
    <div class="text-center">
        <canvas ref="progressChart" width="150" height="150"></canvas>
        <p class="mt-3 mb-0"><strong>{{ progressPercent }}%</strong> Complete</p>
    </div>
</template>

<script setup>
import Chart from 'chart.js/auto';
import { useTodosStore } from '@/stores/TodosStore';
import { ref, computed, onMounted, watch } from 'vue';

const todosStore = useTodosStore();
console.log(todosStore);

const progressChart = ref(null);
let chartInstance = null;

const taskCount = computed(() => todosStore.currentCategoryCount);
const taskCompletedCount = computed(() => todosStore.getCompletedTodosCount(true));
const taskIncompletedCount = computed(() => todosStore.getCompletedTodosCount(false));

const progressPercent = computed(() => {
  if (!taskCount.value) return 0;
  return Math.round((taskCompletedCount.value / taskCount.value) * 100);
});

const initChart = () => {
  if (!progressChart.value) return;
  
  // Destroy existing chart if it exists
  if (chartInstance) {
    chartInstance.destroy();
  }

  const ctx = progressChart.value.getContext('2d');
  
  const data = {
    labels: ['Completed', 'Incompleted'],
    datasets: [{
      data: [taskCompletedCount.value, taskIncompletedCount.value],
      backgroundColor: [
        'rgb(40, 167, 69)',
        'rgb(220, 53, 69)'
      ],
      borderWidth: 0,
      hoverOffset: 4
    }]
  };

  const config = {
    type: 'doughnut',
    data: data,
    options: {
      responsive: true,
      maintainAspectRatio: true,
      plugins: {
        legend: {
          display: true
        },
        tooltip: {
          enabled: true
        }
      }
    }
  };

  chartInstance = new Chart(ctx, config);
};

const updateChart = () => {
  if (!chartInstance) return;
  
  chartInstance.data.datasets[0].data = [taskCompletedCount.value, taskIncompletedCount.value];
  chartInstance.update();
};

onMounted(() => {
  initChart();
});


// Watch for changes in task counts and update chart
watch([taskCompletedCount, taskIncompletedCount], () => {
  updateChart();
});
</script>

<style>

</style>