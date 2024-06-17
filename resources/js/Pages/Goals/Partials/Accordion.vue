<script setup>
const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    errors: {
        type: Object,
        default: () => {},
    },
});
</script>

<template>
    <Transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="transform scale-95 opacity-0"
        enter-to-class="transform scale-100 opacity-100"
        leave-active-class="transition duration-150 ease-in"
        leave-from-class="transform scale-100 opacity-100"
        leave-to-class="transform scale-95 opacity-0"
    >
        <div
            class="p-2 border border-t-0 rounded-b border-lighter"
            v-show="show"
        >
            <slot />
        </div>
    </Transition>
</template>
