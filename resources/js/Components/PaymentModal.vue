<script setup>
import { faX } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import FontAwesomeSwitch from "./FontAwesomeSwitch.vue";
import RegularContainer from "./RegularContainer.vue";
const props = defineProps({
    payment: Object,
});
</script>

<template>
    <div class="w-2/3">
        <div>
            <FontAwesomeIcon
                class="p-2 px-3 text-white bg-red-600 cursor-pointer"
                :icon="faX"
                @click="$emit('close')"
            ></FontAwesomeIcon>
        </div>
    </div>
</template>
