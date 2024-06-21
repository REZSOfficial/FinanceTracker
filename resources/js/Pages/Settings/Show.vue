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
            <div class="w-1/6 mx-auto mb-12">
                <p @click="page = 'balance'" class="cursor-pointer">Balance</p>
                <p @click="page = 'data'" class="cursor-pointer">Data</p>
                <p @click="page = 'preferences'" class="cursor-pointer">
                    Preferences
                </p>
            </div>
            <Data
                v-if="page === 'data'"
                :data="props.data ? props.data : null"
            ></Data>

            <Balance v-if="page === 'balance'"></Balance>
        </div>
    </AppLayout>
</template>
