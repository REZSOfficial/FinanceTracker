<script setup>
import { useForm } from "@inertiajs/vue3";
import FontAwesomeSwitch from "../../Settings/Partials/FontAwesomeSwitchSettings.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ActionMessage from "@/Components/ActionMessage.vue";

const props = defineProps({
    data: Object,
});

const dataForm = useForm({
    food_drink: props.data ? props.data.food_drink : 0,
    housing: props.data ? props.data.housing : 0,
    transportation: props.data ? props.data.transportation : 0,
    healthcare: props.data ? props.data.healthcare : 0,
    entertainment: props.data ? props.data.entertainment : 0,
    other: props.data ? props.data.other : 0,
});
</script>

<template>
    <form
        @submit.prevent="dataForm.post(route('settings.update'))"
        class="flex flex-col w-5/6 mx-auto gap-y-6"
    >
        <div class="flex flex-col sm:flex-row gap-x-2">
            <FontAwesomeSwitch :type="'food_drink'"></FontAwesomeSwitch>
            <div class="w-full">
                <label for="food_drink">Food and Drink</label>
                <div class="flex gap-x-2">
                    <input
                        id="food_drink"
                        type="number"
                        class="w-full border-0 rounded bg-dark"
                        name="food_drink"
                        v-model="dataForm.food_drink"
                    />
                    <p class="mt-auto text-4xl text-green-600">$</p>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-x-2 sm:flex-row">
            <FontAwesomeSwitch :type="'housing'"></FontAwesomeSwitch>
            <div class="w-full">
                <label for="housing">Housing</label>
                <div class="flex gap-x-2">
                    <input
                        id="housing"
                        type="number"
                        class="w-full border-0 rounded bg-dark"
                        name="housing"
                        v-model="dataForm.housing"
                    />
                    <p class="mt-auto text-4xl text-green-600">$</p>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-x-2 sm:flex-row">
            <FontAwesomeSwitch :type="'transportation'"></FontAwesomeSwitch>
            <div class="w-full">
                <label for="transportation">Transportation</label>
                <div class="flex gap-x-2">
                    <input
                        id="transportation"
                        type="number"
                        class="w-full border-0 rounded bg-dark"
                        name="transportation"
                        v-model="dataForm.transportation"
                    />
                    <p class="mt-auto text-4xl text-green-600">$</p>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-x-2 sm:flex-row">
            <FontAwesomeSwitch :type="'healthcare'"></FontAwesomeSwitch>
            <div class="w-full">
                <label for="healthcare">Healthcare</label>
                <div class="flex gap-x-2">
                    <input
                        id="healthcare"
                        type="number"
                        class="w-full border-0 rounded bg-dark"
                        name="healthcare"
                        v-model="dataForm.healthcare"
                    />
                    <p class="mt-auto text-4xl text-green-600">$</p>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-x-2 sm:flex-row">
            <FontAwesomeSwitch :type="'entertainment'"></FontAwesomeSwitch>
            <div class="w-full">
                <label for="entertainment">Entertainment</label>
                <div class="flex gap-x-2">
                    <input
                        id="entertainment"
                        type="number"
                        class="w-full border-0 rounded bg-dark"
                        name="entertainment"
                        v-model="dataForm.entertainment"
                    />
                    <p class="mt-auto text-4xl text-green-600">$</p>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-x-2 sm:flex-row">
            <FontAwesomeSwitch :type="'other'"></FontAwesomeSwitch>
            <div class="w-full">
                <label for="other">Other</label>
                <div class="flex gap-x-2">
                    <input
                        id="other"
                        type="number"
                        class="w-full border-0 rounded bg-dark"
                        name="other"
                        v-model="dataForm.other"
                    />
                    <p class="mt-auto text-4xl text-green-600">$</p>
                </div>
            </div>
        </div>
        <div class="flex flex-row my-auto">
            <ActionMessage
                class="w-4/6 my-auto text-center"
                :on="dataForm.recentlySuccessful"
                >Saved.</ActionMessage
            >
            <PrimaryButton
                type="submit"
                class="w-4/6 bg-green-600 sm:w-2/6 hover:bg-green-700"
                >Save</PrimaryButton
            >
        </div>
    </form>
</template>
