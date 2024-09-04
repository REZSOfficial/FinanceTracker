<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import RegularContainer from "@/Components/RegularContainer.vue";
import { Chart } from "chart.js/auto";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faChevronDown, faChevronUp } from "@fortawesome/free-solid-svg-icons";
import axios from "axios";
import { onMounted, ref, Transition } from "vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";

const props = defineProps({
    regularPayments: Array,
    regularIncomings: Array,
    incomings: Array,
    payments: Array,
    data: Object,
    cashPayments: Array,
    cardPayments: Array,
    inAndOut: Object,
    balance: Object,
});

const regularIncomingsState = ref([...props.regularIncomings]);
const regularPaymentsState = ref([...props.regularPayments]);

// State to control modal visibility and the ID of the item to delete
const showDeleteModal = ref(false);
const itemToDelete = ref(null);
const deleteType = ref(""); // To track whether it's an incoming or payment being deleted

let incomingLimit = ref(4);
let paymentLimit = ref(4);

onMounted(() => {
    initializeChart();
    initializeAvgChart();
});

function openDeleteModal(id, type) {
    showDeleteModal.value = true;
    itemToDelete.value = id;
    deleteType.value = type;
}

// Function to handle the actual deletion
async function confirmDelete() {
    if (deleteType.value === "incoming") {
        await deleteIncoming(itemToDelete.value);
    } else if (deleteType.value === "payment") {
        await deletePayment(itemToDelete.value);
    }
    showDeleteModal.value = false;
}

// Function to delete incoming payment
async function deleteIncoming(id) {
    try {
        await axios.delete(route("deleteIncoming", { incoming: id }));
        regularIncomingsState.value = regularIncomingsState.value.filter(
            (item) => item.id !== id
        );
    } catch (error) {
        console.error("Error deleting incoming:", error);
    }
}

// Function to delete outgoing payment
async function deletePayment(id) {
    try {
        await axios.delete(route("deleteOutgoing", { payment: id }));
        regularPaymentsState.value = regularPaymentsState.value.filter(
            (item) => item.id !== id
        );
    } catch (error) {
        console.error("Error deleting payment:", error);
    }
}

function increaseLimit(type, amount) {
    if (type === "incoming") {
        incomingLimit.value = Math.min(
            regularIncomingsState.value.length,
            incomingLimit.value + amount
        );
    } else if (type === "payment") {
        paymentLimit.value = Math.min(
            regularPaymentsState.value.length,
            paymentLimit.value + amount
        );
    }
}

function initializeChart() {
    if (props.inAndOut) {
        const thisMonth = document.getElementById("this-month");
        let inAndOutData = [props.inAndOut["in"], props.inAndOut["out"]];
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
    }
}

