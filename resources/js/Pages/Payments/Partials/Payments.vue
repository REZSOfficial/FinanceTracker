<script setup>
import FontAwesomeSwitch from "@/Components/FontAwesomeSwitch.vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faRepeat } from "@fortawesome/free-solid-svg-icons";
import { ref, computed } from "vue";

const props = defineProps({
    payments: {
        type: Array, // Array of payment objects
        default: () => [],
    },
    type: {
        type: String, // "outgoing" or "incoming"
        default: "outgoing",
    },
});

// Filter state
const filters = ref({
    category: "", // Category like 'entertainment', 'healthcare', etc.
    regular: "", // 'regular', 'not_regular', or ''
    minAmount: 0,
    maxAmount: 10000000,
});

// Computed property for filtered payments
const filteredPayments = computed(() => {
    return props.payments.filter((payment) => {
        const matchesCategory =
            !filters.value.category || payment.type === filters.value.category;

        const matchesRegular =
            filters.value.regular === "" ||
            (filters.value.regular === "regular" && payment.regular) ||
            (filters.value.regular === "not_regular" && !payment.regular);

        const matchesAmount =
            payment.amount >= filters.value.minAmount &&
            payment.amount <= filters.value.maxAmount;

        return matchesCategory && matchesRegular && matchesAmount;
    });
});
</script>

<template>
    <h1
        class="p-4 text-3xl font-bold text-center border-b-2 drop-shadow border-blue glass rounded-t-2xl text-blue"
    >
        {{ type === "outgoing" ? "Outgoing" : "Incoming" }}
    </h1>
    <div
        class="p-3 mx-auto overflow-auto text-xl rounded-b-2xl text-white/90 md:w-full w-6/7 max-h-1/2 glass"
    >
        <!-- Filter UI -->
        <div class="flex flex-col gap-4 my-3">
            <!-- Category Filter -->
            <div class="flex flex-row w-full gap-2">
                <select v-model="filters.category" class="filter-input">
                    <option value="">All Categories</option>
                    <option value="entertainment">Entertainment</option>
                    <option value="healthcare">Healthcare</option>
                    <option value="food">Food</option>
                    <option value="housing">Housing</option>
                    <option value="transportation">Transportation</option>
                    <option value="other">Other</option>
                    <!-- Add more categories as needed -->
                </select>

                <!-- Regular/Not Regular Filter -->
                <select v-model="filters.regular" class="filter-input">
                    <option value="">All</option>
                    <option value="regular">Regular</option>
                    <option value="not_regular">Not Regular</option>
                </select>
            </div>
            <!-- Min/Max Amount Filters -->
            <div class="flex flex-row w-full gap-2">
                <div class="w-full p-2 text-white rounded">
                    <label>Min: </label>
                    <input
                        type="number"
                        v-model="filters.minAmount"
                        min="0"
                        max="10000000"
                        class="filter-input"
                    />
                </div>

                <div class="w-full p-2 text-white rounded">
                    <label>Max: </label>
                    <input
                        type="number"
                        v-model="filters.maxAmount"
                        min="0"
                        max="10000000"
                        class="filter-input"
                    />
                </div>
            </div>
        </div>

        <!-- Display Payments -->
        <div
            class="flex justify-between p-4 mt-3 rounded-2xl min-w-fit bg-light drop-shadow"
            v-for="payment in filteredPayments"
            :key="payment.id"
        >
            <div class="flex gap-x-2">
                <FontAwesomeSwitch :payment="payment" />
                <h1 class="my-auto">{{ payment.title }}</h1>
            </div>
            <div class="flex flex-col gap-2 my-auto">
                <div class="flex justify-end gap-x-1">
                    <p
                        :class="
                            type === 'outgoing'
                                ? 'text-red-600'
                                : 'text-green-600'
                        "
                    >
                        {{ payment.amount }}
                        {{ $page.props.auth.user.currency }}
                    </p>
                    <FontAwesomeIcon
                        :icon="faRepeat"
                        class="my-auto text-gray-200"
                        v-if="payment.regular"
                    ></FontAwesomeIcon>
                </div>
                <p class="text-sm">{{ payment.created_at.split(" ")[0] }}</p>
            </div>
        </div>
    </div>
</template>
