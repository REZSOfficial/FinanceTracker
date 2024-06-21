<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Data from "./Partials/Data.vue";
import Balance from "./Partials/Balance.vue";
import { ref } from "vue";

const page = ref("data");

const props = defineProps({
    data: Object,
});
</script>

<template>
    <AppLayout title="Settings">
        <div
            class="flex flex-col py-10 mx-auto mt-12 rounded-lg sm:flex-row max-w-7xl sm:px-6 lg:px-8 bg-light text-lighter drop-shadow"
        >
            <div
                class="flex flex-col w-full mx-auto mb-12 sm:me-3 sm:w-1/6 gap-y-3"
            >
                <p
                    :class="page === 'balance' ? 'glass' : ''"
                    @click="page = 'balance'"
                    class="p-2 px-3 duration-100 rounded cursor-pointer hover:bg-gray-700"
                >
                    Balance
                </p>
                <p
                    :class="page === 'data' ? 'glass' : ''"
                    @click="page = 'data'"
                    class="p-2 px-3 duration-100 rounded cursor-pointer hover:glass hover:bg-gray-700"
                >
                    Data
                </p>
                <p
                    :class="page === 'preferences' ? 'glass' : ''"
                    @click="page = 'preferences'"
                    class="p-2 px-3 duration-100 rounded cursor-pointer hover:glass hover:bg-gray-700"
                >
                    Preferences
                </p>
            </div>
            <Transition
                enter-active-class="transition ease-out duration-400"
                enter-from-class="transform scale-50 opacity-0"
                enter-to-class="transform scale-100 opacity-100"
            >
                <Data
                    v-if="page === 'data'"
                    :data="props.data ? props.data : null"
                ></Data>
            </Transition>
            <Transition
                enter-active-class="transition ease-out duration-400"
                enter-from-class="transform scale-50 opacity-0"
                enter-to-class="transform scale-100 opacity-100"
            >
                <Balance v-if="page === 'balance'"></Balance>
            </Transition>
        </div>
    </AppLayout>
</template>
