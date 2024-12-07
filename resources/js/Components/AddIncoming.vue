<script setup>
import PrimaryButton from "./PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import {
    faLock,
    faX,
    faCheck,
    faMoneyBill,
    faCreditCard,
    faPlus,
    faMinus,
} from "@fortawesome/free-solid-svg-icons";
import InputError from "./InputError.vue";
import FontAwesomeSwitch from "./FontAwesomeSwitch.vue";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
});

const incoming = ref(false);

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
    if (incoming.value) {
        form.post(route("createIncoming"));
    } else {
        form.post(route("createOutgoing"));
    }
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
                    <div class="mb-8 font-bold">
                        Create
                        <span class="text-green-600" v-if="incoming"
                            >Incoming</span
                        ><span class="text-red-600" v-else>Outgoing</span>
                        Payment
                    </div>
                    <FontAwesomeIcon
                        @click="$emit('close')"
                        :icon="faX"
                        class="text-red-500 hover:cursor-pointer"
                    ></FontAwesomeIcon>
                </div>
                <div class="flex flex-col w-2/3 mx-auto gap-y-4">
                    <div class="flex gap-2 text-center">
                        <div class="w-full">
                            <label>Incoming</label>
                            <div
                                class="flex items-center rounded justify-center border-2 duration-100 hover:bg-green-500 border-green-600 h-[40px] hover:cursor-pointer"
                                :class="incoming ? 'bg-green-600' : ''"
                                @click="incoming = true"
                            >
                                <FontAwesomeIcon
                                    :icon="faPlus"
                                    class="text-xl"
                                ></FontAwesomeIcon>
                            </div>
                        </div>
                        <div class="w-full">
                            <label>Outgoing</label>
                            <div
                                class="flex items-center rounded justify-center w-full hover:bg-red-500 duration-100 h-[40px] border-2 border-red-600 hover:cursor-pointer"
                                :class="!incoming ? 'bg-red-600' : ''"
                                @click="incoming = false"
                            >
                                <FontAwesomeIcon
                                    :icon="faMinus"
                                    class="text-xl"
                                ></FontAwesomeIcon>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="title" class="required">Title</label>
                        <input
                            v-model="form.title"
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
                            type="number"
                            class="w-full border-0 rounded bg-dark"
                            name="amount"
                        />
                        <InputError :message="form.errors.amount" />
                    </div>

                    <div class="switch-container">
                        <label class="required switch-label" for="regular"
                            >Regular</label
                        >
                        <select
                            v-model="form.regular"
                            class="switch-select"
                            name="regular"
                            hidden
                            @change="is_regular = !is_regular"
                        >
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        <div class="flex gap-2">
                            <div
                                class="flex items-center rounded justify-center border-2 duration-100 hover:bg-green-500 border-green-600 w-full h-[40px] hover:cursor-pointer"
                                :class="
                                    form.regular === '1' ? 'bg-green-600' : ''
                                "
                                @click="form.regular = '1'"
                            >
                                <FontAwesomeIcon
                                    :icon="faCheck"
                                    class="text-xl"
                                ></FontAwesomeIcon>
                            </div>
                            <div
                                class="flex items-center rounded justify-center w-full hover:bg-red-500 duration-100 h-[40px] border-2 border-red-600 hover:cursor-pointer"
                                :class="
                                    form.regular === '0' ? 'bg-red-600' : ''
                                "
                                @click="form.regular = '0'"
                            >
                                <FontAwesomeIcon
                                    :icon="faX"
                                    class="text-xl"
                                ></FontAwesomeIcon>
                            </div>
                        </div>
                        <InputError :message="form.errors.regular" />
                    </div>

                    <div>
                        <label for="period"
                            >Period
                            <FontAwesomeIcon
                                v-if="form.regular == '0'"
                                :icon="faLock"
                                class="text-red-500"
                            ></FontAwesomeIcon>
                        </label>
                        <input
                            :disabled="form.regular == '0'"
                            v-model="form.period"
                            type="number"
                            class="w-full duration-300 border-2 border-transparent rounded bg-dark"
                            name="period"
                            :class="
                                form.regular == '0'
                                    ? 'border-2 border-red-500 bg-red-900'
                                    : ''
                            "
                        />

                        <InputError :message="form.errors.period" />
                    </div>

                    <div>
                        <label class="required" for="type">Type</label>
                        <div class="flex flex-wrap justify-between">
                            <div
                                class="duration-100 hover:-translate-y-1 hover:cursor-pointer"
                                @click="form.type = type"
                                :class="
                                    form.type === type ? 'selected-type' : ''
                                "
                                v-for="type in [
                                    'food_drink',
                                    'housing',
                                    'transportation',
                                    'healthcare',
                                    'entertainment',
                                    'other',
                                ]"
                            >
                                <FontAwesomeSwitch
                                    :type="type"
                                ></FontAwesomeSwitch>
                            </div>
                            <select
                                hidden
                                v-model="form.type"
                                class="w-full border-0 rounded bg-dark"
                                name="type"
                            >
                                <option value="food_drink">
                                    Food and drink
                                </option>
                                <option value="housing">Housing</option>
                                <option value="transportation">
                                    Transportation
                                </option>
                                <option value="healthcare">Healthcare</option>
                                <option value="entertainment">
                                    Entertainment
                                </option>
                                <option value="other">Other</option>
                            </select>
                            <InputError :message="form.errors.type" />
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="required" for="type_of_payment"
                            >Payment Type</label
                        >
                        <div>
                            <select
                                hidden
                                v-model="form.type_of_payment"
                                class="w-full border-0 rounded bg-dark"
                                name="type_of_payment"
                            >
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                            </select>
                            <div class="flex gap-1 h-[40px]">
                                <div
                                    class="flex items-center justify-center w-full duration-100 border-2 border-green-600 rounded hover:bg-green-500 hover:cursor-pointer"
                                    :class="
                                        form.type_of_payment === 'cash'
                                            ? 'bg-green-600'
                                            : ''
                                    "
                                    @click="form.type_of_payment = 'cash'"
                                >
                                    <FontAwesomeIcon
                                        class="text-xl"
                                        :icon="faMoneyBill"
                                    />
                                </div>
                                <div
                                    class="flex items-center justify-center w-full duration-100 border-2 border-yellow-400 rounded hover:bg-yellow-300 hover:cursor-pointer"
                                    @click="form.type_of_payment = 'card'"
                                    :class="
                                        form.type_of_payment === 'card'
                                            ? 'bg-yellow-400'
                                            : ''
                                    "
                                >
                                    <FontAwesomeIcon
                                        class="text-xl"
                                        :icon="faCreditCard"
                                    />
                                </div>
                            </div>
                            <InputError
                                :message="form.errors.type_of_payment"
                            />
                        </div>
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

<style scoped>
.selected-type {
    position: relative;
}
.selected-type::after {
    content: "✓";
    @apply bg-green-600 text-white rounded-full w-[20px] h-[20px] text-sm text-[15px] text-center flex items-center justify-center;
    top: -5px;
    right: -5px;
    position: absolute;
}
</style>
