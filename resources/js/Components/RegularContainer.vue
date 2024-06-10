<script setup>
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import {
    faBurger,
    faCar,
    faHouse,
    faNotesMedical,
    faGift,
    faWandMagic,
} from "@fortawesome/free-solid-svg-icons";

const props = defineProps({
    regular: Object,
    monthsLeft: Array,
});
</script>

<template>
    <div
        class="flex justify-between p-4 text-xl text-white rounded bg-light gap-x-3"
    >
        <div class="w-1/2 p-6 py-12 text-center rounded bg-dark">
            <FontAwesomeIcon
                class="p-3 text-2xl text-black bg-red-600 rounded-full"
                v-if="regular.type === 'food_drink'"
                :icon="faBurger"
            ></FontAwesomeIcon>
            <FontAwesomeIcon
                class="p-3 text-2xl text-black bg-blue-600 rounded-full"
                v-if="regular.type === 'transportation'"
                :icon="faCar"
            ></FontAwesomeIcon>
            <FontAwesomeIcon
                class="p-3 text-2xl text-white rounded-full bg-orange-950"
                v-if="regular.type === 'housing'"
                :icon="faHouse"
            ></FontAwesomeIcon>
            <FontAwesomeIcon
                class="p-3 text-2xl text-white bg-red-700 rounded-full"
                v-if="regular.type === 'healthcare'"
                :icon="faNotesMedical"
            ></FontAwesomeIcon>
            <FontAwesomeIcon
                class="p-3 text-2xl bg-blue-700 rounded-full"
                v-if="regular.type === 'entertainment'"
                :icon="faGift"
            ></FontAwesomeIcon>
            <FontAwesomeIcon
                class="p-3 text-2xl bg-purple-900 rounded-full"
                v-if="regular.type === 'other'"
                :icon="faWandMagic"
            ></FontAwesomeIcon>
            <p>{{ regular.title }}</p>
        </div>
        <div class="flex flex-col justify-between w-full text-center">
            <p class="text-white">
                <span class="text-green-600">{{
                    Math.round(
                        regular.period +
                            monthsLeft.find((obj) => obj.id === regular.id)
                                .monthsDiff
                    )
                }}</span
                >/<span class="text-green-600">{{ regular.period }}</span>
                months left
            </p>
            <p class="text-green-600">+{{ regular.amount }}$</p>
            <div>
                <div
                    class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700"
                >
                    <div
                        class="bg-green-600 h-2.5 rounded-full"
                        :style="{
                            width: `${
                                (1 -
                                    Math.round(
                                        regular.period +
                                            monthsLeft.find(
                                                (obj) => obj.id === regular.id
                                            ).monthsDiff
                                    ) /
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
                                Math.round(
                                    regular.period +
                                        monthsLeft.find(
                                            (obj) => obj.id === regular.id
                                        ).monthsDiff
                                ) /
                                    regular.period) *
                            100
                        ).toFixed(0)
                    }}%
                </p>
            </div>
        </div>
    </div>
</template>
