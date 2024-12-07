<script setup>
import { faX, faMagnifyingGlass } from "@fortawesome/free-solid-svg-icons";
import FontAwesomeSwitch from "./FontAwesomeSwitch.vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
const props = defineProps({
    regular: Object,
    type: String,
    currentCurrency: String,
});
</script>

<template>
    <div
        class="relative flex justify-between p-4 overflow-hidden text-xl text-white duration-100 rounded bg-light gap-x-3"
        :class="
            regular.remaining_months == 0
                ? 'border-red-600 dash-shadow-red'
                : 'border-transparent dash-shadow-green'
        "
    >
        <div class="absolute right-1 top-1">
            <FontAwesomeIcon
                class="text-white bg-indigo-600 rounded-s cursor-pointer h-[20px] w-[20px] p-2 hover:w-[25px] duration-100"
                :icon="faMagnifyingGlass"
                @click="$emit('showModal')"
            ></FontAwesomeIcon>
            <FontAwesomeIcon
                class="h-[20px] w-[20px] rounded-e p-2 text-white bg-red-600 cursor-pointer hover:w-[25px] duration-100"
                :icon="faX"
                @click="$emit('delete')"
            ></FontAwesomeIcon>
        </div>
        <div class="w-1/2 p-6 py-12 text-center rounded bg-dark">
            <FontAwesomeSwitch :payment="regular"></FontAwesomeSwitch>
            <p>{{ regular.title }}</p>
        </div>
        <div class="flex flex-col justify-between w-full text-center">
            <div class="flex justify-between">
                <p class="text-white">
                    <span class="text-green-600">{{
                        Math.round(regular.remaining_months)
                    }}</span
                    >/<span class="text-green-600">{{ regular.period }}</span>
                    months left
                </p>
            </div>
            <p v-if="type === 'incoming'" class="text-green-600">
                +{{ regular.amount }} {{ $page.props.auth.user.currency }}
            </p>
            <p v-else class="text-red-600">
                -{{ regular.amount }} {{ $page.props.auth.user.currency }}
            </p>
            <div>
                <div
                    class="w-full border-2 border-green-800 rounded-full h-4.5 bg-transparent p-1"
                >
                    <div
                        class="bg-green-600 h-2.5 rounded-full"
                        :style="{
                            width: `${
                                (1 -
                                    Math.round(regular.remaining_months) /
                                        regular.period) *
                                100
                            }%`,
                        }"
                    ></div>
                </div>
                <p class="mt-1">
                    {{
                        (
                            (1 -
                                Math.round(regular.remaining_months) /
                                    regular.period) *
                            100
                        ).toFixed(0)
                    }}%
                </p>
            </div>
        </div>
    </div>
</template>