function initializeAvgChart() {
    if (props.data) {
        console.log(props.data);
        let names = [
            "Food and drink",
            "Housing",
            "Transportation",
            "Healthcare",
            "Entertainment",
            "Other",
        ];
        let prices = [
            props.data.food_drink,
            props.data.housing,
            props.data.transportation,
            props.data.healthcare,
            props.data.entertainment,
            props.data.other,
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
    }
}
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="flex flex-col w-full px-1 mx-auto mt-12">
            <!-- Charts -->
            <div class="flex flex-col gap-2 md:flex-row">
                <!-- Average -->
                <div
                    class="flex justify-between w-full p-4 text-white rounded gap-x-2 md:w-1/2 bg-dark"
                >
                    <div v-if="data" class="w-1/4 my-auto chart-container">
                        <canvas id="avgmonthly"></canvas>
                    </div>
                    <div class="px-2 my-auto bg-red-600 rounded" v-else>
                        <a class="underline" :href="route('settings.show')"
                            >No Data Set</a
                        >
                    </div>
                    <h1 class="p-2 my-auto text-xl rounded glass">
                        Average Monthly Spendings
                    </h1>
                </div>
                <!-- In and Out -->
                <div
                    class="flex justify-between w-full p-4 text-white rounded gap-x-2 md:w-1/2 bg-dark"
                >
                    <div class="w-1/4 my-auto chart-container">
                        <canvas id="this-month"></canvas>
                    </div>
                    <h1 class="p-2 my-auto text-xl rounded glass">
                        This Month
                    </h1>
                    <div
                        v-if="balance"
                        class="flex flex-col font-bold gap-y-1 text-dark"
                    >
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
                    <div class="px-2 my-auto bg-red-600 rounded" v-else>
                        <a class="underline" :href="route('settings.show')"
                            >No Balance Set</a
                        >
                    </div>
                </div>
            </div>
            <div class="flex flex-col md:mx-12 gap-x-4">
                <!-- Regular Incoming -->
                <div v-if="regularIncomingsState.length" class="mt-8">
                    <h1
                        class="p-2 px-3 mx-auto text-3xl text-center text-gray-300 border border-gray-400 rounded bg-dark w-fit"
                    >
                        Regular Incoming
                    </h1>

                    <div
                        class="grid grid-cols-1 gap-5 p-4 mx-auto mt-8 rounded md:grid-cols-2 grid-flow-auto bg-dark"
                    >
                        <div
                            class="col-span-1"
                            v-for="regularIncoming in regularIncomingsState.slice(
                                0,
                                incomingLimit
                            )"
                            :key="regularIncoming.id"
                        >
                            <!-- Slide Down Animation -->
                            <Transition
                                mode="out-in"
                                enter-from-class="translate-x-8 opacity-0"
                                leave-to-class="translate-x-8 opacity-0"
                                enter-active-class="transition duration-200 ease-out ease-in-out delay-100"
                                leave-active-class="transition duration-100 ease-in ease-in-out delay-100"
                                appear
                            >
                                <RegularContainer
                                    type="incoming"
                                    :regular="regularIncoming"
                                    @delete="
                                        openDeleteModal(
                                            regularIncoming.id,
                                            'incoming'
                                        )
                                    "
                                />
                            </Transition>
                        </div>

                        <button
                            class="col-span-1 p-1 text-3xl text-center duration-100 border-2 rounded md:col-span-2 hover:py-2 border-blue text-blue bg-light"
                            @click="increaseLimit('incoming', -4)"
                        >
                            <FontAwesomeIcon
                                :icon="faChevronUp"
                            ></FontAwesomeIcon>
                        </button>
                        <button
                            class="col-span-1 p-1 text-3xl text-center duration-100 border-2 rounded md:col-span-2 hover:py-2 border-blue text-blue bg-light"
                            @click="increaseLimit('incoming', 4)"
                        >
                            <FontAwesomeIcon
                                :icon="faChevronDown"
                            ></FontAwesomeIcon>
                        </button>
                    </div>
                </div>
                <div
                    v-else
                    class="px-2 py-1 my-auto mt-8 text-lg font-bold text-center text-white bg-red-600 rounded"
                >
                    No Incoming payments
                </div>

                <!-- Regular Outgoing -->
                <div v-if="regularPaymentsState.length" class="mt-8">
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
                            v-for="regularPayment in regularPaymentsState.slice(
                                0,
                                paymentLimit
                            )"
                            :key="regularPayment.id"
                        >
                            <Transition
                                mode="out-in"
                                enter-from-class="translate-x-8 opacity-0"
                                leave-to-class="translate-x-8 opacity-0"
                                enter-active-class="transition duration-200 ease-out ease-in-out delay-100"
                                leave-active-class="transition duration-100 ease-in ease-in-out delay-100"
                                appear
                            >
                                <RegularContainer
                                    type="outgoing"
                                    :regular="regularPayment"
                                    @delete="
                                        openDeleteModal(
                                            regularPayment.id,
                                            'payment'
                                        )
                                    "
                                />
                            </Transition>
                        </div>
                        <button
                            class="col-span-1 p-1 text-3xl text-center duration-100 border-2 rounded md:col-span-2 hover:py-2 border-blue text-blue bg-light"
                            @click="increaseLimit('payment', -4)"
                        >
                            <FontAwesomeIcon
                                :icon="faChevronUp"
                            ></FontAwesomeIcon>
                        </button>
                        <button
                            class="col-span-1 p-1 text-3xl text-center duration-100 border-2 rounded md:col-span-2 hover:py-2 border-blue text-blue bg-light"
                            @click="increaseLimit('payment', 4)"
                        >
                            <FontAwesomeIcon
                                :icon="faChevronDown"
                            ></FontAwesomeIcon>
                        </button>
                    </div>
                </div>

                <div
                    v-else
                    class="px-2 py-1 my-auto mt-8 text-lg font-bold text-center text-white bg-red-600 rounded"
                >
                    No Incoming payments
                </div>
            </div>
        </div>
    </AppLayout>
    <!-- Confirmation Modal -->
    <ConfirmationModal
        v-if="showDeleteModal"
        :show="showDeleteModal"
        @close="showDeleteModal = false"
        @confirm="confirmDelete"
        title="Confirm Delete"
        message="Are you sure you want to delete this payment? This action cannot be undone."
    />
</template>
