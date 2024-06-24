<script>
import { ref } from "vue";
import { isInDestructureAssignment } from "vue/compiler-sfc";

export default {
    setup() {
        const items = ref([
            { id: 0, title: "Food and Drink", position: 0 },
            { id: 1, title: "Housing", position: 1 },
            { id: 2, title: "Transportation", position: 2 },
            { id: 3, title: "Healthcare", position: 3 },
            { id: 4, title: "Entertainment", position: 4 },
            { id: 5, title: "Other", position: 5 },
        ]);

        const getPosition = (position) => {
            return items.value.filter((item) => item.position == position);
        };

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
        };

        return { items, getPosition, startDrag, onDrop };
    },
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
    </div>
</template>
