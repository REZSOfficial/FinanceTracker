<script setup>
import FontAwesomeSwitch from "@/Components/FontAwesomeSwitch.vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faRepeat } from "@fortawesome/free-solid-svg-icons";
const props = defineProps({
    payments: {
        type: Object,
        default: null,
    },
    type: {
        type: String,
        default: "outgoing",
    },
});
</script>

<template>
    <div
        class="p-4 mx-auto overflow-auto text-xl text-white border rounded md:w-full w-6/7 max-h-1/2 glass"
    >
        <h1
            class="p-2 mx-auto mt-2 mb-4 border-2 w-fit"
            v-if="type === 'outgoing'"
        >
            Outgoing
        </h1>
        <h1 class="p-2 mx-auto mt-2 mb-4 border-2 w-fit" v-else>Incoming</h1>
        <div
            class="flex justify-between p-2 px-4 my-2 rounded min-w-fit bg-light"
            v-for="payment in payments"
            :key="payment.id"
        >
            <div class="flex gap-x-2">
                <FontAwesomeSwitch :payment="payment" />
                <h1 class="my-auto">
                    {{ payment.title }}
                </h1>
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
                        {{ payment.amount }}$
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
