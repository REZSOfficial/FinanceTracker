<script setup>
defineProps({
    on: Boolean,
});
</script>

<template>
    <div>
        <transition
            leave-active-class="transition duration-1000 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-show="on" class="text-sm text-lighter">
                <slot />
            </div>
        </transition>
    </div>
</template>
