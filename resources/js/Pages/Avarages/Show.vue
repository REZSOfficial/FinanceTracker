<template>
    <AppLayout title="Average Spendings">
        <!-- Line chart for average spendings -->
        <div
            class="flex flex-col w-full p-3 mx-auto mt-8 text-sm text-gray-200 rounded-lg md:w-2/3 gap-y-2 glass sm:text-2xl"
        >
            <h1 class="mt-2 mb-6 text-center">Average Spendings</h1>
            <canvas id="average"></canvas>
        </div>

        <!-- Bar chart for average spendings by type -->
        <div
            class="flex flex-col w-full p-3 mx-auto mt-8 text-sm text-gray-200 rounded-lg md:w-2/3 gap-y-2 glass sm:text-2xl"
        >
            <h1 class="mt-2 mb-6 text-center">Average Spendings by Type</h1>
            <ul class="flex flex-wrap justify-center gap-3">
                <li
                    class="px-2 text-[15px] rounded-md bg-dark border-2 border-transparent hover:border-white duration-200 hover:cursor-pointer"
                    v-for="(month, index) in getMonths(12)"
                    :class="{ 'border-white': index + 1 === selectedMonth }"
                    :key="month"
                    @click="changeMonth(index + 1)"
                >
                    {{ month }}
                </li>
            </ul>
            <canvas id="by-type"></canvas>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, onMounted } from "vue";
import getMonths from "../../Utils/months";
import Chart from "chart.js/auto";
import axios from "axios";

const props = defineProps({
    averageIncoming: {
        type: Object,
        required: true,
    },
    averageOutgoing: {
        type: Object,
        required: true,
    },
    averageIncomingByType: {
        type: Array,
        default: () => [], // Default to an empty array if undefined
    },
    averageOutgoingByType: {
        type: Array,
        default: () => [], // Default to an empty array if undefined
    },
    currentMonth: {
        type: Number,
        required: true,
    },
});

// Reactive variables for the data
const incomingByType = ref(props.averageIncomingByType);
const outgoingByType = ref(props.averageOutgoingByType);
const selectedMonth = ref(props.currentMonth);

let averageChart;
let byTypeChart;

const updateCharts = () => {
    // Update the bar chart for average spendings by type
    if (byTypeChart) byTypeChart.destroy();

    const byTypeChartCanvas = document.getElementById("by-type");

    const typeLabels = incomingByType.value.map((item) => item.type);
    const incomingData = incomingByType.value.map((item) => item.avg_amount);
    const outgoingData = outgoingByType.value.map((item) => item.avg_amount);

    byTypeChart = new Chart(byTypeChartCanvas, {
        type: "bar",
        data: {
            labels: typeLabels,
            datasets: [
                {
                    label: "Average Incoming by Type",
                    data: incomingData,
                    backgroundColor: "rgba(0, 153, 51, 0.5)",
                    borderColor: "rgb(0, 153, 51)",
                    borderWidth: 1,
                },
                {
                    label: "Average Outgoing by Type",
                    data: outgoingData,
                    backgroundColor: "rgba(204, 0, 0, 0.5)",
                    borderColor: "rgb(204, 0, 0)",
                    borderWidth: 1,
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
};

const changeMonth = (month) => {
    axios
        .get(route("averages.index", { month: month }))
        .then((response) => {
            incomingByType.value = response.data.averageIncomingByType || [];
            outgoingByType.value = response.data.averageOutgoingByType || [];
            selectedMonth.value = response.data.currentMonth;

            updateCharts();
        })
        .catch((error) => {
            console.error(
                "Failed to fetch data for the selected month:",
                error
            );
        });
};

onMounted(() => {
    // Line chart for average incoming and outgoing
    const averageChartCanvas = document.getElementById("average");
    const labels = getMonths(12);

    averageChart = new Chart(averageChartCanvas, {
        type: "line",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Average Incoming",
                    data: props.averageIncoming,
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
                    label: "Average Outgoing",
                    data: props.averageOutgoing,
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

    updateCharts();
});
</script>
