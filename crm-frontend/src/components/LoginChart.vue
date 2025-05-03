<template>
  <div class="p-4">
    <h2 class="text-xl font-bold mb-4">Login Activity (Sales Graph)</h2>
    <canvas ref="chartCanvas"></canvas>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { Chart, registerables } from 'chart.js';
import axios from 'axios';

Chart.register(...registerables);

export default {
  name: 'SalesChart',
  setup() {
    const chartCanvas = ref(null);
    let chartInstance = null;

    const fetchChartData = async () => {
      try {
        const token = localStorage.getItem('api-token');
        const response = await axios.get('http://localhost:8000/api/sales-chart', {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });

        const labels = response.data.labels;
        const data = response.data.data;

        if (chartInstance) {
          chartInstance.destroy();
        }

        chartInstance = new Chart(chartCanvas.value, {
          type: 'line',
          data: {
            labels: labels,
            datasets: [{
              label: 'Logins per Day',
              data: data,
              backgroundColor: 'rgba(75, 192, 192, 0.2)',
              borderColor: 'rgba(75, 192, 192, 1)',
              borderWidth: 2,
              fill: true,
              tension: 0.3
            }]
          },
          options: {
            responsive: true,
            scales: {
              x: {
                title: {
                  display: true,
                  text: 'Date'
                },
                ticks: {
                  autoSkip: true,
                  maxTicksLimit: 10
                }
              },
              y: {
                beginAtZero: true,
                title: {
                  display: true,
                  text: 'Login Count'
                }
              }
            }
          }
        });
      } catch (error) {
        console.error('Failed to load chart data:', error);
      }
    };

    onMounted(fetchChartData);

    return {
      chartCanvas
    };
  }
};
</script>

<style scoped>
canvas {
  max-width: 100%;
}
</style>
