<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import RegularContainer from "@/Components/RegularContainer.vue";
import { Chart } from "chart.js/auto";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faPlus, faMinus, faBullseye } from "@fortawesome/free-solid-svg-icons";

export default {
    components: {
        AppLayout,
        RegularContainer,
        PrimaryButton,
        PrimaryButton,
        FontAwesomeIcon,
    },
    props: {
        monthsLeft: Array,
        regularPayments: Array,
        paymentsMonthsLeft: Array,
        regularIncomings: Array,
        incomings: Array,
        payments: Array,
        data: Object,
        cashPayments: Array,
        cardPayments: Array,
        inAndOut: Object,
        balance: Object,
    },
    data() {
        return {
            faPlus,
            faMinus,
            faBullseye,
        };
    },
    mounted() {
        this.initializeChart();
        this.initializeAvgChart();
    },

    methods: {
        initializeChart() {
            const thisMonth = document.getElementById("this-month");
            let inAndOutData = [this.inAndOut["in"], this.inAndOut["out"]];
            new Chart(thisMonth, {
                type: "doughnut",
                data: {
                    labels: ["In", "Out"],
                    datasets: [
                        {
                            data: inAndOutData,
                            borderWidth: 1,
                            backgroundColor: ["#98D8AA", "#FF6D60"],
                        },
                    ],
                },
                options: {
                    plugins: {
                        tooltip: {
                            enabled: true,
                        },
                        legend: {
                            display: false,
                        },
                    },
                    scales: {
                        y: {
                            display: false,
                        },
                        x: {
                            display: false,
                        },
                    },
                },
            });
        },

        initializeAvgChart() {
            let names = [
                "Food and drink",
                "Housing",
                "Transportation",
                "Healthcare",
                "Entertainment",
                "Other",
            ];
            let prices = [
                this.data.food_drink,
                this.data.housing,
                this.data.transportation,
                this.data.healthcare,
                this.data.entertainment,
                this.data.other,
            ];

            const avgmonthly = document.getElementById("avgmonthly");

            new Chart(avgmonthly, {
                type: "pie",
                data: {
                    labels: names,
                    datasets: [
                        {
                            data: prices,
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    plugins: {
                        tooltip: {
                            enabled: true,
                        },
                        legend: {
                            display: false,
                        },
                    },
                    scales: {
                        y: {
                            display: false,
                        },
                        x: {
                            display: false,
                        },
                    },
                },
            });
        },
    },
};
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="flex flex-col w-3/4 mx-auto mt-12">
            <!-- Charts -->
            <div class="flex flex-col gap-2 md:flex-row">
                <!-- Avarage -->
                <div
                    class="flex justify-between w-full p-4 text-white rounded md:w-1/2 bg-dark"
                >
                    <div class="w-1/4 my-auto chart-container">
                        <canvas id="avgmonthly"></canvas>
                    </div>
                    <h1 class="p-2 my-auto text-xl rounded glass">
                        Avarage Monthly Spendings
                    </h1>
                </div>
                <!-- In and Out -->
                <div
                    class="flex justify-between w-full p-4 text-white rounded md:w-1/2 bg-dark"
                >
                    <div class="w-1/4 my-auto chart-container">
                        <canvas id="this-month"></canvas>
                    </div>
                    <h1 class="p-2 my-auto text-xl rounded glass">
                        This Month
                    </h1>
                    <div class="flex flex-col font-bold gap-y-1 text-dark">
                        <p class="p-1 px-2 bg-red-600 rounded">
                            -{{ inAndOut.out }}$
                        </p>
                        <p class="p-1 px-2 bg-green-600 rounded">
                            +{{ inAndOut.in }}$
                        </p>
                        <p class="p-1 px-2 bg-white rounded">
                            {{ inAndOut.in - inAndOut.out }}$
                        </p>
                        <p class="p-1 px-2 bg-blue-600 rounded">
                            Balance: {{ balance.balance }}$
                        </p>
                    </div>
                </div>
            </div>

            <!-- Regular Incoming -->
            <div class="mt-8">
                <h1
                    class="p-2 px-3 mx-auto text-3xl text-center text-gray-300 border border-gray-400 rounded bg-dark w-fit"
                >
                    Regular Incoming
                </h1>
                <div
                    class="grid grid-cols-1 gap-4 p-4 mx-auto mt-8 rounded md:grid-cols-2 grid-flow-auto bg-dark"
                >
                    <div
                        class="col-span-1"
                        v-for="regularIncoming in regularIncomings"
                        :key="regularIncoming.id"
                    >
                        <RegularContainer
                            :monthsLeft="monthsLeft"
                            :regular="regularIncoming"
                        />
                    </div>
                </div>
            </div>

            <!-- Regular Outgoing -->
            <div class="mt-8">
                <h1
                    class="p-2 px-3 mx-auto text-3xl text-center text-gray-300 border border-gray-400 rounded bg-dark w-fit"
                >
                    Regular Outgoing
                </h1>
                <div
                    class="grid grid-cols-1 gap-4 p-4 mx-auto mt-8 rounded md:grid-cols-2 grid-flow-auto bg-dark"
                >
                    <div
                        class="col-span-1"
                        v-for="regularPayment in regularPayments"
                        :key="regularPayment.id"
                    >
                        <RegularContainer
                            :monthsLeft="paymentsMonthsLeft"
                            :regular="regularPayment"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="fixed bottom-0 right-0 flex flex-col p-1 gap-y-1">
            <PrimaryButton
                :icon="faPlus"
                id="inBtn"
                class="bg-green-600 hover:bg-green-700"
                role="button"
            >
                Add incoming
            </PrimaryButton>
            <PrimaryButton
                :icon="faMinus"
                id="outBtn"
                class="bg-red-600 hover:bg-red-700"
                role="button"
            >
                Add outgoing
            </PrimaryButton>
            <PrimaryButton
                :icon="faBullseye"
                class="bg-yellow-600 hover:bg-yellow-700"
                >Add goal</PrimaryButton
            >
        </div>
    </AppLayout>
</template>
