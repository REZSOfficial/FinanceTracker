<script setup>
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
defineProps({
    type: {
        type: String,
        default: "submit",
    },
    icon: {
        type: Object,
        default: null,
    },
});
</script>

<template>
    <button
        :type="type"
        class="px-4 py-2 text-sm font-semibold tracking-widest text-center text-white uppercase transition duration-150 ease-in-out border border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50"
    >
        <div class="hidden md:block">
            <slot />
        </div>
        <div v-if="icon" class="block md:hidden">
            <FontAwesomeIcon class="text-xl" :icon="icon"></FontAwesomeIcon>
        </div>
    </button>
</template>
