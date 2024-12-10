<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Data from "./Partials/Data.vue";
import Balance from "./Partials/Balance.vue";
import { ref } from "vue";
import Preferences from "./Partials/Preferences.vue";
import Currency from "./Partials/Currency.vue";

const page = ref("data");

const props = defineProps({
    data: Object,
    balance: Object,
    preferences: Object,
    currentCurrency: String,
});
</script>

<template>
    <AppLayout title="Settings">
        <div
            class="flex flex-col mx-auto mt-12 overflow-hidden border-2 rounded border-slate-200/25 sm:flex-row max-w-7xl bg-light text-lighter drop-shadow"
        >
            <div
                class="flex flex-col w-full py-6 rounded sm:px-4 lg:px-6 bg-dark sm:me-3 sm:w-1/6 gap-y-3"
            >
                <p
                    :class="page === 'data' ? 'glass' : ''"
                    @click="page = 'data'"
                    class="p-2 px-3 duration-100 rounded cursor-pointer hover:glass hover:bg-gray-700"
                >
                    Data
                </p>
                <p
                    :class="page === 'balance' ? 'glass' : ''"
                    @click="page = 'balance'"
                    class="p-2 px-3 duration-100 rounded cursor-pointer hover:bg-gray-700"
                >
                    Balance
                </p>

                <p
                    :class="page === 'preferences' ? 'glass' : ''"
                    @click="page = 'preferences'"
                    class="p-2 px-3 duration-100 rounded cursor-pointer hover:glass hover:bg-gray-700"
                >
                    Preferences
                </p>
                <p
                    :class="page === 'currency' ? 'glass' : ''"
                    @click="page = 'currency'"
                    class="p-2 px-3 duration-100 rounded cursor-pointer hover:glass hover:bg-gray-700"
                >
                    Currency
                </p>
            </div>
            <div class="w-full py-6 sm:px-6 lg:px-8">
                <Transition
                    enter-active-class="transition ease-out duration-800"
                    enter-from-class="transform scale-50 opacity-0"
                    enter-to-class="transform scale-100 opacity-100"
                >
                    <Data
                        v-if="page === 'data'"
                        :data="props.data ? props.data : null"
                    ></Data>
                </Transition>
                <Transition
                    enter-active-class="transition ease-out duration-800"
                    enter-from-class="transform scale-50 opacity-0"
                    enter-to-class="transform scale-100 opacity-100"
                >
                    <Balance
                        :balance="props.balance ? props.balance.balance : null"
                        v-if="page === 'balance'"
                    ></Balance>
                </Transition>
                <Transition
                    enter-active-class="transition ease-out duration-800"
                    enter-from-class="transform scale-50 opacity-0"
                    enter-to-class="transform scale-100 opacity-100"
                >
                    <Preferences
                        :preferences="
                            props.preferences ? props.preferences : null
                        "
                        v-if="page === 'preferences'"
                    ></Preferences>
                </Transition>
                <Transition
                    enter-active-class="transition ease-out duration-800"
                    enter-from-class="transform scale-50 opacity-0"
                    enter-to-class="transform scale-100 opacity-100"
                >
                    <Currency
                        :currency="props.currentCurrency"
                        v-if="page === 'currency'"
                    ></Currency>
                </Transition>
            </div>
        </div>
    </AppLayout>
</template>
