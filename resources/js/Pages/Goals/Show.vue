<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import {
    faChevronDown,
    faTrash,
    faBullseye,
} from "@fortawesome/free-solid-svg-icons";
import Accordion from "@/Pages/Goals/Partials/Accordion.vue";
import { ref } from "vue";
import axios from "axios";
import convertGeneratedRespose from "../../Utils/convertGeneratedResponse";
import { router } from "@inertiajs/vue3";
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

const deleteGoal = (goalId) => {
    router.delete(route("deleteGoal", { id: goalId }));
};
</script>

<template>
    <AppLayout title="Goals">
        <div
            class="flex flex-col w-2/3 p-3 mx-auto mt-8 text-sm text-gray-200 rounded-lg gap-y-2 glass min-w-fit sm:text-2xl"
        >
            <PrimaryButton
                :icon="faBullseye"
                class="bg-yellow-600 hover:bg-yellow-700"
                ><a :href="route('createGoal')">Add Goal</a></PrimaryButton
            >
            <div class="flex justify-between" v-if="goals.length === 0">
                <h1 class="my-auto text-yellow-500">No Goals Yet</h1>
            </div>
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
                                >{{ goal.price
                                }}{{ $page.props.auth.user.currency }}</span
                            >
                        </p>
                        <p>
                            <strong>Date: </strong>
                            <span>{{ goal.date }}</span>
                        </p>
                        <div class="flex gap-3">
                            <PrimaryButton
                                @click.prevent="handleSuggestion(goal.id)"
                                class="w-full text-xs bg-green-600"
                                >Get Suggestion</PrimaryButton
                            >
                            <PrimaryButton
                                @click.prevent="deleteGoal(goal.id)"
                                class="text-xs bg-red-600"
                                ><FontAwesomeIcon
                                    :icon="faTrash"
                                ></FontAwesomeIcon
                            ></PrimaryButton>
                        </div>
                    </div>
                </Accordion>
            </div>
            <p v-if="loading" class="loader"></p>
            <p
                class="text-green-600 text-md"
                v-if="generatedResponse"
                v-html="generatedResponse"
            ></p>
        </div>
    </AppLayout>
</template>

<style scoped>
.loader {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    max-width: 4rem;
    margin-top: 3rem;
    margin-bottom: 3rem;
}
.loader:before,
.loader:after {
    content: "";
    position: absolute;
    border-radius: 50%;
    animation: pulsOut 1.8s ease-in-out infinite;
    filter: drop-shadow(0 0 1rem rgba(255, 255, 255, 0.75));
}
.loader:before {
    width: 100%;
    padding-bottom: 100%;
    box-shadow: inset 0 0 0 1rem #fff;
    animation-name: pulsIn;
}
.loader:after {
    width: calc(100% - 2rem);
    padding-bottom: calc(100% - 2rem);
    box-shadow: 0 0 0 0 #fff;
}

@keyframes pulsIn {
    0% {
        box-shadow: inset 0 0 0 1rem #fff;
        opacity: 1;
    }
    50%,
    100% {
        box-shadow: inset 0 0 0 0 #fff;
        opacity: 0;
    }
}

@keyframes pulsOut {
    0%,
    50% {
        box-shadow: 0 0 0 0 #fff;
        opacity: 0;
    }
    100% {
        box-shadow: 0 0 0 1rem #fff;
        opacity: 1;
    }
}
</style>
