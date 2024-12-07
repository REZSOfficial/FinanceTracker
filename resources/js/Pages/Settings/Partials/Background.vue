<script setup>
import { ref } from "vue";

// Define the SVG options
const svgs = ref([
    "/images/bg/wavey-fingerprint.svg",
    "/images/bg/protruding-squares.svg",
    "/images/bg/radiant-gradient.svg",
]);

// Selected background
const selectedBackground = ref(svgs.value[0]);

const changeBackground = (svg) => {
    selectedBackground.value = svg;
    document.body.style.backgroundImage = `url('${svg}')`;
};
</script>

<template>
    <div class="flex flex-col w-5/6 mx-auto gap-y-2">
        <div class="background-switcher">
            <!-- Options -->
            <div class="background-options">
                <div
                    v-for="(svg, index) in svgs"
                    :key="index"
                    class="background-option"
                    :style="{ backgroundImage: `url('${svg}')` }"
                    @click="changeBackground(svg)"
                ></div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.background-switcher {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.background-options {
    display: flex;
    gap: 1rem;
}

.background-option {
    width: 150px;
    height: 150px;
    background-size: cover;
    background-position: center;
    border: 1px solid #ccc;
    cursor: pointer;
}
</style>
