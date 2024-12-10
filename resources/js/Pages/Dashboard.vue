<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import RegularContainer from "@/Components/RegularContainer.vue";
import PaymentModal from "@/Components/PaymentModal.vue";
import { Chart } from "chart.js/auto";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import {
    faChevronDown,
    faChevronUp,
    faEquals,
} from "@fortawesome/free-solid-svg-icons";
import axios from "axios";
import { onMounted, ref, Transition } from "vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";

const props = defineProps({
    regularPayments: Array,
    regularIncomings: Array,
    incomings: Array,
    payments: Array,
    data: Object,
    inAndOut: Object,
    balance: Object,
});

const showPaymentModal = ref(false); // To control the visibility
const selectedPayment = ref(null); // To store the current payment being shown

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

function openPaymentModal(payment) {
    selectedPayment.value = payment; // Store the payment information
    showPaymentModal.value = true; // Set modal visibility to true
}

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
        <PaymentModal
            class="fixed z-10"
            v-if="showPaymentModal"
            :payment="selectedPayment"
            @close="showPaymentModal = false"
        />
        <div class="flex flex-col w-full px-1 mx-auto mt-12">
            <!-- Charts -->
            <div class="flex flex-col gap-2 sm:px-6 md:flex-row">
                <!-- Average -->
                <div class="stat-container">
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
                <div class="stat-container">
                    <div class="w-1/4 my-auto chart-container">
                        <canvas id="this-month"></canvas>
                    </div>
                    <h1 class="p-2 my-auto text-xl rounded glass">
                        This Month
                    </h1>
                    <div
                        v-if="balance"
                        class="flex flex-col justify-between text-lg font-bold text-white"
                    >
                        <p>
                            <FontAwesomeIcon
                                class="text-red-600 me-2"
                                :icon="faChevronDown"
                            />{{ inAndOut.out }}&nbsp;<span
                                class="text-green-600"
                            >
                                {{ $page.props.auth.user.currency }}</span
                            >
                        </p>
                        <p>
                            <FontAwesomeIcon
                                class="text-green-600 me-2"
                                :icon="faChevronUp"
                            />{{ inAndOut.in }}&nbsp;<span
                                class="text-green-600"
                            >
                                {{ $page.props.auth.user.currency }}</span
                            >
                        </p>
                        <p>
                            <FontAwesomeIcon
                                class="text-orange-600 me-2"
                                :icon="faEquals"
                            />{{ inAndOut.in - inAndOut.out }}&nbsp;<span
                                class="text-green-600"
                            >
                                {{ $page.props.auth.user.currency }}</span
                            >
                        </p>
                        <p
                            class="p-1 px-4 text-center border-2 border-green-700 rounded-full bg-dark"
                        >
                            {{ balance.balance }}&nbsp;<span
                                class="text-green-600"
                            >
                                {{ $page.props.auth.user.currency }}</span
                            >
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
                    <h1 class="title">Regular Incoming</h1>

                    <div
                        class="grid grid-cols-1 gap-5 p-4 mx-auto mt-8 rounded-lg md:grid-cols-2 grid-flow-auto bg-dark/75"
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
                                    @showModal="
                                        openPaymentModal(regularIncoming)
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
                    No Incoming Payments
                </div>

                <!-- Regular Outgoing -->
                <div v-if="regularPaymentsState.length" class="mt-8">
                    <h1 class="title">Regular Outgoing</h1>
                    <div
                        class="grid grid-cols-1 gap-5 p-4 mx-auto mt-8 rounded-lg md:grid-cols-2 grid-flow-auto bg-dark/75"
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
                                    @showModal="
                                        openPaymentModal(regularPayment)
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
                    No Outgoing Payments
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
