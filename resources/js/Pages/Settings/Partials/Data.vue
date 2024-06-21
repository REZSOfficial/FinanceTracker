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
        <div class="flex gap-x-2">
            <FontAwesomeSwitch :type="'food_drink'"></FontAwesomeSwitch>
            <div class="w-full">
                <label for="food_drink">Food and Drink</label>
                <input
                    id="food_drink"
                    type="number"
                    class="w-full border-0 rounded bg-dark"
                    name="food_drink"
                    v-model="dataForm.food_drink"
                />
            </div>
            <p class="mt-auto text-4xl text-green-600">$</p>
        </div>
        <div class="flex gap-x-2">
            <FontAwesomeSwitch :type="'housing'"></FontAwesomeSwitch>
            <div class="w-full">
                <label for="housing">Housing</label>
                <input
                    id="housing"
                    type="number"
                    class="w-full border-0 rounded bg-dark"
                    name="housing"
                    v-model="dataForm.housing"
                />
            </div>
            <p class="mt-auto text-4xl text-green-600">$</p>
        </div>
        <div class="flex gap-x-2">
            <FontAwesomeSwitch :type="'transportation'"></FontAwesomeSwitch>
            <div class="w-full">
                <label for="transportation">Transportation</label>
                <input
                    id="transportation"
                    type="number"
                    class="w-full border-0 rounded bg-dark"
                    name="transportation"
                    v-model="dataForm.transportation"
                />
            </div>
            <p class="mt-auto text-4xl text-green-600">$</p>
        </div>
        <div class="flex gap-x-2">
            <FontAwesomeSwitch :type="'healthcare'"></FontAwesomeSwitch>
            <div class="w-full">
                <label for="healthcare">Healthcare</label>
                <input
                    id="healthcare"
                    type="number"
                    class="w-full border-0 rounded bg-dark"
                    name="healthcare"
                    v-model="dataForm.healthcare"
                />
            </div>
            <p class="mt-auto text-4xl text-green-600">$</p>
        </div>
        <div class="flex gap-x-2">
            <FontAwesomeSwitch :type="'entertainment'"></FontAwesomeSwitch>
            <div class="w-full">
                <label for="entertainment">Entertainment</label>
                <input
                    id="entertainment"
                    type="number"
                    class="w-full border-0 rounded bg-dark"
                    name="entertainment"
                    v-model="dataForm.entertainment"
                />
            </div>
            <p class="mt-auto text-4xl text-green-600">$</p>
        </div>
        <div class="flex gap-x-2">
            <FontAwesomeSwitch :type="'other'"></FontAwesomeSwitch>
            <div class="w-full">
                <label for="other">Other</label>
                <input
                    id="other"
                    type="number"
                    class="w-full border-0 rounded bg-dark"
                    name="other"
                    v-model="dataForm.other"
                />
            </div>
            <p class="mt-auto text-4xl text-green-600">$</p>
        </div>
        <div class="flex flex-row my-auto">
            <ActionMessage
                class="w-5/6 my-auto text-center"
                :on="dataForm.recentlySuccessful"
                >Saved.</ActionMessage
            >
            <PrimaryButton
                type="submit"
                class="w-1/6 bg-green-600 hover:bg-green-700"
                >Save</PrimaryButton
            >
        </div>
    </form>
</template>
