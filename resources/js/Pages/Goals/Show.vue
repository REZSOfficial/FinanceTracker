<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faChevronDown } from "@fortawesome/free-solid-svg-icons";
import Accordion from "@/Pages/Goals/Partials/Accordion.vue";
import { ref } from "vue";
const props = defineProps({
    goals: Object,
});

const form = useForm({
    date: "",
});

const openAccordionId = ref(null);

const toggleAccordion = (goalId) => {
    if (openAccordionId.value === goalId) {
        openAccordionId.value = null;
    } else {
        openAccordionId.value = goalId;
    }
};
</script>

<template>
    <AppLayout title="Goals">
        <div
            class="flex flex-col w-2/3 p-3 mx-auto mt-8 text-sm text-gray-200 rounded-lg gap-y-2 glass min-w-fit sm:text-2xl"
        >
            <div v-for="goal in goals" :key="goal.id">
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
                    <div class="text-lg">
                        <p>
                            <strong>Description:</strong> {{ goal.description }}
                        </p>
                        <p>
                            <strong>Amount: </strong>
                            <span class="font-bold text-green-600"
                                >{{ goal.price }}$</span
                            >
                        </p>
                    </div>
                </Accordion>
            </div>
        </div>
    </AppLayout>
</template>
