<script setup>
import PrimaryButton from "./PrimaryButton.vue";
import InputError from "./InputError.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faLock, faX } from "@fortawesome/free-solid-svg-icons";

let is_regular = ref(false);

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

const form = useForm({
    _method: "POST",
    title: "",
    amount: "",
    regular: "0",
    period: "",
    type: "",
    type_of_payment: "",
});

const submitForm = () => {
    form.post(route("createOutgoing"));
};
</script>

<template>
    <transition
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
        enter-to-class="transition duration-200 ease-in"
        enter-from-class="opacity-0"
    >
        <div
            v-show="show"
            id="incomingform"
            class="fixed z-50 w-1/2 p-2 py-4 text-white -translate-x-1/2 -translate-y-1/2 border-2 rounded-lg border-blue bg-light top-1/2 left-1/2"
        >
            <form
                @submit.prevent="submitForm"
                class="flex flex-col"
                method="POST"
            >
                <div class="flex justify-between mx-8 text-3xl">
                    <div class="mb-8 font-bold">Create Outgoing Payment</div>
                    <FontAwesomeIcon
                        @click="$emit('close')"
                        :icon="faX"
                        class="text-red-500 hover:cursor-pointer"
                    ></FontAwesomeIcon>
                </div>
                <div class="flex flex-col w-2/3 mx-auto gap-y-2">
                    <div>
                        <label class="required" for="title">Title</label>
                        <input
                            v-model="form.title"
                            id="out-title"
                            type="text"
                            class="w-full border-0 rounded bg-dark"
                            name="title"
                        />
                        <InputError :message="form.errors.title" />
                    </div>

                    <div>
                        <label class="required" for="amount">Amount</label>
                        <input
                            v-model="form.amount"
                            id="out-amount"
                            type="number"
                            class="w-full border-0 rounded bg-dark"
                            name="amount"
                        />
                        <InputError :message="form.errors.amount" />
                    </div>

                    <div>
                        <label class="required" for="regular">Regular</label>
                        <select
                            v-model="form.regular"
                            id="out-regular"
                            class="w-full border-0 rounded bg-dark"
                            name="regular"
                            @change="is_regular = !is_regular"
                        >
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        <InputError :message="form.errors.regular" />
                    </div>

                    <div>
                        <label for="period"
                            >Period
                            <FontAwesomeIcon
                                v-if="!is_regular"
                                :icon="faLock"
                                class="text-red-500"
                            ></FontAwesomeIcon
                        ></label>
                        <input
                            :disabled="!is_regular"
                            v-model="form.period"
                            id="out-period"
                            type="number"
                            class="w-full duration-300 border-2 border-transparent rounded bg-dark"
                            name="period"
                            :class="
                                !is_regular ? ' border-red-500 bg-red-900' : ''
                            "
                        />

                        <InputError :message="form.errors.period" />
                    </div>

                    <div>
                        <label class="required" for="type">Type</label>
                        <select
                            v-model="form.type"
                            id="out-type"
                            class="w-full border-0 rounded bg-dark"
                            name="type"
                        >
                            <option value="food_drink">Food and drink</option>
                            <option value="housing">Housing</option>
                            <option value="transportation">
                                Transportation
                            </option>
                            <option value="healthcare">Healthcare</option>
                            <option value="entertainment">Entertainment</option>
                            <option value="other">Other</option>
                        </select>
                        <InputError :message="form.errors.type" />
                    </div>

                    <div class="mb-3 row">
                        <label class="required" for="type_of_payment"
                            >Payment Type</label
                        >
                        <select
                            v-model="form.type_of_payment"
                            id="out-type-of-payment"
                            class="w-full border-0 rounded bg-dark"
                            name="type_of_payment"
                        >
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                        </select>
                        <InputError :message="form.errors.type_of_payment" />
                    </div>

                    <div>
                        <div>
                            <PrimaryButton
                                type="submit"
                                class="w-full bg-green-600 hover:bg-green-700"
                            >
                                Add
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </transition>
</template>
