<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faChevronDown } from "@fortawesome/free-solid-svg-icons";
import Accordion from "@/Pages/Goals/Partials/Accordion.vue";
import { ref } from "vue";
import axios from "axios";
import convertGeneratedRespose from "../../Utils/convertGeneratedResponse";
const props = defineProps({
    goals: Object,
});

const openAccordionId = ref(null);
const loading = ref(false);
const generatedResponse = ref(null);

const toggleAccordion = (goalId) => {
    if (openAccordionId.value === goalId) {
        openAccordionId.value = null;
    } else {
        openAccordionId.value = goalId;
    }
};

const handleSuggestion = (goalId) => {
    loading.value = true;
    generatedResponse.value = null;
    axios
        .post(route("generateResponse"), {
            goalId: goalId,
        })
        .then((response) => {
            generatedResponse.value = convertGeneratedRespose(
                response.data.response
            );
        })
        .then(() => {
            loading.value = false;
        });
};
</script>

<template>
    <AppLayout title="Goals">
        <div
            class="flex flex-col w-2/3 p-3 mx-auto mt-8 text-sm text-gray-200 rounded-lg gap-y-2 glass min-w-fit sm:text-2xl"
        >
            <div v-if="goals.length === 0">No goals yet</div>
            <div v-else v-for="goal in goals" :key="goal.id">
                <div
                    class="flex justify-between p-3 border rounded-t-lg border-lighter glass min-w-fit"
                >
                    <h1>{{ goal.title }}</h1>

                    <FontAwesomeIcon
                        class="p-1 duration-200 hover:rounded-full hover:cursor-pointer hover:text-dark hover:bg-white"
                        :icon="faChevronDown"
                        @click="toggleAccordion(goal.id)"
                    ></FontAwesomeIcon>
                </div>
                <Accordion :show="openAccordionId === goal.id">
                    <div class="flex flex-col text-lg gap-y-4">
                        <p>
                            <strong>Description:</strong> {{ goal.description }}
                        </p>
                        <p>
                            <strong>Amount: </strong>
                            <span class="font-bold text-green-600"
                                >{{ goal.price }}$</span
                            >
                        </p>
                        <p>
                            <strong>Date: </strong>
                            <span>{{ goal.date }}</span>
                        </p>
                        <PrimaryButton
                            @click.prevent="handleSuggestion(goal.id)"
                            class="text-xs bg-green-600"
                            >Get Suggestion</PrimaryButton
                        >
                    </div>
                </Accordion>
            </div>
            <p v-if="loading">Loading...</p>
            <p
                class="text-green-600 text-md"
                v-if="generatedResponse"
                v-html="generatedResponse"
            ></p>
        </div>
    </AppLayout>
</template>
