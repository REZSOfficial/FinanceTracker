<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { onMounted } from "vue";
import getMonths from "../../Utils/months";
import Chart from "chart.js/auto";
const props = defineProps({
    averageIncoming: Object,
    averageOutgoing: Object,
});

onMounted(() => {
    const avarageChartCanvas = document.getElementById("average");
    const labels = getMonths(12);
    const averageIncomingAmounts = [];
    const averageOutgoingAmounts = [];

    for (let i = 1; i < 13; i++) {
        if (props.averageIncoming[i]) {
            averageIncomingAmounts.push(props.averageIncoming[i].amount);
        } else {
            averageIncomingAmounts.push(0);
        }
    }

    for (let i = 1; i < 13; i++) {
        if (props.averageOutgoing[i]) {
            averageOutgoingAmounts.push(props.averageOutgoing[i].amount);
        } else {
            averageOutgoingAmounts.push(0);
        }
    }

    const avarageChart = new Chart(avarageChartCanvas, {
        type: "line",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Avarage Incoming",
                    data: averageIncomingAmounts,
                    borderWidth: 1,
                    borderColor: "rgb(0, 153, 51)",
                    backgroundColor: "rgba(0, 153, 51, 0.1)",
                    tension: 0.3,
                    fill: true,
                    pointRadius: 5,
                    pointHoverRadius: 10,
                    pointBackgroundColor: "rgba(0, 153, 51)",
                },
                {
                    label: "Avarage Outgoing",
                    data: averageOutgoingAmounts,
                    borderWidth: 1,
                    borderColor: "rgb(204, 0, 0)",
                    backgroundColor: "rgba(204, 0, 0, 0.1)",
                    tension: 0.3,
                    fill: true,
                    pointRadius: 5,
                    pointHoverRadius: 10,
                    pointBackgroundColor: "rgba(204, 0, 0)",
                },
            ],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: "rgb(255, 255, 255)", // Y-axis labels color
                        font: {
                            size: 16,
                            weight: "bold",
                            family: "monospace",
                        },
                    },
                },
                x: {
                    ticks: {
                        color: "rgb(255, 255, 255)", // X-axis labels color
                        font: {
                            size: 16,
                            weight: "bold",
                            family: "monospace",
                        },
                    },
                },
            },
        },
    });
});
</script>

<template>
    <AppLayout>
        <div
            class="flex flex-col w-2/3 p-3 mx-auto mt-8 text-sm text-gray-200 rounded-lg gap-y-2 glass min-w-fit sm:text-2xl"
        >
            <h1 class="mt-2 mb-6 text-center">Average Spendings</h1>
            <canvas id="average"></canvas>
        </div>
    </AppLayout>
</template>
