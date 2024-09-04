<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? "border-2 border-blue rounded-xl flex items-center h-fit px-3 py-1 bg-dark text-white font-bold text-[0.9rem] text-blue"
        : "border-2 text-blue bg-dark border-transparent hover:-translate-y-1 rounded-xl flex items-center text-lighter h-fit px-3 py-1 text-[0.9rem] hover:bg-dark duration-200";
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
