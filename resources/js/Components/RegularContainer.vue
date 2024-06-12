<script setup>
import FontAwesomeSwitch from "./FontAwesomeSwitch.vue";
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
            <FontAwesomeSwitch :payment="regular"></FontAwesomeSwitch>
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
                    class="w-full border-2 border-green-800 rounded-full h-4.5 bg-gray-700 p-1"
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
