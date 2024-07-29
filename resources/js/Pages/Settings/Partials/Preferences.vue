<script>
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ActionMessage from "@/Components/ActionMessage.vue";
import axios from "axios";
export default {
    props: {
        preferences: Object,
    },
    setup(props) {
        const succ = ref(false);
        const items = ref([
            {
                id: 0,
                title: "Food and Drink",
                position: props.preferences.food_and_drink,
            },
            { id: 1, title: "Housing", position: props.preferences.housing },
            {
                id: 2,
                title: "Transportation",
                position: props.preferences.transportation,
            },
            {
                id: 3,
                title: "Healthcare",
                position: props.preferences.healthcare,
            },
            {
                id: 4,
                title: "Entertainment",
                position: props.preferences.entertainment,
            },
            { id: 5, title: "Other", position: props.preferences.other },
        ]);

        const startDrag = (event, item) => {
            event.dataTransfer.dropEffect = "move";
            event.dataTransfer.effectAllowed = "move";
            event.dataTransfer.setData("itemID", item.id);
        };

        const onDrop = (event, position) => {
            const itemID = event.dataTransfer.getData("itemID");
            const item = items.value.find((item) => item.id == itemID);
            const currentItem = items.value.find(
                (item) => item.position == position
            );
            currentItem.position = item.position;
            item.position = position;
            items.value = [...items.value];
        };

        const save = () => {
            axios
                .post(route("preferences.update"), {
                    food_and_drink: items.value.find((item) => item.id == 0)
                        .position,
                    housing: items.value.find((item) => item.id == 1).position,
                    transportation: items.value.find((item) => item.id == 2)
                        .position,
                    healthcare: items.value.find((item) => item.id == 3)
                        .position,
                    entertainment: items.value.find((item) => item.id == 4)
                        .position,
                    other: items.value.find((item) => item.id == 5).position,
                })
                .then(() => {
                    succ.value = true;
                    setTimeout(() => (succ.value = false), 1000);
                });
        };

        return { items, succ, startDrag, onDrop, save };
    },
    components: { PrimaryButton, ActionMessage },
};
</script>

<template>
    <div class="flex flex-col w-5/6 mx-auto gap-y-6">
        <div
            class="flex flex-col dropzone gap-y-5"
            v-for="item in items.sort((a, b) => a.position - b.position)"
        >
            <div
                :key="item.id"
                draggable="true"
                @dragstart="startDrag($event, item)"
                @drop="onDrop($event, item.position)"
                @dragenter.prevent
                @dragover.prevent
                class="p-2 font-bold duration-100 rounded text-lighter bg-dark hover:cursor-move hover:bg-lighter hover:text-dark"
            >
                {{ item.position + 1 }}. {{ item.title }}
            </div>
        </div>
        <div class="flex flex-row my-auto">
            <ActionMessage class="w-4/6 my-auto text-center" :on="succ"
                >Saved.</ActionMessage
            >
            <PrimaryButton
                @click.prevent="save"
                class="w-4/6 bg-green-600 sm:w-2/6 hover:bg-green-700"
                >Save</PrimaryButton
            >
        </div>
    </div>
</template>
