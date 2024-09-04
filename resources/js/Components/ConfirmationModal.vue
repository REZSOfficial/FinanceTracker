<script setup>
const props = defineProps({
    show: Boolean,
    title: String,
    message: String,
});

const emit = defineEmits(["close", "confirm"]);

function close() {
    emit("close");
}

function confirm() {
    emit("confirm");
}
</script>

<template>
    <div
        v-if="show"
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75"
    >
        <div
            class="w-full max-w-lg p-6 bg-white rounded-md shadow-lg bounce-animation"
        >
            <h2 class="mb-4 text-xl font-semibold text-gray-700">
                {{ title }}
            </h2>
            <p class="mb-6 text-gray-600">{{ message }}</p>
            <div class="flex justify-end gap-4">
                <button
                    @click="close"
                    class="px-4 py-2 text-white bg-gray-600 rounded hover:bg-gray-700"
                >
                    Cancel
                </button>
                <button
                    @click="confirm"
                    class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700"
                >
                    Confirm
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes bounce {
    0% {
        transform: translateY(-100%);
        animation-timing-function: ease-in;
    }
    40% {
        transform: translateY(0);
        animation-timing-function: ease-out;
    }
    60% {
        transform: translateY(-15%);
        animation-timing-function: ease-in;
    }
    80% {
        transform: translateY(0);
        animation-timing-function: ease-out;
    }
    100% {
        transform: translateY(0);
        animation-timing-function: ease-out;
    }
}

.bounce-animation {
    animation: bounce 0.5s ease-in-out;
}
</style>
